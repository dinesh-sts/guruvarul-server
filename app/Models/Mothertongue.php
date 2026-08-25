<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mothertongue extends Model
{
    use HasFactory;
    protected $fillable = [
        'mtongue_name',
        'status',
    ];
}
