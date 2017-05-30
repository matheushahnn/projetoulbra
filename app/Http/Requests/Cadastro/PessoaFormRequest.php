<?php

namespace App\Http\Requests\Cadastro;

use Illuminate\Foundation\Http\FormRequest;

class PessoaFormRequest extends FormRequest
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
        ];
    }

    public function messages() 
    {
        return [
            'nome.required' => 'O campo nome é obrigatório!',
            'dtnasc.required' => 'O campo data de nascimento é obrigatório!',
            'dtnasc.date_format' => 'O campo data de nascimento precisa possuir um valor de dia válido (dd/mm/aaaa)!',
        ];
    }
}
