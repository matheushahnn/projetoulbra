<?php

use Illuminate\Database\Seeder;
use App\Procedimento;

class ProcedimentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Procedimento::insert([

        	[
	        	'descricao' => 'Anestesia',
                'observacao' => 'Este procedimento deve ser realizado em jejum.',
                'valor' => '10.0',
            ],
            [
                'descricao' => 'Retirada de dente',
                'observacao' => 'Este procedimento deve ser realizado em jejum.',
                'valor' => '50.0',
            ],
            [
                'descricao' => 'Retirada de ciso',
                'observacao' => 'Este procedimento deve ser realizado em jejum.',
                'valor' => '200.0',
            ],
            [
                'descricao' => 'Raio-X',
	        	'observacao' => 'Este procedimento deve ser realizado em jejum.',
                'valor' => '30.0',
        	]


        ]);
    }
}
