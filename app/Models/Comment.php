<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['user'];

    protected $appends = ['totalReplies'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:h:m d-m-y',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function getTotalRepliesAttribute()
    {
        return Comment::where('parent_id', $this->id)->get()->count();
    }
}
