# Moddaker Platform (Laravel)

منصة تعليمية لفهم القرآن الكريم وتعلّم التفسير مبنية بـ Laravel.

## Tech Stack
- Laravel 12
- Blade + Tailwind + Vite
- MySQL
- Laravel Breeze (auth)
- Spatie Laravel Permission (roles/permissions)
- Localization (AR/EN) + RTL/LTR

## Setup
1. `composer install`
2. `npm install`
3. انسخ `.env.example` إلى `.env` واضبط قاعدة البيانات
4. `php artisan key:generate`
5. `php artisan migrate --seed`
6. `php artisan storage:link`
7. `npm run dev` (أو `npm run build`)
8. `php artisan serve`

## Demo Accounts
- Admin: `admin@moddaker.test` / `password`
- Instructor: `instructor@moddaker.test` / `password`
- Student: `student@moddaker.test` / `password`

## Main Routes
- `/` الصفحة الرئيسية
- `/courses` جميع الدورات
- `/courses/{course}` تفاصيل الدورة
- `/courses/{course}/lessons/{lesson}` صفحة الدرس
- `/about` / `/faq` / `/contact`
- `/student/*` لوحة الطالب
- `/admin/*` لوحة الإدارة

## Implemented Modules
- واجهة عامة ديناميكية مرتبطة بقاعدة البيانات
- نظام تسجيل/دخول/استعادة كلمة المرور
- أدوار: `admin`, `student`, `instructor`
- إدارة المستخدمين
- إدارة الأدوار والصلاحيات
- إدارة التصنيفات
- إدارة الدورات + الترجمات
- إدارة الدروس + الترجمات
- إدارة المدرسين
- إدارة التسجيلات
- إدارة الشهادات
- إدارة صفحات CMS + الترجمات
- إدارة الإعدادات العامة (Key/Value JSON)
- إدارة رسائل التواصل
- إدارة الاختبارات (نسخة أولى)

## Localization
- ملفات ترجمة كاملة في:
  - `lang/ar`
  - `lang/en`
- تبديل اللغة عبر: `/locale/{locale}`
- اتجاه الصفحة يتغير تلقائيًا حسب اللغة

## TODO (Next Iteration)
1. إضافة مدير وسائط متقدم (ضغط صور، حذف تلقائي، multi-upload).
2. تحسين لوحة الاختبارات (CRUD للأسئلة داخل نفس الواجهة).
3. إضافة سياسات Authorization دقيقة لكل عملية CRUD.
4. إضافة لوحة Instructor مستقلة عن Admin.
5. ربط Hero/Sections بواجهة CMS مخصصة بدل key-value الخام.
6. إضافة Notifications وActivity Logs.
7. إضافة اختبارات Feature إضافية لمسارات الإدارة والطالب.

