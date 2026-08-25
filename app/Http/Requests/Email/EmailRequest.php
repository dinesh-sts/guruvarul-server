<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
            'weddingphoto' => 'required',
            'bridename' => 'required',
            'groomname' => 'required',
            'marriagedate' => 'required',
            'engagement_date' => 'required',
            'successmessage' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'weddingphoto.required' => 'Wedding Photo Is Required.',
            'bridename.required' => 'Bride Name is required.',
            'groomname.required' => 'Groom Name is required.',
            'marriagedate.required' => 'Marriage Date is required.',
            'engagement_date.required' => 'Engagement Date is required.',
            'successmessage.required' => 'Success Message is Required.',
        ];
    }
}
