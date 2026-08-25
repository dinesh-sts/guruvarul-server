<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchesList extends Model
{
    use HasFactory;
    protected $fillable = [
        'my_id',
        'other_id',
        'sent_on',
    ];
}
