<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Note: The guide says 'nom', but Laravel's default users table uses 'name'.
            // We will use 'name' to match the database.
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            // 'confirmed' automatically requires a 'password_confirmation' field
        ];
    }
}
