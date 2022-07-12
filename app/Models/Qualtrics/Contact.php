<?php

namespace App\Models\Qualtrics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'qualtrics_contacts';

    protected $fillable = [
        'contact_id',
        'unsubscribed',
        'user_id',
        'mailing_list_id',
    ];

    public function mailing_list()
    {
        return $this->belongsTo(MailingList::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'contact_id');
    }
}
