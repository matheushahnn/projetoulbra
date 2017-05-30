<?php

use Illuminate\Database\Seeder;
use App\Models\Paciente;

class PacienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Paciente::insert(
          [
            'id' => 1,
            'id_pessoa' => 1,
            'ficha_atendimento' => 1
          ],
          [
            'id' => 1,
            'id_pessoa' => 2,
            'ficha_atendimento' => 1
          ]
        );
    }
}
