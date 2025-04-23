<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUniversityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'nullable',
            'slug' => 'required|alpha|unique:universities,slug',
            'image' => 'nullable|array',
            'ranking' => 'required'
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status' => 'update-fail',
            'statusCode' => 422,
            'message' => 'Validation Error',
            'data' => $validator->errors()
        ], 422));
    }
}
