<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProgramRequest extends FormRequest
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
            'uni_id' => 'sometimes|required|integer|exists:universities,id',
            'name' => 'sometimes|required|string|max:255',
            'detail' => 'sometimes|required|array',
            'degree_type' => 'sometimes|required|string',
            'duration' => 'sometimes|required|string|max:255',
            'application_requirement' => 'sometimes|required|array',
            'intake' => 'sometimes|required|string|max:255',
            'payment_plan' => 'sometimes|required|in:monthly,per_semester,no_installements',
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