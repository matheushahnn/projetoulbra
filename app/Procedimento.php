<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedimento extends Model
{

	protected $fillable = [
		'valor', 
		'descricao', 
		'observacao',
	];    
	protected $guarded = []; #Campos que não podem ser preenchido pelo usuário (formulário).

	public function procedimentoAtendimento()
	{
	    return $this->hasOne('App\Models\ProcedimentoAtendimento', 'id_procedimento');
	}


}
