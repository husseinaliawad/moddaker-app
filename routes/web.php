<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Admin\InstructorController as AdminInstructorController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CourseController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::scopeBindings()->group(function (): void {
    Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course:slug}/lessons/{lesson:slug}', [CourseController::class, 'lesson'])->name('lessons.show');
});

Route::post('/courses/{course:slug}/lessons/{lesson:slug}/complete', [CourseController::class, 'completeLesson'])
    ->middleware('auth')
    ->name('lessons.complete');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', function () {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('student.dashboard');
    })->name('dashboard');

    Route::prefix('student')->name('student.')->group(function (): void {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/courses', [StudentDashboardController::class, 'courses'])->name('courses');
        Route::get('/progress', [StudentDashboardController::class, 'progress'])->name('progress');
        Route::get('/certificates', [StudentDashboardController::class, 'certificates'])->name('certificates');
        Route::get('/profile', [StudentProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function (): void {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('courses', AdminCourseController::class)->except(['show']);
        Route::resource('lessons', AdminLessonController::class)->except(['show']);
        Route::resource('instructors', AdminInstructorController::class)->except(['show']);
        Route::resource('pages', AdminPageController::class)->except(['show']);
        Route::resource('quizzes', AdminQuizController::class)->except(['show']);

        Route::get('/roles', [AdminRoleController::class, 'index'])->name('roles.index');
        Route::post('/roles', [AdminRoleController::class, 'store'])->name('roles.store');
        Route::patch('/roles/{role}', [AdminRoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [AdminRoleController::class, 'destroy'])->name('roles.destroy');

        Route::get('/enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments.index');
        Route::patch('/enrollments/{enrollment}', [AdminEnrollmentController::class, 'update'])->name('enrollments.update');

        Route::get('/certificates', [AdminCertificateController::class, 'index'])->name('certificates.index');
        Route::post('/certificates', [AdminCertificateController::class, 'store'])->name('certificates.store');

        Route::get('/contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'update'])->name('contact-messages.update');
        Route::delete('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'store'])->name('settings.store');
        Route::put('/settings/{setting}', [AdminSettingController::class, 'update'])->name('settings.update');
        Route::delete('/settings/{setting}', [AdminSettingController::class, 'destroy'])->name('settings.destroy');
    });

require __DIR__.'/auth.php';
