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
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'nullable',
            'slug' => 'required|alpha|unique:universities,slug,' . $this->user()->university->id,
            'image' => 'nullable|array',
            'type' => 'nullable|string|max:255',
            'founded' => 'nullable|integer',
            'no_of_students' => 'nullable|integer',
            'website_link' => 'nullable|url',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ranking' => 'nullable'
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
