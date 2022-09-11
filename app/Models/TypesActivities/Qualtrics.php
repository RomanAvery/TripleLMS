<?php

namespace App\Models\TypesActivities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualtrics extends Model
{
    //use HasFactory;

    protected $table = 'qualtrics';

    protected $fillable = [
        'link',
        'allow_generic_link'
    ];

    protected $casts = [
        'allow_generic_link' => 'boolean'
    ];

    const COMPONENT = 'QUALTRICS';
}
