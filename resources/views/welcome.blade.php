@php
    $locale = str_replace('_', '-', app()->getLocale());
    $isRtl = str_starts_with(app()->getLocale(), 'ar');

    $siteName = $isRtl ? 'منصة مدّكر' : 'Moddaker Academy';
    $metaTitle = $isRtl
        ? 'مدّكر | دورات تفسير القرآن والتعلم الإسلامي'
        : 'Moddaker Academy | Quran Courses & Tafsir Online';
    $metaDescription = $isRtl
        ? 'تعلم تفسير القرآن عبر دورات إسلامية أونلاين مع علماء موثوقين، دروس منظمة وشهادات إتمام تساعدك على التقدم بثقة.'
        : 'Study Quran tafsir online with trusted scholars, structured lessons, and completion certificates. Join Moddaker Academy and learn at your own pace.';
    $metaKeywords = $isRtl
        ? 'تفسير القرآن, دورات إسلامية, تعلم القرآن اونلاين, منصة مدكر, دروس القرآن'
        : 'Quran tafsir, online Quran courses, Islamic learning platform, Moddaker Academy, Quran lessons';

    $pageUrl = url()->current();
    $ogImage = asset('images/about-hero-visual.svg');
    $logoUrl = asset('images/moddaker-logo.svg');

    $heroTitle = $isRtl
        ? 'ابدأ رحلة فهم القرآن بخطة تعلم واضحة'
        : 'Start Your Quran Learning Journey with a Clear Plan';
    $heroDescription = $isRtl
        ? 'انضم إلى منصة مدّكر لتعلّم التفسير والعلوم الإسلامية عبر مسارات تعليمية عملية، دروس متدرجة، واختبارات تفاعلية.'
        : 'Join Moddaker Academy for practical Quran tafsir and Islamic studies through structured paths, progressive lessons, and interactive quizzes.';

    $orgDescription = $isRtl
        ? 'منصة تعليمية متخصصة في تفسير القرآن والعلوم الإسلامية عبر الإنترنت.'
        : 'An online learning platform specialized in Quran tafsir and Islamic studies.';

    $homeSchema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => $pageUrl.'#organization',
                'name' => $siteName,
                'url' => $pageUrl,
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $logoUrl,
                ],
                'description' => $orgDescription,
            ],
            [
                '@type' => 'WebSite',
                '@id' => $pageUrl.'#website',
                'url' => $pageUrl,
                'name' => $siteName,
                'inLanguage' => $locale,
                'publisher' => [
                    '@id' => $pageUrl.'#organization',
                ],
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => route('courses.index').'?q={search_term_string}',
                    'query-input' => 'required name=search_term_string',
                ],
            ],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ $metaDescription }}">
        <meta name="keywords" content="{{ $metaKeywords }}">
        <meta name="robots" content="index, follow, max-image-preview:large">

        <title>{{ $metaTitle }}</title>
        <link rel="canonical" href="{{ $pageUrl }}">
        <link rel="icon" type="image/svg+xml" href="{{ $logoUrl }}">
        <link rel="shortcut icon" href="{{ $logoUrl }}">
        <link rel="apple-touch-icon" href="{{ $logoUrl }}">

        <meta property="og:type" content="website">
        <meta property="og:locale" content="{{ $locale }}">
        <meta property="og:site_name" content="{{ $siteName }}">
        <meta property="og:url" content="{{ $pageUrl }}">
        <meta property="og:title" content="{{ $metaTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:image:alt" content="{{ $isRtl ? 'واجهة منصة مدّكر التعليمية' : 'Moddaker Academy learning platform preview' }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $metaTitle }}">
        <meta name="twitter:description" content="{{ $metaDescription }}">
        <meta name="twitter:image" content="{{ $ogImage }}">

        <script type="application/ld+json">
            {!! json_encode($homeSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .home-pattern-bg {
                background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230a4d40' fill-opacity='0.04'%3E%3Cpath d='M40 0l40 40-40 40L0 40 40 0zm0 10L10 40l30 30 30-30-30-30z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }

            .home-ornament {
                position: absolute;
                width: 200px;
                height: 200px;
                border: 1px solid rgba(201, 162, 39, 0.28);
                border-radius: 9999px;
            }

            @keyframes home-float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }

            .home-float {
                animation: home-float 6s ease-in-out infinite;
            }

            .home-btn-primary {
                background: linear-gradient(135deg, #0a4d40 0%, #0d6555 100%);
                transition: all 0.3s ease;
            }

            .home-btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 30px rgba(10, 77, 64, 0.26);
            }

            .home-btn-secondary {
                border: 2px solid #c9a227;
                color: #c9a227;
                transition: all 0.3s ease;
            }

            .home-btn-secondary:hover {
                background: #c9a227;
                color: #fff;
            }

            .home-progress {
                background: linear-gradient(90deg, #0a4d40 0%, #c9a227 100%);
            }
        </style>
    </head>
    <body class="bg-cream text-charcoal antialiased">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:absolute focus:start-4 focus:top-4 focus:z-50 focus:rounded-md focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-[#0a4d40]"
        >
            {{ $isRtl ? 'تخطي إلى المحتوى الرئيسي' : 'Skip to main content' }}
        </a>

        <header class="border-b border-border/70 bg-white/95">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2" aria-label="{{ $isRtl ? 'العودة إلى الصفحة الرئيسية' : 'Go to homepage' }}">
                    <img src="{{ $logoUrl }}" alt="{{ $isRtl ? 'شعار منصة مدّكر' : 'Moddaker Academy logo' }}" width="40" height="40" class="h-10 w-10" loading="eager" decoding="async">
                    <span class="text-base font-bold text-[#0a4d40]">{{ $siteName }}</span>
                </a>

                <nav aria-label="{{ $isRtl ? 'روابط الموقع الأساسية' : 'Primary site navigation' }}">
                    <ul class="flex items-center gap-3 text-sm font-semibold sm:gap-5">
                        <li><a href="{{ route('courses.index') }}" class="hover:text-[#0a4d40]">{{ $isRtl ? 'دورات تفسير القرآن' : 'Quran Courses' }}</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-[#0a4d40]">{{ $isRtl ? 'من نحن' : 'About Moddaker' }}</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-[#0a4d40]">{{ $isRtl ? 'الأسئلة الشائعة' : 'FAQ' }}</a></li>
                        <li><a href="{{ route('contact.create') }}" class="hover:text-[#0a4d40]">{{ $isRtl ? 'تواصل معنا' : 'Contact Us' }}</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main id="main-content">
            <section class="relative flex min-h-[calc(100vh-4rem)] items-center overflow-hidden pt-8 sm:pt-12 lg:pt-16" aria-labelledby="hero-title">
                <div class="pointer-events-none absolute inset-0 home-pattern-bg"></div>
                <div class="home-ornament -start-20 -top-20 opacity-60 home-float"></div>
                <div class="home-ornament -end-20 bottom-10 opacity-60 home-float" style="animation-delay: -3s;"></div>

                <div class="relative mx-auto w-full max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                    <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
                        <article class="text-center lg:text-start">
                            <div class="inline-flex items-center gap-2 rounded-full bg-[#0a4d40]/10 px-4 py-2 text-sm font-semibold text-[#0a4d40]">
                                <span class="h-2 w-2 rounded-full bg-[#c9a227]"></span>
                                <span>{{ $isRtl ? 'منصة تعليمية متخصصة' : 'Specialized Islamic Learning Platform' }}</span>
                            </div>

                            <h1 id="hero-title" class="mt-6 font-display text-4xl leading-tight text-charcoal sm:text-5xl lg:text-6xl">
                                {{ $isRtl ? 'ابدأ رحلتك في' : 'Start Your Journey to' }}
                                <span class="block text-[#0a4d40]">{{ $isRtl ? 'فهم القرآن الكريم' : 'Understand the Quran' }}</span>
                            </h1>

                            <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-charcoal/75 lg:mx-0">
                                {{ $heroDescription }}
                            </p>

                            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center lg:justify-start">
                                <a
                                    href="{{ route('register') }}"
                                    class="home-btn-primary inline-flex min-h-12 items-center justify-center rounded-xl px-7 text-base font-bold text-white"
                                    aria-label="{{ $isRtl ? 'إنشاء حساب جديد في منصة مدّكر' : 'Create a new Moddaker account' }}"
                                >
                                    {{ $isRtl ? 'ابدأ الآن' : 'Start Now' }}
                                </a>
                                <a
                                    href="{{ route('courses.index') }}"
                                    class="home-btn-secondary inline-flex min-h-12 items-center justify-center rounded-xl px-7 text-base font-bold"
                                    aria-label="{{ $isRtl ? 'استعراض جميع الدورات التعليمية' : 'Browse all learning courses' }}"
                                >
                                    {{ $isRtl ? 'تصفّح الدورات' : 'Browse Courses' }}
                                </a>
                            </div>

                            <div class="mt-10 flex items-center justify-center gap-7 lg:justify-start">
                                <div class="text-center">
                                    <p class="font-display text-3xl font-bold text-[#0a4d40]">+1000</p>
                                    <p class="text-xs text-charcoal/65">{{ $isRtl ? 'طالب وطالبة' : 'Learners' }}</p>
                                </div>
                                <span class="h-10 w-px bg-border"></span>
                                <div class="text-center">
                                    <p class="font-display text-3xl font-bold text-[#0a4d40]">+30</p>
                                    <p class="text-xs text-charcoal/65">{{ $isRtl ? 'دورة متخصصة' : 'Courses' }}</p>
                                </div>
                                <span class="h-10 w-px bg-border"></span>
                                <div class="text-center">
                                    <p class="font-display text-3xl font-bold text-[#0a4d40]">+500</p>
                                    <p class="text-xs text-charcoal/65">{{ $isRtl ? 'درس مرئي' : 'Lessons' }}</p>
                                </div>
                            </div>
                        </article>

                        <div class="relative mx-auto w-full max-w-md lg:max-w-lg">
                            <div class="relative rounded-3xl bg-white p-7 shadow-[0_30px_60px_rgba(10,77,64,0.16)] sm:p-9">
                                <div class="absolute start-0 top-0 h-24 w-24 rounded-bl-3xl rounded-tr-3xl bg-gradient-to-br from-[#c9a227]/25 to-transparent"></div>

                                <div class="relative">
                                    <div class="mb-6 text-center">
                                        <p class="mb-3 inline-flex rounded-full bg-[#0a4d40]/10 px-4 py-1 text-sm font-semibold text-[#0a4d40]">
                                            {{ $isRtl ? 'آخر ما تمت دراسته' : 'Last Studied Lesson' }}
                                        </p>
                                        <h3 class="font-display text-2xl text-charcoal">{{ $isRtl ? 'سورة البقرة' : 'Surah Al-Baqarah' }}</h3>
                                        <p class="text-sm text-charcoal/60">{{ $isRtl ? 'الآيات ١-٥' : 'Verses 1-5' }}</p>
                                    </div>

                                    <div class="mb-6 rounded-2xl bg-[#f0ebe0] p-4">
                                        <div class="mb-2 flex items-center justify-between text-sm">
                                            <span class="text-charcoal/70">{{ $isRtl ? 'تقدمك في الدورة' : 'Course Progress' }}</span>
                                            <span class="font-bold text-[#0a4d40]">65%</span>
                                        </div>
                                        <div class="h-2 overflow-hidden rounded-full bg-white">
                                            <div class="home-progress h-full rounded-full" style="width: 65%"></div>
                                        </div>
                                    </div>

                                    <a
                                        href="{{ route('courses.index') }}"
                                        class="home-btn-primary inline-flex min-h-11 w-full items-center justify-center rounded-xl text-sm font-bold text-white"
                                        aria-label="{{ $isRtl ? 'الانتقال إلى صفحة الدورات ومتابعة التعلم' : 'Open courses page and continue learning' }}"
                                    >
                                        {{ $isRtl ? 'تابع التعلم' : 'Continue Learning' }}
                                    </a>
                                </div>
                            </div>

                            <div class="absolute -end-4 -top-4 rounded-xl bg-[#c9a227] p-3 text-white shadow-lg home-float">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>

                            <div class="absolute -bottom-4 -start-4 rounded-xl bg-[#0a4d40] p-3 text-white shadow-lg home-float" style="animation-delay: -2s;">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto w-full max-w-7xl px-4 pb-8 sm:px-6 lg:px-8" aria-labelledby="benefits-title">
                <h2 id="benefits-title" class="text-2xl font-bold text-charcoal sm:text-3xl">
                    {{ $isRtl ? 'لماذا تختار منصة مدّكر؟' : 'Why choose Moddaker Academy?' }}
                </h2>
                <div class="mt-5 grid gap-4 md:grid-cols-3">
                    <article class="rounded-2xl border border-border bg-white p-5 shadow-sm">
                        <h3 class="text-lg font-bold text-charcoal">{{ $isRtl ? 'منهج واضح ومتصاعد' : 'Structured Learning Paths' }}</h3>
                        <p class="mt-2 text-sm leading-7 text-charcoal/70">
                            {{ $isRtl ? 'مسارات تعليمية متدرجة تساعدك على فهم التفسير خطوة بخطوة دون تشتت.' : 'Progressive course paths help you learn tafsir step by step without overload.' }}
                        </p>
                    </article>
                    <article class="rounded-2xl border border-border bg-white p-5 shadow-sm">
                        <h3 class="text-lg font-bold text-charcoal">{{ $isRtl ? 'مدرسون موثوقون' : 'Trusted Scholars and Instructors' }}</h3>
                        <p class="mt-2 text-sm leading-7 text-charcoal/70">
                            {{ $isRtl ? 'تعلم العلوم الإسلامية من مختصين مع خبرة تعليمية ومنهج علمي معتمد.' : 'Study with qualified scholars who teach with a clear and reliable methodology.' }}
                        </p>
                    </article>
                    <article class="rounded-2xl border border-border bg-white p-5 shadow-sm">
                        <h3 class="text-lg font-bold text-charcoal">{{ $isRtl ? 'اختبارات وشهادات' : 'Quizzes and Certificates' }}</h3>
                        <p class="mt-2 text-sm leading-7 text-charcoal/70">
                            {{ $isRtl ? 'اختبر فهمك بعد كل وحدة واحصل على شهادات إتمام تدعم تقدمك العلمي.' : 'Validate your understanding with quizzes and earn completion certificates.' }}
                        </p>
                    </article>
                </div>
            </section>

            <section class="mx-auto w-full max-w-7xl px-4 pb-8 sm:px-6 lg:px-8" aria-labelledby="paths-title">
                <h2 id="paths-title" class="text-2xl font-bold text-charcoal sm:text-3xl">
                    {{ $isRtl ? 'مسارات تعلم مقترحة' : 'Recommended Learning Paths' }}
                </h2>
                <div class="mt-5 grid gap-4 md:grid-cols-3">
                    <article class="overflow-hidden rounded-2xl border border-border bg-white shadow-sm">
                        <img
                            src="{{ asset('images/about-hero-visual.svg') }}"
                            alt="{{ $isRtl ? 'مسار تأسيسي في تفسير القرآن للمبتدئين' : 'Foundational Quran tafsir path for beginners' }}"
                            width="640"
                            height="360"
                            class="h-44 w-full object-cover"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="p-4">
                            <h3 class="text-base font-bold text-charcoal">{{ $isRtl ? 'المسار التأسيسي في التفسير' : 'Foundations of Quran Tafsir' }}</h3>
                            <p class="mt-2 text-sm leading-7 text-charcoal/70">
                                {{ $isRtl ? 'ابدأ من الأساسيات لفهم المعاني والسياقات بأسلوب سهل ومنظم.' : 'Start with core concepts to understand meanings and context with clarity.' }}
                            </p>
                            <a href="{{ route('courses.index') }}" class="mt-3 inline-flex text-sm font-semibold text-[#0a4d40] underline decoration-[#0a4d40]/40 underline-offset-4" aria-label="{{ $isRtl ? 'الانتقال إلى صفحة الدورات للمسار التأسيسي' : 'Go to courses page for tafsir foundations' }}">
                                {{ $isRtl ? 'عرض دورات هذا المسار' : 'View path courses' }}
                            </a>
                        </div>
                    </article>

                    <article class="overflow-hidden rounded-2xl border border-border bg-white shadow-sm">
                        <img
                            src="{{ asset('images/about-hero-visual.svg') }}"
                            alt="{{ $isRtl ? 'مسار مهارات التدبر والتطبيق العملي' : 'Tadabbur skills and practical application path' }}"
                            width="640"
                            height="360"
                            class="h-44 w-full object-cover"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="p-4">
                            <h3 class="text-base font-bold text-charcoal">{{ $isRtl ? 'مهارات التدبر العملي' : 'Practical Tadabbur Skills' }}</h3>
                            <p class="mt-2 text-sm leading-7 text-charcoal/70">
                                {{ $isRtl ? 'تعلم كيف تربط الآيات بواقعك اليومي من خلال تطبيقات عملية موجهة.' : 'Learn to apply Quranic meanings in daily life through guided practice.' }}
                            </p>
                            <a href="{{ route('about') }}" class="mt-3 inline-flex text-sm font-semibold text-[#0a4d40] underline decoration-[#0a4d40]/40 underline-offset-4" aria-label="{{ $isRtl ? 'اقرأ عن منهج منصة مدّكر التعليمي' : 'Read about Moddaker teaching methodology' }}">
                                {{ $isRtl ? 'اقرأ عن منهج المنصة' : 'Read our methodology' }}
                            </a>
                        </div>
                    </article>

                    <article class="overflow-hidden rounded-2xl border border-border bg-white shadow-sm">
                        <img
                            src="{{ asset('images/about-hero-visual.svg') }}"
                            alt="{{ $isRtl ? 'مسار تقييم التقدم والإنجازات التعليمية' : 'Learning progress and achievement path' }}"
                            width="640"
                            height="360"
                            class="h-44 w-full object-cover"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="p-4">
                            <h3 class="text-base font-bold text-charcoal">{{ $isRtl ? 'التقييم والشهادات' : 'Assessment and Certificates' }}</h3>
                            <p class="mt-2 text-sm leading-7 text-charcoal/70">
                                {{ $isRtl ? 'تابع تقدمك الأكاديمي من خلال اختبارات منتظمة وشهادات موثقة.' : 'Track progress with regular assessments and verified completion certificates.' }}
                            </p>
                            <a href="{{ route('faq') }}" class="mt-3 inline-flex text-sm font-semibold text-[#0a4d40] underline decoration-[#0a4d40]/40 underline-offset-4" aria-label="{{ $isRtl ? 'الانتقال إلى صفحة الأسئلة الشائعة حول الشهادات' : 'Go to FAQ page about certificates and enrollment' }}">
                                {{ $isRtl ? 'الأسئلة الشائعة حول الشهادات' : 'FAQ about certificates' }}
                            </a>
                        </div>
                    </article>
                </div>
            </section>

            <section class="mx-auto w-full max-w-7xl px-4 pb-14 sm:px-6 lg:px-8" aria-labelledby="cta-title">
                <article class="rounded-2xl bg-[#0a4d40] px-6 py-8 text-white">
                    <h2 id="cta-title" class="text-2xl font-bold sm:text-3xl">
                        {{ $isRtl ? 'هل تحتاج مساعدة في اختيار الدورة المناسبة؟' : 'Need help choosing the right course?' }}
                    </h2>
                    <p class="mt-3 max-w-3xl text-sm leading-8 text-white/90">
                        {{ $isRtl ? 'تواصل مع فريق الدعم للحصول على توصية تعليمية تناسب مستواك وأهدافك في تعلم القرآن.' : 'Contact our support team for a learning recommendation that matches your level and goals.' }}
                    </p>
                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('contact.create') }}" class="inline-flex min-h-11 items-center rounded-xl bg-white px-5 text-sm font-bold text-[#0a4d40]" aria-label="{{ $isRtl ? 'التواصل مع فريق منصة مدّكر' : 'Contact Moddaker support team' }}">
                            {{ $isRtl ? 'تواصل مع الدعم' : 'Contact Support' }}
                        </a>
                        <a href="{{ route('courses.index') }}" class="inline-flex min-h-11 items-center rounded-xl border border-white/40 px-5 text-sm font-bold text-white" aria-label="{{ $isRtl ? 'الانتقال إلى صفحة جميع الدورات' : 'Go to all courses page' }}">
                            {{ $isRtl ? 'عرض كل الدورات' : 'View All Courses' }}
                        </a>
                    </div>
                </article>
            </section>
        </main>

        <footer class="border-t border-border/70 bg-white">
            <div class="mx-auto flex w-full max-w-7xl flex-col gap-4 px-4 py-6 text-sm sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p class="text-charcoal/70">
                    {{ $isRtl ? 'جميع الحقوق محفوظة لمنصة مدّكر' : 'All rights reserved for Moddaker Academy' }} &copy; {{ now()->year }}
                </p>
                <nav aria-label="{{ $isRtl ? 'روابط تذييل الموقع' : 'Footer links' }}">
                    <ul class="flex flex-wrap gap-4 font-semibold text-[#0a4d40]">
                        <li><a href="{{ route('about') }}">{{ $isRtl ? 'تعرف على منصة مدّكر التعليمية' : 'Learn about Moddaker Academy' }}</a></li>
                        <li><a href="{{ route('faq') }}">{{ $isRtl ? 'الأسئلة الشائعة حول التسجيل والدورات' : 'FAQ about enrollment and courses' }}</a></li>
                        <li><a href="{{ route('contact.create') }}">{{ $isRtl ? 'تواصل مع فريق الدعم التعليمي' : 'Contact the support team' }}</a></li>
                    </ul>
                </nav>
            </div>
        </footer>
    </body>
</html>
