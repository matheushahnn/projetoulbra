<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedimentoAtendimento extends Model
{
        
	protected $fillable = [
		'id_procedimento',
		'id_atendimento',
		'quantidade',
		'observacao',
	];    

	protected $guarded = []; #Campos que não podem ser preenchido pelo usuário (formulário).


	public function atendimento()
	{
	    return $this->belongsTo('App\Models\Atendimento', 'id_procedimento');
	}

}
