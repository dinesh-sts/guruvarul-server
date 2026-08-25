<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_code',
        'state_code',
        'state_name',
        'status'
    ];
    public function country()
    {
        return $this->belongsTo(Country::class,'country_code','id');
    }
}
