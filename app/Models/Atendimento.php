<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
	protected $fillable = [
		'id_paciente', 
		'id_profissional',
		'id_agenda_dia',
		'data', 
		'hora', 
	];    

	protected $guarded = []; #Campos que não podem ser preenchido pelo usuário (formulário).


	public function procedimento()
	{
	    return $this->hasMany('App\Models\ProcedimentoAtendimento', 'id_atendimento');
	}
	public function profissional()
	{
	    return $this->hasOne('App\Models\Profissional', 'id_profissional');
	}

}
