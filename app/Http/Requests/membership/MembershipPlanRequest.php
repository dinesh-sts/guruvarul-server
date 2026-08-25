<?php

namespace App\Http\Requests\membership;

use Illuminate\Foundation\Http\FormRequest;

class MembershipPlanRequest extends FormRequest
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
            'plan_name' => 'required|unique:membership_plans',
            'plan_type' => 'required',
            'plan_amount' => 'required|numeric',
            'plan_duration' => 'required|numeric',
            'plan_contacts' => 'required|numeric',
            'chat' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'plan_name.required' => 'Plan Name Is Required.',
            'plan_name.unique' => 'Plan Name Is exist.',
            'plan_type.required' => 'Plan Type is required.',
            'plan_amount.required' => 'Plan Amount is required.',
            'plan_amount.numeric' => 'Only Enter Number.',
            'plan_duration.required' => 'Plan Duration is required.',
            'plan_duration.numeric' => 'Only Enter Number.',
            'plan_contacts.required' => 'Plan Contacts is required.',
            'plan_contacts.numeric' => 'Only Enter Number.',
            'chat.required' => 'Chat is Required.',
        ];
    }
}
