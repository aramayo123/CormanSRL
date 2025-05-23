<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
            'rubro' => 'required|string',
            'descripcion' => 'required|string|unique:materiales',
            'unidad' => 'required|string',
       ];
    }
    public function messages()
    {
        return [
            'descripcion.unique' => 'La descripcion del material ya existe.',
        ];
    }
}
