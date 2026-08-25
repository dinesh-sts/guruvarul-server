<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class contactusRequest extends FormRequest
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
                'email' => 'required',
                'name' => 'required|max:50',
                'mobile' => 'required|min:10|max:15',
                'subject' => 'required',
                'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please enter email id.',
            'name.required' => 'Please enter Name.',
            'mobile.required' => 'Please enter mobile no.',
            'mobile.numeric' => 'Only numbers allowed.',
            'mobile.min' => 'Please enter minimum 10 digit mobile no.',
            'mobile.max' => 'Please enter maximum 15 digit mobile no.',
            'subject.required' => 'Plaese Enter Subject.',
            'description.required' => 'Plaese Enter Description.',
        ];
    }
}
