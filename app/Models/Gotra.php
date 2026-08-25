<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gotra extends Model
{
    use HasFactory;
    protected $fillable = [
        'gotra_name',
        'status',
    ];
}
