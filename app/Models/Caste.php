<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caste extends Model
{
    use HasFactory;
    protected $fillable = [
        'religion_id',
        'caste_name',
        'status'
    ];

    public function rel()
    {
        return $this->belongsTo(Religion::class,'religion_id','id');
    }
}
