<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // For now, allow any authenticated user to update a review.
        // You might want to add more specific authorization here (e.g., user can only update their own review).
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
            'user_id' => 'sometimes|integer|exists:users,id',
            'hotel_id' => 'sometimes|integer|exists:hotels,id',
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ];
    }
}
