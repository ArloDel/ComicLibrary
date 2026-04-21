<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVolumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comic_id'         => 'required|exists:comics,id',
            'volume_start'     => 'required|integer|min:1',
            'volume_end'       => 'nullable|integer|gte:volume_start',
            'cover_image'      => 'nullable|image|max:2048',
            'acquisition_date' => 'nullable|date',
            'is_owned'         => 'boolean',
        ];
    }
}
