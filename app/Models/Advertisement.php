<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'adv_date',
        'adv_name',
        'adv_link',
        'adv_level',
        'adv_img',
        'contact_name',
        'phone',
        'status',
    ];
}
