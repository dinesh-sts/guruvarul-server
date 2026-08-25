<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'chat_thread_id',
        'sender_user_id',
        'message',
        'seen',
    ];
    
    public function chatThread()
    {
        return $this->belongsTo(ChatThread::class, 'chat_thread_id');
    }
    public function sender()
    {
        return $this->belongsTo(Register::class, 'sender_user_id');
    }
}
