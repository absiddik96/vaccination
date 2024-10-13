<?php

namespace App\Http\Requests\Registration;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:100'],
            'nid'            => ['required', 'string', 'unique:users,nid', 'max:20'],
            'email'          => ['required', 'email', 'max:100'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'vaccine_center' => ['required', 'integer', 'exists:vaccine_centers,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
