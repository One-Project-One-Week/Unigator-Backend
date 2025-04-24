<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'university_id' => 'required|integer|exists:universities,id',
            'name' => 'required|string|max:255',
            'detail' => 'required|array',
            'degree_type' => 'required|string',
            'duration' => 'required|string|max:255',
            'application_requirement' => 'required|array',
            'intake' => 'required|string|max:255',
            'payment_plan' => 'required|in:monthly,per_semester,no_installements',
            'category_id' => 'required|integer|exists:categories,id',
            'level' => 'required|string|max:255',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'university-fail',
            'statusCode' => 422,
            'message' => 'Validation Error',
            'data' => $validator->errors()
        ], 422));
    }
}