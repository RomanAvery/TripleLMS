<?php

namespace App\Models\TypesActivities\Questions;

use App\Models\TypesActivities\Exercise;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'isTrue' => 'boolean'
    ];

    protected $attributes = [
        'isTrue' => true,
    ];

    public function selectMultiple()
    {
        return $this->belongsTo(SelectMultiple::class);
    }
}
