<?php

use Illuminate\Database\Seeder;
use App\Models\AgendaProfissional;

class AgendaProfissionalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      AgendaProfissional::insert(
            [
                'id' => 1,
                'id_profissional' => 1,
                'data_inicial' => '2017-01-01',
                'hora_inicial' => '08:00',
                'data_final' => '2017-12-31',
                'hora_final' => '17:00',
                'duracao' => '30',
                'status' => true,
            ],
            [
                'id' => 2,
                'id_profissional' => 3,
                'data_inicial' => '2017-01-01',
                'hora_inicial' => '09:00',
                'data_final' => '2017-12-31',
                'hora_final' => '13:00',
                'duracao' => '30',
                'status' => true,
            ]
        );
    }
}
