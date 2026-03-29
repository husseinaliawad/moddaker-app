<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\Lesson;
use App\Models\Page;
use App\Models\Progress;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@moddaker.test'],
            [
                'name' => 'Admin Moddaker',
                'password' => Hash::make('password'),
                'locale' => 'ar',
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['admin']);

        $instructorUser = User::query()->updateOrCreate(
            ['email' => 'instructor@moddaker.test'],
            [
                'name' => 'Dr. Abdullah',
                'password' => Hash::make('password'),
                'locale' => 'ar',
                'email_verified_at' => now(),
            ]
        );
        $instructorUser->syncRoles(['instructor']);

        $student = User::query()->updateOrCreate(
            ['email' => 'student@moddaker.test'],
            [
                'name' => 'Student One',
                'password' => Hash::make('password'),
                'locale' => 'ar',
                'email_verified_at' => now(),
            ]
        );
        $student->syncRoles(['student']);

        $instructor = Instructor::query()->updateOrCreate(
            ['user_id' => $instructorUser->id],
            [
                'name' => $instructorUser->name,
                'title' => 'مدرس التفسير',
                'bio' => 'متخصص في علوم القرآن وتدريس التفسير.',
                'is_active' => true,
            ]
        );

        $categories = collect([
            [
                'slug' => 'tafsir-basics',
                'ar' => ['name' => 'أساسيات التفسير', 'description' => 'مدخل مبسط لعلم التفسير.'],
                'en' => ['name' => 'Tafsir Basics', 'description' => 'A practical introduction to tafsir science.'],
            ],
            [
                'slug' => 'quran-sciences',
                'ar' => ['name' => 'علوم القرآن', 'description' => 'دورات متخصصة في علوم القرآن.'],
                'en' => ['name' => 'Quran Sciences', 'description' => 'Specialized Quran sciences tracks.'],
            ],
        ])->map(function (array $item, int $index) {
            $category = Category::query()->updateOrCreate(
                ['slug' => $item['slug']],
                ['is_active' => true, 'sort_order' => $index + 1]
            );

            foreach (['ar', 'en'] as $locale) {
                $category->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'name' => $item[$locale]['name'],
                        'description' => $item[$locale]['description'],
                    ]
                );
            }

            return $category;
        });

        $coursesData = [
            [
                'slug' => 'mukhtasar-tafsir',
                'level' => 'beginner',
                'category_slug' => 'tafsir-basics',
                'duration_minutes' => 900,
                'ar' => [
                    'title' => 'المختصر في تفسير القرآن',
                    'excerpt' => 'دورة تأسيسية شاملة لفهم معاني القرآن الكريم.',
                    'description' => 'تعلم أصول التفسير بطريقة منظمة مع تطبيقات عملية على الآيات.',
                ],
                'en' => [
                    'title' => 'Mukhtasar Tafsir',
                    'excerpt' => 'A foundational course for understanding Quran meanings.',
                    'description' => 'Learn tafsir fundamentals with practical verse examples.',
                ],
                'lessons' => [
                    [
                        'slug' => 'introduction-tafsir',
                        'order_column' => 1,
                        'duration_minutes' => 25,
                        'ar' => ['title' => 'مقدمة في علم التفسير', 'summary' => 'تعريف التفسير وأهميته.', 'content' => 'محتوى تمهيدي في علم التفسير.'],
                        'en' => ['title' => 'Introduction to Tafsir', 'summary' => 'Definition and value of tafsir.', 'content' => 'Introductory lesson content.'],
                    ],
                    [
                        'slug' => 'sources-tafsir',
                        'order_column' => 2,
                        'duration_minutes' => 30,
                        'ar' => ['title' => 'مصادر التفسير', 'summary' => 'المصادر الأساسية لفهم الآيات.', 'content' => 'بيان أهم المصادر المعتمدة.'],
                        'en' => ['title' => 'Sources of Tafsir', 'summary' => 'Primary resources for understanding verses.', 'content' => 'Overview of core tafsir resources.'],
                    ],
                    [
                        'slug' => 'practical-reading',
                        'order_column' => 3,
                        'duration_minutes' => 35,
                        'ar' => ['title' => 'قراءة تطبيقية', 'summary' => 'تطبيق عملي على مجموعة آيات.', 'content' => 'تطبيقات عملية مع توجيهات منهجية.'],
                        'en' => ['title' => 'Practical Reading', 'summary' => 'Applied reading over selected verses.', 'content' => 'Practical exercises and guidance.'],
                    ],
                ],
            ],
            [
                'slug' => 'asbab-alnuzul',
                'level' => 'intermediate',
                'category_slug' => 'quran-sciences',
                'duration_minutes' => 600,
                'ar' => [
                    'title' => 'أسباب النزول',
                    'excerpt' => 'فهم السياق التاريخي لنزول الآيات.',
                    'description' => 'دراسة منهجية لأسباب النزول وأثرها في الفهم الصحيح.',
                ],
                'en' => [
                    'title' => 'Asbab Al-Nuzul',
                    'excerpt' => 'Understand the historical context of revelation.',
                    'description' => 'Structured study of causes of revelation and their impact.',
                ],
                'lessons' => [
                    [
                        'slug' => 'concept-asbab',
                        'order_column' => 1,
                        'duration_minutes' => 25,
                        'ar' => ['title' => 'مفهوم أسباب النزول', 'summary' => 'المفهوم والأهمية.', 'content' => 'شرح المفهوم مع أمثلة.'],
                        'en' => ['title' => 'Concept of Asbab', 'summary' => 'Definition and importance.', 'content' => 'Concept explained with examples.'],
                    ],
                    [
                        'slug' => 'examples-asbab',
                        'order_column' => 2,
                        'duration_minutes' => 30,
                        'ar' => ['title' => 'أمثلة تطبيقية', 'summary' => 'أمثلة من السور.', 'content' => 'دراسة حالات عملية.'],
                        'en' => ['title' => 'Applied Examples', 'summary' => 'Examples from selected surahs.', 'content' => 'Case-based practical study.'],
                    ],
                ],
            ],
        ];

        $courses = collect($coursesData)->map(function (array $courseData) use ($categories, $instructor) {
            $category = $categories->firstWhere('slug', $courseData['category_slug']);

            $course = Course::query()->updateOrCreate(
                ['slug' => $courseData['slug']],
                [
                    'category_id' => $category?->id,
                    'instructor_id' => $instructor->id,
                    'level' => $courseData['level'],
                    'duration_minutes' => $courseData['duration_minutes'],
                    'price' => 0,
                    'is_published' => true,
                    'is_featured' => true,
                    'published_at' => now(),
                ]
            );

            foreach (['ar', 'en'] as $locale) {
                $course->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'title' => $courseData[$locale]['title'],
                        'excerpt' => $courseData[$locale]['excerpt'],
                        'description' => $courseData[$locale]['description'],
                    ]
                );
            }

            foreach ($courseData['lessons'] as $lessonData) {
                $lesson = Lesson::query()->updateOrCreate(
                    ['course_id' => $course->id, 'slug' => $lessonData['slug']],
                    [
                        'order_column' => $lessonData['order_column'],
                        'duration_minutes' => $lessonData['duration_minutes'],
                        'is_published' => true,
                        'is_free_preview' => $lessonData['order_column'] === 1,
                    ]
                );

                foreach (['ar', 'en'] as $locale) {
                    $lesson->translations()->updateOrCreate(
                        ['locale' => $locale],
                        [
                            'title' => $lessonData[$locale]['title'],
                            'summary' => $lessonData[$locale]['summary'],
                            'content' => $lessonData[$locale]['content'],
                        ]
                    );
                }
            }

            $course->update(['lessons_count' => $course->lessons()->count()]);

            return $course;
        });

        $firstCourse = $courses->first();
        $secondCourse = $courses->skip(1)->first();

        if ($firstCourse) {
            $enrollment = Enrollment::query()->updateOrCreate(
                ['user_id' => $student->id, 'course_id' => $firstCourse->id],
                ['status' => 'completed', 'enrolled_at' => now()->subDays(15), 'completed_at' => now()->subDays(2), 'progress_percent' => 100]
            );

            foreach ($firstCourse->lessons as $lesson) {
                Progress::query()->updateOrCreate(
                    ['enrollment_id' => $enrollment->id, 'lesson_id' => $lesson->id],
                    ['is_completed' => true, 'completed_at' => now()->subDays(rand(3, 10))]
                );
            }

            Certificate::query()->updateOrCreate(
                ['user_id' => $student->id, 'course_id' => $firstCourse->id],
                [
                    'serial_number' => 'MDK-'.Str::upper(Str::random(10)),
                    'issued_at' => now()->subDay(),
                ]
            );
        }

        if ($secondCourse) {
            $enrollment = Enrollment::query()->updateOrCreate(
                ['user_id' => $student->id, 'course_id' => $secondCourse->id],
                ['status' => 'active', 'enrolled_at' => now()->subDays(7), 'progress_percent' => 50]
            );

            $firstLesson = $secondCourse->lessons()->orderBy('order_column')->first();
            if ($firstLesson) {
                Progress::query()->updateOrCreate(
                    ['enrollment_id' => $enrollment->id, 'lesson_id' => $firstLesson->id],
                    ['is_completed' => true, 'completed_at' => now()->subDays(1)]
                );
            }
        }

        $aboutPage = Page::query()->updateOrCreate(['slug' => 'about'], ['template' => 'default', 'is_published' => true]);
        $faqPage = Page::query()->updateOrCreate(['slug' => 'faq'], ['template' => 'default', 'is_published' => true]);

        $aboutPage->translations()->updateOrCreate(
            ['locale' => 'ar'],
            ['title' => 'عن المنصة', 'content' => 'منصة مُدّكر تسعى لنشر علم التفسير بشكل ميسر وعصري.']
        );
        $aboutPage->translations()->updateOrCreate(
            ['locale' => 'en'],
            ['title' => 'About Platform', 'content' => 'Moddaker aims to spread Quran tafsir knowledge in a modern and simple way.']
        );

        $faqPage->translations()->updateOrCreate(
            ['locale' => 'ar'],
            ['title' => 'الأسئلة الشائعة', 'content' => 'صفحة الأسئلة الشائعة.']
        );
        $faqPage->translations()->updateOrCreate(
            ['locale' => 'en'],
            ['title' => 'FAQ', 'content' => 'Frequently asked questions page.']
        );

        Setting::putValue('home.hero', [
            'badge' => ['ar' => 'منصة تعليمية متخصصة', 'en' => 'Specialized Learning Platform'],
            'title' => ['ar' => 'ابدأ رحلتك في فهم القرآن الكريم', 'en' => 'Start Your Journey in Understanding the Quran'],
            'description' => ['ar' => 'تعلم التفسير بأسلوب مبسط ومنهجي مع نخبة من المدرسين.', 'en' => 'Learn tafsir with a clear and practical approach.'],
        ], 'home');

        Setting::putValue('home.stats', [
            ['value' => '5000+', 'label' => ['ar' => 'طالب وطالبة', 'en' => 'Students']],
            ['value' => '30+', 'label' => ['ar' => 'دورة متخصصة', 'en' => 'Specialized Courses']],
            ['value' => '500+', 'label' => ['ar' => 'درس مرئي', 'en' => 'Video Lessons']],
        ], 'home');

        Setting::putValue('home.why_items', [
            ['title' => ['ar' => 'شرح مبسط', 'en' => 'Clear Teaching'], 'description' => ['ar' => 'محتوى واضح لجميع المستويات.', 'en' => 'Clear content for all levels.']],
            ['title' => ['ar' => 'متابعة التقدم', 'en' => 'Track Progress'], 'description' => ['ar' => 'لوحة متكاملة لمتابعة إنجازك.', 'en' => 'Complete dashboard to monitor your learning.']],
            ['title' => ['ar' => 'اختبارات تفاعلية', 'en' => 'Interactive Quizzes'], 'description' => ['ar' => 'اختبارات بعد كل درس.', 'en' => 'Assessments after every lesson.']],
            ['title' => ['ar' => 'شهادات', 'en' => 'Certificates'], 'description' => ['ar' => 'شهادات بعد الإتمام.', 'en' => 'Certificates on completion.']],
        ], 'home');

        Setting::putValue('home.cta', [
            'title' => ['ar' => 'ابدأ رحلتك اليوم', 'en' => 'Start Today'],
            'description' => ['ar' => 'انضم إلى آلاف الطلاب وابدأ التعلم الآن.', 'en' => 'Join thousands of learners and start now.'],
        ], 'home');

        Setting::putValue('site.contact', [
            'email' => 'info@moddaker.com',
            'phone' => '+966500000000',
            'address' => ['ar' => 'الرياض - المملكة العربية السعودية', 'en' => 'Riyadh - Saudi Arabia'],
        ], 'site');

        Setting::putValue('site.social_links', [
            ['platform' => 'X', 'url' => '#'],
            ['platform' => 'YouTube', 'url' => '#'],
            ['platform' => 'Telegram', 'url' => '#'],
        ], 'site');

        ContactMessage::query()->updateOrCreate(
            ['email' => 'visitor@example.com'],
            [
                'name' => 'Visitor',
                'subject' => 'استفسار عن الدورات',
                'message' => 'أرغب بمعرفة المزيد عن مسار المبتدئين.',
                'is_read' => false,
            ]
        );

        $firstLesson = $firstCourse?->lessons()->orderBy('order_column')->first();
        if ($firstCourse && $firstLesson) {
            $quiz = Quiz::query()->updateOrCreate(
                ['lesson_id' => $firstLesson->id],
                [
                    'course_id' => $firstCourse->id,
                    'title' => 'اختبار تمهيدي',
                    'passing_score' => 70,
                    'is_published' => true,
                ]
            );

            QuizQuestion::query()->updateOrCreate(
                ['quiz_id' => $quiz->id, 'question' => 'ما معنى التفسير؟'],
                [
                    'options' => ['بيان معاني الآيات', 'علم النحو', 'علم الفرائض', 'السيرة'],
                    'correct_answer' => 'بيان معاني الآيات',
                    'points' => 1,
                ]
            );
        }
    }
}
