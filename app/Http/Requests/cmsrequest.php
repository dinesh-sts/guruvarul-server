<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class cmsrequest extends FormRequest
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
                'page_name' => 'required|unique:cms_pages',
                'cms_title' => 'required',
                'cms_content' => 'required',
                'page_placement' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'page_name.required' => 'page name is required.',
            'page_name.unique' => 'Please enter page name unique.',
            'cms_content.required' => 'cms content Password is required.',
            'page_placement.required' => 'page placement Password is required.',
        ];
    }
}
