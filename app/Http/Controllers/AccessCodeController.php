<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AccessCode;
use App\Models\Course;

class AccessCodeController extends Controller
{
    public function addToCourse()
    {
        $code = AccessCode::where('code', request()->input('code'))
            ->where(function ($query) {
                $query->where('expires', '>', now())
                    ->orWhere('expires', null);
            })
            ->get()
            ->first();

        if ($code === null) {
            request()->session()->flash('error', "Code doesn't exist");
            return back();
        }

        $user = request()->user();
        $course = $code->course;
        if ($course === null) {
            request()->session()->flash('error', "Couldn't find course.");
            return back();
        }

        if ($user->courses->contains($course)) {
            request()->session()->flash('info', "You're already in this course.");
            return back();
        }

        $user->courses()->save($course);

        // Log activity
        activity()
            ->performedOn($course)
            ->causedBy(auth()?->user())
            ->withProperties([ 'type' => 'use access code' ])
            ->log("User '{$user->name}' joined course '{$course->name}' with an access code.");

        if ($code->survey_opt_in) {
            $user->survey_opt_in = true;
            $user->save();

            activity()
                ->performedOn($user)
                ->causedBy($code)
                ->withProperties([ 'type' => 'opted in' ])
                ->log("An access code opted User '{$user->name}' in to surveys.");
        }

        request()->session()->flash('success', "Added you to the course.");
        return back();
    }
}
