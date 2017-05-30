<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaDia extends Model
{
  protected $table = 'agenda_dias';

	protected $fillable = [
		'id_agenda_profissional',
		'id_paciente', 
		'hora', 
		'data', 
		'observacao',
		'status'
	];    

	public function agendaDia() {
	 return $this->belongsTo('App\Models\profissionais');
	}

}
