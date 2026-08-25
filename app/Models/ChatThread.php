<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatThread extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'thread_code',
        'sender_user_id',
        'receiver_user_id',
        'active',
        'interview',
        'blocked_by_user',
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class, 'chat_thread_id');
    }

    public function sender()
    {
        return $this->belongsTo(Register::class, 'sender_user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Register::class, 'receiver_user_id');
    }

}
