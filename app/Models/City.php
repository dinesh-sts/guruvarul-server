<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_code',
        'state_code',
        'city_name',
        'status'
    ];
    public function country()
    {
        return $this->belongsTo(Country::class,'country_code','id');
    }
    public function state()
    {
        return $this->belongsTo(State::class,'state_code','id');
    }
}
