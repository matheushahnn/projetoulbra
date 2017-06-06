<?php

namespace App\Http\Requests\Cadastro;

use Illuminate\Foundation\Http\FormRequest;

class PacienteFormRequest extends FormRequest
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
            'nome' => 'required',
            'dtnasc' => 'required|date_format:"d/m/Y"',
            'ficha_atendimento' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'dtnasc.required' => 'O campo data nascimento é obrigatório.',
            'dtnasc.data_format' => "O campo data nascimento deve ser no formato 'DD/MM/AAAA'",
        ];
    }

}
