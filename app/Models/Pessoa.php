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

}
