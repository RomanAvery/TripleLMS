<?php

namespace App\Models\Qualtrics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Helpers\GuzzleQualtrics;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;

use App\Models\Course;

class MailingList extends Model
{
    use HasFactory;

    protected $table = 'qualtrics_mailing_lists';

    protected $fillable = [
        'name',
        'list_id',
        'course_id',
    ];

    public static function boot() {
        parent::boot();
        
        static::creating(function ($model) {
            //static::create_list($model);
        });
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'mailing_list_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'mailing_list_id');
    }

    public static function create_list($list) {
        $client = GuzzleQualtrics::client();

        try {
            $res = $client->get(env('QUALTRICS_API_BASE') . "API/v3/directories/" . env('QUALTRICS_DIRECTORY_ID') . "/mailinglists");
            dd(json_decode($res->getBody(), true));
        } catch (ClientException $e) {
            Action::danger('Something went wrong!');
        }
    }
}
