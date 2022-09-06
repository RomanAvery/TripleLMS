<?php

namespace App\Models;

use App\Models\TypesActivities\Exercise;
use App\Models\TypesActivities\H5P;
use App\Models\TypesActivities\Qualtrics;
use App\Models\TypesActivities\MakeCode;
use App\Models\TypesActivities\Text;
use App\Models\TypesActivities\VideoGrid;

use Carbon\Carbon;
use Laravel\Nova\Actions\Actionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Activity extends Model implements Sortable
{
    use Actionable, HasFactory, SortableTrait;

    protected $guarded = [];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $with = ['activityable'];

    protected $appends = [
        'type',
        'divider',
        'course',
        'isActiveToDo',
        'completed',
    ];

    protected $attributes = [
        'isShow' => true,
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start' => 'date:d-m-Y',
        'end' => 'date:d-m-Y',
        'allow_comments' => 'boolean',
    ];

    protected $types = [
        Exercise::class,
        Text::class,
        H5P::class,
        Qualtrics::class,
        MakeCode::class,
        VideoGrid::class,
    ];

    protected static function updateActivityType($model) {
        switch ($model->activityable_type) {
            case 'App\Models\TypesActivities\H5P':
                $h5p = H5P::create([
                    'link' => $model->link,
                ]);
                $model->activityable_type = H5P::class;
                $model->activityable_id = $h5p->id;
                unset($model->link);  # Unset the link so we don't get an error
                break;

            case 'App\Models\TypesActivities\Qualtrics':
                $qualtric = Qualtrics::create([
                    'link' => $model->link,
                ]);
                $model->activityable_type = Qualtrics::class;
                $model->activityable_id = $qualtric->id;
                unset($model->link);
                break;

            case 'App\Models\TypesActivities\Text':
                $text = Text::create([
                    'body' => $model->body,
                ]);
                $model->activityable_type = Text::class;
                $model->activityable_id = $text->id;
                unset($model->body);  # Unset the link so we don't get an error
                break;

            case 'App\Models\TypesActivities\MakeCode':
                $text = MakeCode::create([
                    'link' => $model->link,
                ]);
                $model->activityable_type = MakeCode::class;
                $model->activityable_id = $text->id;
                unset($model->link);  # Unset the link so we don't get an error
                break;

            case 'App\Models\TypesActivities\VideoGrid':
                $grid = VideoGrid::create([
                    'videos' => $model->videos,
                ]);
                $model->activityable_type = VideoGrid::class;
                $model->activityable_id = $grid->id;
                unset($model->videos);
                break;

            default:
                unset($model->activityable_type);
                break;
        }
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            static::updateActivityType($model);
        });

        static::updating(function ($model) {
            if ($model->link !== null || $model->body !== null || $model->videos !== null) {
                static::updateActivityType($model);
            }
        });
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function parent()
    {
        return $this->topic();
    }

    public function activityable()
    {
        return $this->morphTo();
    }

    /**
     * Returns whether a user has completed this task or not.
     */
    public function getCompletedAttribute()
    {
        return $this->users->contains(auth()->user());
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('score', 'comment', 'file', 'created_at', 'updated_at', 'text');
    }

    public function getTypeAttribute()
    {
        if (! in_array($this->activityable_type, $this->types)){
            return false;
        }

        return $this->activityable_type::COMPONENT;
    }

    public function getDividerAttribute()
    {
        return 0;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)
            ->whereNull('parent_id')
            ->orderBy('id', 'DESC');
    }

    public function getCourseAttribute()
    {
        return $this->topic->course;
    }

    public function getIsActiveToDoAttribute()
    {
        if ($this->start == $this->end){
            return true;
        }

        $today = Carbon::now();
        return $today->between($this->start, $this->end->addHours(24));
    }

    public function studentScore($user)
    {
        return $this->users()
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getPrevNextIdsAttribute()
    {
        $res = (object) [];

        // Get an array of activity IDs
        $activities = $this->topic?->activities?->map(function ($item, $key) {
                    return $item->id;
                });

        $index = $activities->search($this->id);  // Get index of current activity

        $prev = $activities->get($index - 1);
        $next = $activities->get($index + 1);

        if ($prev === null) {
            $prev_topic = $this->topic->prev_next_ids->prev;
            $prev = Topic::find($prev_topic)?->activities?->last()?->id;

            if ($prev !== null) {
                $res->prev = (object) ['id' => $prev, 'topic_id' => $prev_topic];
            }
        } else {
            $res->prev = (object) ['id' => $prev];
        }

        if ($next === null) {
            $next_topic = $this->topic->prev_next_ids->next;
            $next = Topic::find($next_topic)?->activities?->first()?->id;

            if ($next !== null) {
                $res->next = (object) ['id' => $next, 'topic_id' => $next_topic];
            }
        } else {
            $res->next = (object) ['id' => $next];
        }

        return $res;
    }
}
