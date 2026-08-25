<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expressinterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'ei_sender',
        'ei_receiver',
        'receiver_response',
        'ei_sent_date',
        'trash_sender',
        'trash_receiver'
    ];
}
