<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAmenityRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Amenity field should be filled up!!!',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(
    //         response()->json(
    //             [
    //                 'success' => false,
    //                 'message' => 'Validation failed.',
    //                 'errors' => $validator->errors(),
    //             ],
    //             422,
    //         ),
    //     );
    // }
}
