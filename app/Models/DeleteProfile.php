<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'reason',
        'matri_id'
    ];
}
