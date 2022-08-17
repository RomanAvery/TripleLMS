<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('deploy', function () {
    $this->call('storage:link');
    $this->call('cache:clear');
    $this->call('config:cache');
    $this->call('route:cache');
    $this->call('view:clear');
})->purpose('Run commands ready for deploy');

Artisan::command('run', function () {
    $this->call('migrate', ['--force' => true]);
    $this->call('db:seed', ['--force' => true]);
})->purpose('Run commands ready for production run');

// Overwrite to use Pest instead of PHPUnit for browser testing
Artisan::command('dusk', function () {
    $this->call('pest:dusk');
});
