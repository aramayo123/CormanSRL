<?php

namespace App\Http\Requests;

use App\View\Components\mi;
use Illuminate\Foundation\Http\FormRequest;

class TareaRequest extends FormRequest
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
            //
            'tipo_de_tarea' => 'required',
            'ticket' => 'required',
            'atm' => 'nullable',
            'cliente_id' => 'required',
            'sucursal_id' => 'required',
            'fecha_mail' => 'nullable',
            'fecha_cerrado' => 'nullable',
            'prioridad_id' => 'required',
            'estado_id' => 'required',
            'user_id' => 'required',
        ];
    }
}
