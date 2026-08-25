<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteConfig extends Model
{
    use HasFactory;
    protected $fillable = [
        'web_name',
        'web_frienly_name',
        'contact_no',
        'contact_email',
        'prefix',
        'male_legal_age',
        'female_legal_age',
        'web_logo_path',
        'favicon',
        'web_logo_path2',
        'banner1',
        'banner2',
        'watermark',
        'google_analytics',
        'web_fshort_description',
        'interest_setting',
        'profile_view_setting',
        'username_setting',
        'profile_varification',
        'weight_first',
        'weight_last',
        'success_marriage_year',
        'title',
        'description',
        'keyword',
        'facebook',
        'facebook_status',
        'twitter',
        'twitter_status',
        'linkedin',
        'linkedin_status',
        'instagram',
        'instagram_status',
        'youtube',
        'youtube_status',
        'pinterest',
        'pinterest_status',
        'birthyear',
    ];
}
