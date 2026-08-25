<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosh extends Model
{
    use HasFactory;
    protected $fillable = [
        'dosh',
        'status',
    ];
}
