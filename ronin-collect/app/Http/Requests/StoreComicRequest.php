<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComicRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'           => 'required|string|max:255',
            'author'          => 'required|string|max:255',
            'description'     => 'nullable|string',
            'cover_image'     => 'nullable|image|max:2048',
            'cover_image_url' => 'nullable|url',
            'status'          => 'required|in:reading,completed,wishlist,plan_to_read',
            'priority'        => 'nullable|in:low,medium,high,extreme',
            'price'           => 'nullable|numeric',
            'tags_input'      => 'nullable|string',
        ];
    }
}
