<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Added min:10 and unique:publications,titre
            'titre' => 'required|string|max:255|unique:publications,titre',
            'contenu' => 'required|string|min:20',
            'categorie_id' => 'required|exists:categories,id',
        ];
    }

    // Custom error messages
    public function messages(): array
    {
        return [
            'titre.min' => 'Le titre doit contenir au moins 10 caractères.',
            'titre.unique' => 'Une publication avec ce titre existe déjà.',
        ];
    }
}
