<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'secretary_name' => ['nullable', 'string', 'max:255'],
            'clinic_name' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
            'default_consultation_price' => ['required', 'numeric', 'min:0'],
            'default_session_price' => ['nullable', 'numeric', 'min:0'],
            'has_sessions_system' => ['nullable', 'boolean'],
            'locale' => ['nullable', 'string', 'in:ar,en'],
        ];
    }
}
