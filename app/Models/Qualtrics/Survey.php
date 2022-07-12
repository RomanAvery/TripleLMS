<?php

namespace App\Models\Qualtrics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'qualtrics_surveys';

    protected $fillable = [
        'survey_id',  // ID of the survey
        /*'api_key',  // To write data
        'manage_api_key',  // To manage channel (e.g: delete it)
        'user_id',
        'course_id',*/
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
