<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactView extends Model
{
    use HasFactory;
    protected $fillable = [
        'my_id',
        'viewed_mem_id',
        'viewed_date',
    ];
}
