<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhoViewedMyProfiles extends Model
{
    use HasFactory;
    protected $fillable = [
        'block_by',
        'block_to',
        'block_date'
    ];
}
