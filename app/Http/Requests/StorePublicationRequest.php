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
            'titre' => [
                'required', 'string', 'min:10', 'max:255',
                // Only check uniqueness among records that are NOT soft-deleted
                \Illuminate\Validation\Rule::unique('publications', 'titre')->whereNull('deleted_at'),
            ],
            'contenu' => 'required|string|min:20',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|file|image|max:2048',
            'fichier_media' => 'nullable|file|mimes:mp3,mp4,wav|max:100480',
        ];
    }
    // Custom error messages
        public function messages(): array
    {
        return [
            // ... your existing messages ...
            'fichier_media.file' => 'Vous ne pouvez téléverser qu\'un seul fichier média à la fois.',
        ];
    }
}
