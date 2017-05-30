<?php

namespace App\Http\Requests\Cadastro;

use Illuminate\Foundation\Http\FormRequest;

class ProcedimentoFormRequest extends FormRequest
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
            'descricao' => 'required|min:3|max:100',
            'valor' => 'required|numeric',
            'observacao' => 'min:3'
        ];
    }

    public function messages() 
    {
        return [
            'descricao.required' => 'O campo descrição é obrigatório!',
            'descricao.min' => 'O campo descrição precisa possuir no mínimo 3 caracteres!',
            'descricao.max' => 'O campo descrição precisa possuir no máximo 100 caracteres!',
            'observacao.min' => 'O campo observação precisa possuir no mínimo 3 caracteres!',
            'valor.numeric' => 'O campo valor precisa ser numérico!',
        ];
    }
}
