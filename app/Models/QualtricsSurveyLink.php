<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualtricsSurveyLink extends Model
{
    protected $fillable = [
        'email',
        'link',
        'activity_id',
    ];

    public function activity() {
        return $this->belongsTo(Activity::class);
    }
}
