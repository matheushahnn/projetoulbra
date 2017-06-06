<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
	protected $table = 'profissionais';

	protected $fillable = [
		'id_pessoa',
		'codigo_cadastro', 
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
  public function agendadia()
  {
    return $this->hasOne('App\Models\AgendaDia', 'id_profissional');
  }
  public function agendaProfissional()
  {
    return $this->hasOne('App\Models\AgendaProfissional', 'id_profissional');
  }
  public function atendimento()
  {
    return $this->hasOne('App\Models\Atendimento', 'id_profissional');
  }

}
