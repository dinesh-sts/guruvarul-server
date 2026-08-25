<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'menu_search',
        'menu_success',
        'menu_membership',
        'menu_contact',
        'menu_login',
        'menu_signup',
        'footer_contact',
        'footer_faq',
        'footer_refund',
        'footer_terms',
        'footer_policy',
        'footer_report',
        'footer_login',
        'footer_register',
        'footer_membership',
        'footer_success',
        'footer_about',
        'footer_search',
        'footer_about_short',
    ];
}
