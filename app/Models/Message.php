<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'to_id',
        'from_id',
        'subject',
        'message',
        'sent_date',
        'msg_status',
        'msg_read_status',
        'msg_important_status',
    ];
}
