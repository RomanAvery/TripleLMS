<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Course;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->courses->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'code' => $course->code,
                'description' => $course->description,
                'coverPath' => $course->coverPath
            ];
        });

        return Inertia::render('Dashboard')->with(compact('courses'));
    }

    public function show($id)
    {
        $course = Course::where('id', $id)
            ->with('topics')
            ->first();

        $user = auth()?->user();

        if (
            $course === null ||
            $user === null ||
            $user->cannot('view', $course)
        ) {
            abort(404);
        }

        activity()
            ->performedOn($course)
            ->causedBy(auth()?->user())
            ->withProperties([ 'type' => 'view course index' ])
            ->log("User '{$user->name}' viewed course '{$course->name}'.");

        return Inertia::render('Course/Index')
            ->with(compact('course'));
    }

    public function topic($id, $activity_id = null)
    {
        $topic = Topic::find($id);

        $user = auth()?->user();

        if (
            $topic === null ||
            $user === null ||
            $user->cannot('view', $topic->course)
        ) {
            abort(404);
        }

        if ($activity_id === null) {
            $activity = $topic->activities->where('isShow', true)->first();
        } else {
            $activity = $topic->activities
                ->where('isShow', true)
                ->where('id', $activity_id)
                ->first();
        }

        if ($activity === null) abort(404);

        activity()
            ->performedOn($activity)
            ->causedBy(auth()?->user())
            ->withProperties([ 'type' => 'view activity' ])
            ->log("User '{$user->name}' viewed activity '{$activity->name}' on topic '{$topic->name}'.");

        $topic->course;
        $topics = $topic->course->topics;

        return Inertia::render('Course/Topic')
            ->with(compact('topic', 'activity', 'topics'));
    }

    public function finish($id)
    {
        $course = Course::find($id);
        $user = auth()?->user();
        if (
            $course === null ||
            $user === null ||
            $user->cannot('view', $course)
        ) {
            abort(404);
        }

        activity()
            ->performedOn($course)
            ->causedBy(auth()?->user())
            ->withProperties([ 'type' => 'finish course' ])
            ->log("User '{$user->name}' finished course '{$course->name}'.");

        if ($user !== null &&
            $course->award !== null &&
            !$user->awards->contains($course->award)
        ) {
            $user->awards()->save($course->award);
        }

        return Inertia::render('Course/Finished')
            ->with(compact('course'));
    }
}
