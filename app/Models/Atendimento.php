<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
	protected $fillable = [
		'id_paciente', 
		'id_profissional',
		'data', 
		'hora', 
	];    

	protected $guarded = []; #Campos que não podem ser preenchido pelo usuário (formulário).


	public function procedimento()
	{
	    return $this->hasMany('App\Models\ProcedimentoAtendimento', 'id_atendimento');
	}

}
