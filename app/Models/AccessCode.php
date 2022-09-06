<?php

namespace App\Models;

use App\Models\Course;

use Laravel\Nova\Actions\Actionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    use Actionable;
    use HasFactory;

    protected $fillable = [
        'code',
        'course_id',
        'expires',
        'survey_opt_in',
    ];

    protected $casts = [
        'expires' => 'datetime',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
