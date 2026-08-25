<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class passwordrequest extends FormRequest
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
                'old_password' => 'required',
                'new_password' => 'required|min:6|max:8',
                'confirm_password' => 'required|same:new_password',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Old Password is required.',
            'new_password.required' => 'Password is required.',
            'new_password.min' => 'Minimum 6 digits is Required.',
            'new_password.max' => 'Maximum 8 digits is Required.',
            'confirm_password.required' => 'Confirm Password is required.',
            'confirm_password.same' => 'Confirm Password Not Match.',
        ];
    }
}
