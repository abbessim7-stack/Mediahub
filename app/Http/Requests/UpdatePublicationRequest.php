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
        // Safely get the publication from either the Web route (contenu) or API route (publication)
        $publication = $this->route('contenu') ?? $this->route('publication');

        return [
            'titre' => [
                'required', 'string', 'min:10', 'max:255',
                \Illuminate\Validation\Rule::unique('publications', 'titre')
                    ->ignore($publication ? $publication->id : null) // <--- FIXED HERE
                    ->whereNull('deleted_at'),
            ],
            'contenu' => 'required|string|min:20',
            'categorie_id' => 'required|exists:categories,id',
            'image' => 'nullable|file|image|max:2048',
            'fichier_media' => 'nullable|file|mimes:mp3,mp4,wav|max:20480',
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
