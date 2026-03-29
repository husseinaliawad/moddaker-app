<?php

declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

$app = require __DIR__.'/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'admin@moddaker.test';
$user = App\Models\User::query()->where('email', $email)->first();

echo 'database.default='.config('database.default').PHP_EOL;
echo 'sqlite.database='.config('database.connections.sqlite.database').PHP_EOL;
echo 'users.count='.App\Models\User::query()->count().PHP_EOL;
echo 'admin.exists='.($user ? 'yes' : 'no').PHP_EOL;

if ($user) {
    echo 'admin.id='.$user->id.PHP_EOL;
    echo 'admin.email='.$user->email.PHP_EOL;
    echo 'admin.hash_check='.(Illuminate\Support\Facades\Hash::check('password', $user->password) ? 'yes' : 'no').PHP_EOL;
}
