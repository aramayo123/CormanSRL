<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SucursalRequest extends FormRequest
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
            'zona' => 'required|string',
            'numero' => 'required|numeric',
            'sucursal' => 'required|string',
            'direccion' => 'required|string|unique:sucursales',
        ];
    }
    public function messages()
    {
        return [
            'zona.required' => 'La zona es obligatoria.',
            'zona.string' => 'La zona debe ser un texto.',
            'numero.required' => 'El numero es obligatorio',
            'numero.numeric' => 'El numero no puede ser un texto.',
            'direccion.unique' => 'La direccion debe ser unica.',
            'direccion.required' => 'La direccion es obligatoria.',
            'direccion.string' => 'La direccion debe ser un texto.',
            'sucursal.required' => 'La sucursal es obligatoria.',
            'sucursal.string' => 'La sucursal debe ser un texto.',
        ];
    }
}
