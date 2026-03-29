<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $now = CarbonImmutable::now();
        $currentPeriodStart = $now->startOfDay()->subDays(6);
        $previousPeriodStart = $currentPeriodStart->subDays(7);
        $previousPeriodEnd = $currentPeriodStart->subSecond();

        $totalUsers = User::query()->count();
        $totalCourses = Course::query()->count();
        $totalEnrollments = Enrollment::query()->count();
        $totalMessages = ContactMessage::query()->count();
        $unreadMessages = ContactMessage::query()->where('is_read', false)->count();

        $publishedCourses = Course::query()->where('is_published', true)->count();
        $featuredCourses = Course::query()->where('is_featured', true)->count();
        $draftCourses = max(0, $totalCourses - $publishedCourses);

        $activeEnrollments = Enrollment::query()->where('status', 'active')->count();
        $completedEnrollments = Enrollment::query()->where('status', 'completed')->count();
        $cancelledEnrollments = Enrollment::query()->where('status', 'cancelled')->count();

        $newUsersCurrent = User::query()->whereBetween('created_at', [$currentPeriodStart, $now])->count();
        $newUsersPrevious = User::query()->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count();
        $newCoursesCurrent = Course::query()->whereBetween('created_at', [$currentPeriodStart, $now])->count();
        $newCoursesPrevious = Course::query()->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count();
        $newMessagesCurrent = ContactMessage::query()->whereBetween('created_at', [$currentPeriodStart, $now])->count();
        $newMessagesPrevious = ContactMessage::query()->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count();

        $enrollmentDateExpression = 'COALESCE(enrolled_at, created_at)';
        $newEnrollmentsCurrent = Enrollment::query()
            ->whereBetween(DB::raw($enrollmentDateExpression), [$currentPeriodStart, $now])
            ->count();
        $newEnrollmentsPrevious = Enrollment::query()
            ->whereBetween(DB::raw($enrollmentDateExpression), [$previousPeriodStart, $previousPeriodEnd])
            ->count();

        $stats = [
            'users' => [
                'value' => $totalUsers,
                'period_count' => $newUsersCurrent,
            ] + $this->buildTrend($newUsersCurrent, $newUsersPrevious),
            'courses' => [
                'value' => $totalCourses,
                'secondary' => $publishedCourses,
                'period_count' => $newCoursesCurrent,
            ] + $this->buildTrend($newCoursesCurrent, $newCoursesPrevious),
            'enrollments' => [
                'value' => $totalEnrollments,
                'secondary' => $activeEnrollments,
                'period_count' => $newEnrollmentsCurrent,
            ] + $this->buildTrend($newEnrollmentsCurrent, $newEnrollmentsPrevious),
            'messages' => [
                'value' => $unreadMessages,
                'secondary' => $newMessagesCurrent,
                'period_count' => $newMessagesCurrent,
            ] + $this->buildTrend($newMessagesCurrent, $newMessagesPrevious),
        ];

        $recentEnrollments = Enrollment::query()
            ->with(['user:id,name', 'course', 'course.translations'])
            ->orderByRaw($enrollmentDateExpression.' desc')
            ->take(6)
            ->get();

        $recentMessages = ContactMessage::query()
            ->latest()
            ->take(6)
            ->get();

        $activity = $this->buildActivitySeries($currentPeriodStart, $now, $enrollmentDateExpression);
        $chartMax = max(
            1,
            (int) $activity
                ->flatMap(fn (array $day): array => [$day['users'], $day['enrollments'], $day['messages']])
                ->max()
        );

        $activityTotals = [
            'users' => $activity->sum('users'),
            'enrollments' => $activity->sum('enrollments'),
            'messages' => $activity->sum('messages'),
        ];

        $performance = [
            'publishing_rate' => $totalCourses > 0 ? (int) round(($publishedCourses / $totalCourses) * 100) : 0,
            'completion_rate' => $totalEnrollments > 0 ? (int) round(($completedEnrollments / $totalEnrollments) * 100) : 0,
            'response_rate' => $totalMessages > 0
                ? (int) round((ContactMessage::query()->whereNotNull('replied_at')->count() / $totalMessages) * 100)
                : 0,
            'average_progress' => (int) round((float) (Enrollment::query()->avg('progress_percent') ?? 0)),
            'draft_courses' => $draftCourses,
            'featured_courses' => $featuredCourses,
            'active_enrollments' => $activeEnrollments,
            'completed_enrollments' => $completedEnrollments,
            'cancelled_enrollments' => $cancelledEnrollments,
            'unread_rate' => $totalMessages > 0 ? (int) round(($unreadMessages / $totalMessages) * 100) : 0,
        ];

        $topCourses = Course::query()
            ->with('translations')
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        $search = trim((string) $request->string('q'));

        $searchResults = [
            'query' => $search,
            'users' => collect(),
            'courses' => collect(),
            'messages' => collect(),
            'total' => 0,
        ];

        if ($search !== '') {
            $searchResults['users'] = User::query()
                ->where(function ($query) use ($search): void {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->latest()
                ->take(5)
                ->get(['id', 'name', 'email', 'avatar_path']);

            $searchResults['courses'] = Course::query()
                ->with('translations')
                ->where(function ($query) use ($search): void {
                    $query
                        ->where('slug', 'like', "%{$search}%")
                        ->orWhereHas('translations', function ($translationQuery) use ($search): void {
                            $translationQuery->where('title', 'like', "%{$search}%");
                        });
                })
                ->latest()
                ->take(5)
                ->get();

            $searchResults['messages'] = ContactMessage::query()
                ->where(function ($query) use ($search): void {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%");
                })
                ->latest()
                ->take(5)
                ->get(['id', 'name', 'email', 'subject', 'is_read', 'created_at']);

            $searchResults['total'] = $searchResults['users']->count()
                + $searchResults['courses']->count()
                + $searchResults['messages']->count();
        }

        return view('admin.dashboard', compact(
            'stats',
            'recentEnrollments',
            'recentMessages',
            'activity',
            'activityTotals',
            'chartMax',
            'performance',
            'topCourses',
            'searchResults'
        ));
    }

    private function buildTrend(int $current, int $previous): array
    {
        $difference = $current - $previous;

        return [
            'difference' => $difference,
            'direction' => $difference > 0 ? 'up' : ($difference < 0 ? 'down' : 'flat'),
            'percentage' => $previous > 0
                ? (int) round(($difference / $previous) * 100)
                : ($current > 0 ? 100 : 0),
        ];
    }

    private function buildActivitySeries(
        CarbonImmutable $start,
        CarbonImmutable $end,
        string $enrollmentDateExpression
    ): Collection {
        $users = User::query()
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as day, COUNT(*) as aggregate')
            ->groupBy('day')
            ->pluck('aggregate', 'day')
            ->map(fn ($value): int => (int) $value)
            ->all();

        $enrollments = Enrollment::query()
            ->whereBetween(DB::raw($enrollmentDateExpression), [$start, $end])
            ->selectRaw('DATE('.$enrollmentDateExpression.') as day, COUNT(*) as aggregate')
            ->groupBy('day')
            ->pluck('aggregate', 'day')
            ->map(fn ($value): int => (int) $value)
            ->all();

        $messages = ContactMessage::query()
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as day, COUNT(*) as aggregate')
            ->groupBy('day')
            ->pluck('aggregate', 'day')
            ->map(fn ($value): int => (int) $value)
            ->all();

        return collect(range(0, 6))->map(function (int $offset) use ($start, $users, $enrollments, $messages): array {
            $date = $start->addDays($offset)->locale(app()->getLocale());
            $key = $date->toDateString();

            return [
                'date' => $key,
                'label' => $date->isoFormat('dd'),
                'full_label' => $date->isoFormat('D MMM'),
                'users' => (int) ($users[$key] ?? 0),
                'enrollments' => (int) ($enrollments[$key] ?? 0),
                'messages' => (int) ($messages[$key] ?? 0),
            ];
        });
    }
}
