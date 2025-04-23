<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
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
            //
            'id' => 'required|integer',
            'uni_id' => 'required|integer|exists:universities,id',
            'name' => 'required|string|max:255',
            'detail' => 'required|array',
            'degree_type' => 'required|string',
            'duration' => 'required|striing|max:255',
            'application_requirement' => 'required|array',
            'enrollemnt_period' => 'required|string|max:255',
            'payment_type' => 'required|in:',
        ];
    }
}