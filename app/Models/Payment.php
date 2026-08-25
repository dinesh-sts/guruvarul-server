<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pmatri_id',
        'pname',
        'paymode',
        'pactive_dt',
        'p_plan',
        'plan_duration',
        'profile',
        'chat',
        'p_no_contacts',
        'p_amount',
        'pay_id',
        'r_profile',
        'r_cnt',
        'exp_date',
        'pcontact',
        'pemail'
    ];
}
