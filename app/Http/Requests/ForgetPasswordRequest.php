<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
                'email' => 'required|email|exists:admin_users',
                'password' => 'required|min:6|max:8',
                'confirm_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email Is Required.',
            'email.email' => 'Invalid Email Format.',
            'email.exists' => 'This Email is Not Exist.',
            'password.required' => 'Password is required.',
            'password.min' => 'Minimum 6 digits is Required.',
            'password.max' => 'Maximum 8 digits is Required.',
            'confirm_password.required' => 'Confirm Password is required.',
            'confirm_password.same' => 'Confirm Password Not Match.',
        ];
    }
}
