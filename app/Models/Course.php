<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class Course extends Model
{
    use HasFactory;

    protected $appends = ['coverPath'];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getCoverPathAttribute()
    {
        $random = rand(1,6);
        return is_null($this->cover) ? "/img/courses/covers/cover-{$random}.jpg" : '/storage/' . $this->cover;
    }
}
