<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_caste',
        'gotra',
        'will_to_marry',
        'weight',
        'body_type',
        'complexion',
        'physical_status',
        'additional_degree',
        'annual_income',
        'diet',
        'smoke',
        'drink',
        'dosh',
        'star',
        'rasi',
        'birthtime',
        'birthplace',
        'family_profile',
        'family_status',
        'family_type',
        'family_value',
        'father_occupation',
        'mother_occupation',
        'no_of_brother',
        'no_of_married_brother',
        'no_of_sister',
        'no_of_married_sister',
        'profile_text',
        'part_physical_status',
        'part_diet',
        'part_drink',
        'part_smoke',
        'part_dosh',
        'part_rasi',
        'part_star',
        'part_state',
        'part_city',
        'part_annual_income',
        'part_expect',
        'company_name',
        'designation',
        'father_name',
        'mother_name',
        'maternal_details',
        'paternal_details',
        'address',
        'height',
        'manglik',
        'b_group',
        'part_complexation',
        'part_bodytype',
        'part_manglik',

    ];
    
}
