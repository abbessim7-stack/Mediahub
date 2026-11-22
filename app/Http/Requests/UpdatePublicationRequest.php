<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePublicationRequest extends FormRequest
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
                \Illuminate\Validation\Rule::unique('publications', 'titre')
                    ->ignore($this->contenu) // Ignore the current publication
                    ->whereNull('deleted_at'), // Ignore soft-deleted publications
            ],
            'contenu' => 'required|string|min:20',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|file|image|max:2048',
            'fichier_media' => 'nullable|file|mimes:mp3,mp4,wav|max:100480',
        ];
    }

        public function messages(): array
    {
        return [
            // ... your existing messages ...
            'fichier_media.file' => 'Vous ne pouvez téléverser qu\'un seul fichier média à la fois.',
        ];
    }
}
