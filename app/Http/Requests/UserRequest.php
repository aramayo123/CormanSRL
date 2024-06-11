<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'El nombre de usuario ya existe.',
            'email.required' => 'El email es obligatorio.',
            'email.unique' => 'El email ya existe.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener almenos 8 caracteres.',
        ];
    }
}
