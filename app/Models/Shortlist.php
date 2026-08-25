<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortlist extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_id',
        'to_id',
        'add_date'
    ];
}
