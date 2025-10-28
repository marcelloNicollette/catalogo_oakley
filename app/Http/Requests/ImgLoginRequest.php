<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImgLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajuste conforme necessidade de autorização
        return true;
    }

    public function rules(): array
    {
        $imageRule = 'image|mimes:jpg,jpeg,png,webp|max:5120';

        if ($this->isMethod('post')) {
            return [
                'desktop_image' => 'required|' . $imageRule,
                'mobile_image' => 'required|' . $imageRule,
            ];
        }

        // Update (PUT/PATCH)
        return [
            'desktop_image' => 'sometimes|nullable|' . $imageRule,
            'mobile_image' => 'sometimes|nullable|' . $imageRule,
        ];
    }
}