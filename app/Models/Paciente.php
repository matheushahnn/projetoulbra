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


    public function scopeJoinPessoa($query)
    {
        return $query->leftJoin('pessoas', 'pacientes.id_pessoa', '=', 'pessoas.id')
                ->select('pessoas.nome AS nome', 'pessoas.dtnasc', 'pacientes.ficha_atendimento', 'pacientes.id');
    }

    /**
     * Busca registros vinculados a tabela 'pessoas'.
     */
    public function pessoa()
    {
        // Cria vinculo com tabela de pessoas. Inverso de hasOne();
        return $this->belongsTo('App\Models\Pessoa', 'id_pessoa', 'id');
    }

    public function agendadias()
    {
		// Cria vinculo com tabela de pessoas. Inverso de hasOne();
        return $this->hasOne('App\Models\AgendaDia', 'id_paciente', 'id');
    }


}
