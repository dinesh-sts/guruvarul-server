<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcast extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_caste_name',
        'status',
    ];
}
