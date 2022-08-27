<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Course;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Inertia\Inertia;

class AwardController extends Controller
{
    public function index()
    {
        $user = auth()?->user();
        $awards = $user?->awards;

        return Inertia::render('Awards')->with(compact('awards'));
    }
}
