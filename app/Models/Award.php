<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillable = [
        'name',
        'image',
        'course_id'
    ];

    protected $appends = ['imageUrl'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getImageUrlAttribute()
    {
        return ($this->image !== null && Storage::exists($this->image))
                ? Storage::url($this->image)
                : null;
    }
}
