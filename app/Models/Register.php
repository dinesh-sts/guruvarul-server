<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Register extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $guard="user";

    protected $fillable = [
        'mobile_code',
        'profileby',
        'gender',
        'firstname',
        'lastname',
        'birthdate',
        'religion',
        'caste',
        'mobile',
        'email',
        'password',
        'cpass_status',
        'mobile_verify',
        'status',
        'm_status',
        'tot_children',
        'status_children',
        'm_tongue',
        'subcaste',
        'will_to_mary_caste',
        'edu_detail',
        'emp_in',
        'occupation',
        'company_name',
        'designation',
        'income',
        'family_type',
        'family_value',
        'family_status',
        'father_name',
        'father_occupation',
        'mother_name',
        'mother_occupation',
        'no_of_brothers',
        'no_marri_brother',
        'no_of_sisters',
        'no_marri_sister',
        'maternal_details',
        'paternal_details',
        'country_id',
        'state_id',
        'city',
        'contact_view_security',
        'address',
        'diet',
        'smoke',
        'drink',
        'height',
        'weight',
        'bodytype',
        'complexion',
        'physicalStatus',
        'b_group',
        'dosh',
        'manglik',
        'moonsign',
        'star',
        'birthtime',
        'birthplace',
        'profile_text',
        'profile_text_approve',
        'looking_for',
        'part_frm_age',
        'part_to_age',
        'part_height',
        'part_height_to',
        'part_mtongue',
        'part_physical',
        'part_complexation',
        'part_bodytype',
        'part_diet',
        'part_smoke',
        'part_drink',
        'part_edu',
        'part_occu',
        'part_emp_in',
        'part_income',
        'part_religion',
        'part_caste',
        'part_star',
        'part_rasi',
        'part_dosh',
        'part_manglik',
        'part_country_living',
        'part_state',
        'part_city',
        'part_expect',
        'part_expect_approve',
        'photo1',
        'photo1_approve',
        'photo2',
        'photo2_approve',
        'photo3',
        'photo3_approve',
        'photo4',
        'photo4_approve',
        'photo5',
        'photo5_approve',
        'photo6',
        'photo6_approve',
        'photo7',
        'photo7_approve',
        'photo8',
        'photo8_approve',
        'hor_photo',
        'hor_check',
        'aadhaar_card',
        'aadhaar_card_status',
        'reg_date',
        'online_time',
        'last_login',
    ];

    public function profileCompletenessPercentage()
    {
       $totalFields = 95; 

        $filledFields = array_filter([
            $this->mobile_code ,
            $this->profileby,
            $this->gender,
            $this->mobile,
            $this->firstname,
            $this->lastname,
            $this->birthdate,
            $this->religion,
            $this->caste,
            $this->mobile,
            $this->email,
            $this->password,
            $this->cpass_status,
            $this->status,
            $this->m_status,
            $this->tot_children,
            $this->status_children,
            $this->m_tongue,
            $this->subcaste,
            $this->will_to_mary_caste,
            $this->edu_detail,
            $this->emp_in,
            $this->occupation,
            $this->company_name,
            $this->designation,
            $this->income,
            $this->family_type,
            $this->family_value,
            $this->family_status,
            $this->father_name,
            $this->father_occupation,
            $this->mother_name,
            $this->mother_occupation,
            $this->no_of_brothers,
            $this->no_marri_brother,
            $this->no_of_sisters,
            $this->no_marri_sister,
            $this->maternal_details,
            $this->paternal_details,
            $this->country_id,
            $this->state_id,
            $this->city,
            $this->address,
            $this->diet,
            $this->smoke,
            $this->drink,
            $this->height,
            $this->weight,
            $this->bodytype,
            $this->complexion,
            $this->physicalStatus,
            $this->b_group,
            $this->dosh,
            $this->manglik,
            $this->moonsign,
            $this->star,
            $this->birthtime,
            $this->birthplace,
            $this->profile_text,
            $this->looking_for,
            $this->part_frm_age,
            $this->part_to_age,
            $this->part_height,
            $this->part_height_to,
            $this->part_mtongue,
            $this->part_physical,
            $this->part_complexation,
            $this->part_bodytype,
            $this->part_diet,
            $this->part_smoke,
            $this->part_drink,
            $this->part_edu,
            $this->part_occu,
            $this->part_emp_in,
            $this->part_income,
            $this->part_religion,
            $this->part_caste,
            $this->part_star,
            $this->part_rasi,
            $this->part_dosh,
            $this->part_manglik,
            $this->part_country_living,
            $this->part_state,
            $this->part_city,
            $this->part_expect,
            $this->photo1,
            $this->photo2,
            $this->photo3,
            $this->photo4,
            $this->photo5,
            $this->photo6,
            $this->photo7,
            $this->photo8,
            $this->hor_photo,
            $this->aadhaar_card,
        ]);

        $filledFieldsCount = count($filledFields);

        if ($filledFieldsCount > 0) {
            $percentage = ($filledFieldsCount / $totalFields) * 100;
            return round($percentage);
        } else {
            return 0;
        }
    }
    public function mother_tongue()
    {
        return $this->belongsTo(Mothertongue::class,'m_tongue','id');
    }
    public function age_from()
    {
        return $this->belongsTo(Age::class,'part_frm_age','id');
    }
    public function age_to()
    {
        return $this->belongsTo(Age::class,'part_to_age','id');
    }
    public function profile()
    {
        return $this->belongsTo(ProfileBy::class,'profileby','id');
    }
    public function rel()
    {
        return $this->belongsTo(Religion::class,'religion','id');
    }
    public function cast()
    {
        return $this->belongsTo(Caste::class,'caste','id');
    }
    public function subcast()
    {
        return $this->belongsTo(Subcast::class,'subcaste','id');
    }
    public function h_edu()
    {
        return $this->belongsTo(EducationDetail::class,'edu_detail','id');
    }
    public function add_edu()
    {
        return $this->belongsTo(EducationDetail::class,'edu_detail','id');
    }
    public function occ()
    {
        return $this->belongsTo(Occupation::class,'occupation','id');
    }
    public function father_occ()
    {
        return $this->belongsTo(Occupation::class,'father_occupation','id');
    }
    public function mother_occ()
    {
        return $this->belongsTo(Occupation::class,'mother_occupation','id');
    }
    public function inc()
    {
        return $this->belongsTo(Income::class,'income','id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }
    public function state()
    {
        return $this->belongsTo(State::class,'state_id','id');
    }
    public function citi()
    {
        return $this->belongsTo(City::class,'city','id');
    }
    public function hei()
    {
        return $this->belongsTo(Height::class,'height','id');
    }
    public function part_from_hei()
    {
        return $this->belongsTo(Height::class,'part_height','id');
    }
    public function part_to_hei()
    {
        return $this->belongsTo(Height::class,'part_height_to','id');
    }
    public function doshes()
    {
        return $this->belongsTo(Dosh::class,'manglik','id');
    }
    public function staars()
    {
        return $this->belongsTo(Star::class,'star','id');
    }
    public function rashi()
    {
        return $this->belongsTo(Rasi::class,'moonsign','id');
    }
    public function high_edu()
    {
        $eduDetails = explode(',', "10,13"); // Assuming $this->edu_detail holds "10,13"

        if ($eduDetails) {
            return $this->belongsTo(EducationDetail::class, $eduDetails[0]);
        }

        return null;
    }
    

    

  
    
}
