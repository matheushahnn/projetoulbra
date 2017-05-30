<?php

namespace App\Http\Requests\Cadastro;

use Illuminate\Foundation\Http\FormRequest;

class AgendaProfissionalFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'id_profissional'   => 'required',
            'data_inicial'       => 'required|date_format:"d/m/Y"',
            'hora_inicial'       => 'required',
            'data_final'          => 'required|date_format:"d/m/Y"',
            'hora_final'          => 'required',
            'status'            => 'required',
            'duracao'            => 'required|numeric',
        ];
    }
}
