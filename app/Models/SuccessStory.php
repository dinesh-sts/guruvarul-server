<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStory extends Model
{
    use HasFactory;

    protected $fillable = [
        'weddingphoto',
        'bridename',
        'brideid',
        'groomname',
        'groomid',
        'marriagedate',
        'engagement_date',
        'successmessage',
        'status'
    ];
}
