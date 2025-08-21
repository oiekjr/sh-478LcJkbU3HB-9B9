<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReadingStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'read_on' => 'required|date',
            'impression' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

