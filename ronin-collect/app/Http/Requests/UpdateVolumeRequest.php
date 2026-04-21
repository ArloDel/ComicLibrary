<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVolumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comic_id'         => 'required|exists:comics,id',
            'volume_number'    => 'required|string',
            'cover_image'      => 'nullable|image|max:2048',
            'cover_image_url'  => 'nullable|url',
            'acquisition_date' => 'nullable|date',
            'is_owned'         => 'boolean',
        ];
    }
}
