<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualtricsSurveyLink extends Model
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Make sure email is lowercase
            $model->email = strtolower($model->email);
        });
    }

    protected $fillable = [
        'email',
        'link',
        'activity_id',
    ];

    public function activity() {
        return $this->belongsTo(Activity::class);
    }
}
