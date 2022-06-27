<?php

use Illuminate\Support\Facades\Route;

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
use \App\Http\Controllers\Dashboard,
    \App\Http\Controllers\CoursesController,
    \App\Http\Controllers\Student\ExerciseController;

use \App\Http\Controllers\CourseGradebookController;

use App\Http\Controllers\Auth\SocialiteController;

Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/callback/google', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/auth/microsoft', [SocialiteController::class, 'redirectToMicrosoft'])->name('microsoft.login');
Route::get('/callback/microsoft', [SocialiteController::class, 'handleMicrosoftCallback'])->name('microsoft.callback');

Route::get('/', function () {
    return redirect()->route('dashboard');
    //return view('welcome');
});

Route::get('/logo', function () {
    return response([
        'url' => \Illuminate\Support\Facades\URL::asset( 'storage/'. nova_get_setting('logo_frontend'))
    ]);
});

Route::middleware([
    'auth:sanctum', 
    config('jetstream.auth_session'), 
    'verified'
])->group(function() {
    Route::get('/dashboard', Dashboard::class)
        ->name('dashboard');

    Route::get('/gradebook', \App\Http\Controllers\StudentGradebook::class);

    Route::get('/courses/{id}', [CoursesController::class, 'index'])
        ->name('courses.index');

    Route::get('/courses/topic/{id}/{activity_id?}', [CoursesController::class, 'topic'])
        ->name('courses.topic');

    Route::get('/courses/topic/activities/{id}', [CoursesController::class, 'topicActivities'])
        ->name('courses.topic.activities');

    Route::get('/courses/usersByActivity/{id}', [CoursesController::class, 'usersByActivity'])
        ->name('courses.userByActivity');

    Route::post('/courses/saveActivity', [CoursesController::class, 'saveActivity'])
        ->name('courses.saveActivity');

    Route::post('/courses/saveStudentHomework/{id}', [CoursesController::class, 'saveStudentHomework']);
    Route::get('/courses/studentHomework/{id}', [CoursesController::class, 'studentHomework']);
    Route::get('/courses/studentDeleteHomework/{id}', [CoursesController::class, 'studentDeleteHomework']);


    Route::get('/course/topic/gradebookPdf/{id}', [CoursesController::class, 'topicGradebookPdf'])
        ->name('courses.topicGradebookPdf');

    Route::get('/course/topic/gradebookExcel/{id}', [CoursesController::class, 'topicGradebookExcel'])
        ->name('courses.topicGradebookExcel');

    Route::get('/student/exercise/questions/{id}', [ExerciseController::class, 'getQuestion']);

    Route::post('/student/exercise', \App\Http\Controllers\GradeExerciseController::class);
    Route::get('/student/exercise/score/{activityId}', function($id){
        $activityScore = \App\Models\ActivityUser::where('activity_id', $id)
            ->where('user_id', auth()->user()->id)
            ->get()
            ->first();

        if ($activityScore) {
            return response()->json([
                'hasScore' => true,
                'activityScore' => $activityScore
            ]);
        }

        return response()->json(['hasScore' => false]);
    });
    
    // System Comments
    Route::get('/comments/activity/{id}/{type}', [\App\Http\Controllers\CommentController::class, 'list'])
        ->name('comments.activity');
    Route::get('/comments/answers/{id}', [\App\Http\Controllers\CommentController::class, 'answers'])
        ->name('comments.answers');

    Route::post('/comments/activity/{type}', [\App\Http\Controllers\CommentController::class, 'store']);
    Route::post('/comments/storeAnswer/{type}', [\App\Http\Controllers\CommentController::class, 'storeAnswer']);

    Route::post('/comments/delete', [\App\Http\Controllers\CommentController::class, 'delete']);

    Route::get('/student/myCalendar', function () {
        return \Inertia\Inertia::render('MyCalendar');
    });

    // Gradebooks report
    Route::get('/gradebook/courseByAllActivities/{course}', \App\Http\Controllers\Gradebook\CourseGradebookByAllActivitiesController::class);
    
    Route::get('/student/myActivities', function () {
        $user = auth()->user();
        $myCourses = $user->courses->pluck('id')->toArray();

        $activities = \Illuminate\Support\Facades\DB::table('activities')
            ->select('activities.name', 'activities.name', 'activities.score', 'activities.start', 'activities.end', 'topics.id as topic_id', 'topics.name as topic', 'courses.id as course_id',  'courses.name as course')
            ->leftJoin('topics', 'activities.topic_id', 'topics.id')
            ->leftJoin('courses', 'topics.course_id', 'courses.id')
            ->where('activities.score', '>', 0)
            ->where('activities.start', '<>', 'null')
            ->where('activities.end', '<>', 'null')
            ->whereIn('courses.id', $myCourses)
            ->get();

        return $activities->map(function ($activity){
            return [
                'title' => "<a href='/courses/topic/{$activity->topic_id}' target='_blank'>{$activity->name} {$activity->score} pts </a>",
                'start' => $activity->end,
                'end' => $activity->end,
                'content' => "<a href='/courses/topic/{$activity->topic_id}' target='_blank'>{$activity->course}</a>",
                'class' => "event-" . rand(1,10)
            ];
        });
    });

    // Editor Js
    Route::post('/editorjs/uploadFile', [App\Http\Controllers\EditorJsController::class, 'uploadFile']);

    Route::get('/nav/topic/activity/{id}', function ($id) {
        return \App\Models\Activity::find($id)?->prev_next_ids;
    })->name('nav.topic.activity');
});

