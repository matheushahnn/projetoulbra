<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{

	protected $fillable = [
		'nome', 
		'dtnasc'
	];    
	protected $guarded = []; #Campos que não podem ser preenchido pelo usuário (formulário).

  public function paciente()
  {
      return $this->hasOne('App\Models\Paciente', 'id_pessoa', 'id');
  }

  public function profissional()
  {
      return $this->hasOne('App\Models\Profissional', 'id_profissional', 'id');
  }

}
