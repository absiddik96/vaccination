<?php

namespace App\Http\Requests\Status;

use Illuminate\Foundation\Http\FormRequest;

class StatusCheckRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nid' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
