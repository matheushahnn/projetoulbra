<?php

namespace App\Http\Requests\Atendimento;

use Illuminate\Foundation\Http\FormRequest;

class AtendimentoFormRequest extends FormRequest
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
            'id_paciente'            => 'required',
            'id_profissional'        => 'required',
            'data'                   => 'required',
            'hora'                   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id_paciente'       => "O campo paciente é obrigatório",
            'id_profissional'   => "O campo profissional é obrigatório",
            'data.required'     => 'O campo data é obrigatório.',
            'hora'              => "O campo hora é obrigatório",
        ];
    }
    
}
