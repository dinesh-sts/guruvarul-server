<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ignore extends Model
{
    use HasFactory;

    protected $fillable = [
        'ignore_by',
        'ignore_to',
        'ignore_date'
    ];
}
