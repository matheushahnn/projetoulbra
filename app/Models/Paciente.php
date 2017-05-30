<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    
	protected $fillable = [
		'id_pessoa',
		'ficha_atendimento',
	];    
	protected $guarded = []; #Campos que não podem ser preenchido pelo usuário (formulário).


    /**
     * Busca registros vinculados a tabela 'pessoas'.
     */
    public function pessoa()
    {
		// Cria vinculo com tabela de pessoas. Inverso de hasOne();
        return $this->belongsTo('App\Models\Pessoa', 'id_pessoa');
    }


}
