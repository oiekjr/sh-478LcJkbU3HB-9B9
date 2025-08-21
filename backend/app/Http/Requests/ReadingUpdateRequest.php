<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReadingUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'read_on' => 'sometimes|required|date',
            'impression' => 'sometimes|required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