Route::get('/gradebook/api', \App\Http\Controllers\GradebookController::class);

Route::get('/test', function (\App\Repositories\UserRepositoryInterface $userRepository) {
    $user = auth()->user();

    $user->notify(new \App\Notifications\StudentAlert([
        'title' => 'Hola Camaron sin cola'
    ]));
});


Route::get('/courseGradebook/{id}', [CourseGradebookController::class, 'show'])->middleware('studentIsSolvent');

Route::get('/topicGradebook/{id}', function($id) {
    $topic = App\Models\Topic::find($id);
    return \Inertia\Inertia::render('Admin/TopicGradebook', [
        'topic' => $topic,
        'students' => $topic->course->students->map(function ($student) use($topic) {
            $student->scores =  DB::table('activity_user')
                ->leftJoin('activities', 'activity_user.activity_id', 'activities.id')
                ->where('activity_user.user_id', $student->id)
                ->where('activities.topic_id', $topic->id)
                ->select('activity_user.*')
                ->get()
                ->keyBy('activity_id');

            $student->total = $student->scores->sum('score');
            return $student;
        }),
        'activities' => $topic->activities->where('score', '>', 0)
    ]);
});

Route::post('/topicGradebook/update/{topicId}/{userId}', function (\Illuminate\Http\Request $request, $topicId, $userId){
    $student = \App\Models\User::find($userId);
    $score = $student->activities()->updateExistingPivot($request->post('activity_id'),  [
        'score' =>  $request->post('score'),
    ]);

    $scores =  DB::table('activity_user')
        ->leftJoin('activities', 'activity_user.activity_id', 'activities.id')
        ->where('activity_user.user_id', $student->id)
        ->where('activities.topic_id', $topicId)
        ->select('activity_user.*')
        ->get();

    $student->total = $scores->sum('score');
    return $student;
});

Route::post('/topicGradebook/save/{userId}/{activityId}', function (\Illuminate\Http\Request $request, $userId, $activityId) {
    $student = \App\Models\User::find($userId);
    $score = $student->activities->where('id', $activityId)->first();

    if ($score) {
        $newScore = $student->activities()->updateExistingPivot($activityId,  [
            'score' =>  $request->post('score'),
        ]);
    }else {
        $newScore = $student->activities()->attach($activityId,  [
            'comment' =>  '',
            'score' => $request->post('score'),
            'file' => null
        ]);
    }

    $student->scores =  DB::table('activity_user')
        ->leftJoin('activities', 'activity_user.activity_id', 'activities.id')
        ->where('activity_user.user_id', $student->id)
        ->where('activities.topic_id', $request->post('topicId'))
        ->select('activity_user.*')
        ->get();

    $student->newScore = $newScore;
    $student->total = $student->scores->sum('score');
    return $student;
});

Route::get('/notifications', function () {
    return auth()->user()->notifications;
});
