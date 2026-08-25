<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;
    protected $fillable = [
        'matri_id',
        'looking_for',
        'part_frm_age',
        'part_to_age',
        'part_height',
        'part_height_to',
        'part_complexation',
        'part_mtongue',
        'part_religion',
        'part_edu',
        'part_caste',
        'part_country_living',
        'part_resi_status',
    ];

  
    public function age_from()
    {
        return $this->belongsTo(Age::class,'part_frm_age','id');
    }
    public function age_to()
    {
        return $this->belongsTo(Age::class,'part_to_age','id');
    }

}
