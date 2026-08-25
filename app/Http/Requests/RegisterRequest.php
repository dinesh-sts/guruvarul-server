<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'email' => 'required|email|unique:registers',
                'profileby' => 'required',
                'gender' => 'required',
                'firstname' => 'required|max:150',
                'lastname' => 'required|max:150',
                'month' => 'required',
                'year' => 'required',
                'day' => 'required',
                'country_id' => 'required',
                'religion' => 'required',
                'caste' => 'required',
                'mobile' => 'required|numeric|min_digits:5|max_digits:15|unique:registers,mobile',
                'password' => 'required|min:4',
                'm_status' => 'required',
                'mobile_code' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please enter email id.',
            'email.email' => 'Please enter valid email id.',
            'email.unique' => 'Email id already exist.',
            'day.required' => 'Please select day.',
            'year.required' => 'Please select year.',
            'month.required' => 'Please select month.',
            'firstname.required' => 'Please enter first name.',
            'lastname.required' => 'Please enter last name.',
            'gender.required' => 'Please select gender.',
            'country_id.required' => 'Please select country.',
            'religion.required' => 'Please select religion.',
            'caste.required' => 'Please select caste.',
            'mobile.required' => 'Please enter mobile no.',
            'mobile.numeric' => 'Only numbers allowed.',
            'mobile.digits' => 'Please enter valid mobile no.',
            'profileby.required' => 'Please select profile by.',
            'password.required' => 'Please enter password',
            'password.min' => 'Please enter minimum 4 character long password.',
            'm_status.required' => 'Please Select Marital Status.',
            'mobile_code.required' => 'Please select country code.',
        ];
    }
}
