<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use \App\Http\Controllers\AccessCodeController;
use \App\Http\Controllers\CourseController;
use \App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\SocialiteController;

Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/callback/google', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/auth/microsoft', [SocialiteController::class, 'redirectToMicrosoft'])->name('microsoft.login');
Route::get('/callback/microsoft', [SocialiteController::class, 'handleMicrosoftCallback'])->name('microsoft.callback');

Route::get('/', function () {
    return Inertia::render('Index');
})->name('index');

Route::get('/logo', function () {
    if (file_exists(storage_path('app/public/' . nova_get_setting('logo_frontend')))) {
        return null;
    }

    return response([
        'url' => \Illuminate\Support\Facades\URL::asset( 'storage/'. nova_get_setting('logo_frontend'))
    ]);
})->name('logo');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function() {
    Route::get('/dashboard', [CourseController::class, 'index'])
        ->name('dashboard');

    Route::get('/courses/{id}', [CourseController::class, 'show'])
        ->name('courses.show');

    Route::get('/courses/topic/{id}/{activity_id?}', [CourseController::class, 'topic'])
        ->name('courses.topic');

    // System Comments
    Route::get('/comments/activity/{id}/{type}', [CommentController::class, 'list'])
        ->name('comments.activity');
    Route::get('/comments/answers/{id}', [CommentController::class, 'answers'])
        ->name('comments.answers');

    Route::post('/comments/activity/{type}', [CommentController::class, 'store']);
    Route::post('/comments/storeAnswer/{type}', [CommentController::class, 'storeAnswer']);

    Route::post('/comments/delete', [CommentController::class, 'delete']);

    // Get previous and next navigation for the activity, if it applies
    Route::get('/nav/topic/activity/{id}', function ($id) {
        return \App\Models\Activity::find($id)?->prev_next_ids;
    })->name('nav.topic.activity');

    Route::post('/access-code', [AccessCodeController::class, 'addToCourse'])->name('access-code');
});

Route::get('/notifications', function () {
    return auth()->user()->notifications;
});
