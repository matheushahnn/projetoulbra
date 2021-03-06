<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaProfissional extends Model
{
	protected $table = 'agenda_profissionais';

	protected $fillable = [
		'id_profissional',
		'data_inicial', 
		'hora_inicial', 
		'data_final', 
		'hora_final', 
		'status', 
		'duracao', 
	];    
	protected $guarded = []; #Campos que não podem ser preenchido pelo usuário (formulário).


	public function profissional() 
	{
		 return $this->belongsTo('App\Models\Profissional', 'id_profissional');
	}

	public function agendaDia() 
	{
    return $this->hasOne('App\Models\AgendaDia', 'id_agenda_profissional');
	}

}
