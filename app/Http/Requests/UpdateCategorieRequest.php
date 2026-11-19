<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <--- We need this for the unique rule

class UpdateCategorieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                // Ignore the current category's ID when checking for uniqueness
                Rule::unique('categories', 'slug')->ignore($this->categorie),
            ],
        ];
    }
}
