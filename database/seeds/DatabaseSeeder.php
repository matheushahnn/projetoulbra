<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory('App\Models\Pessoa', 60)->create();
        factory('App\Models\Profissional', 10)->create();
        factory('App\Models\Paciente', 50)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(ProcedimentoTableSeeder::class);
        // $this->call(PessoaTableSeeder::class);
        // $this->call(ProfissionalTableSeeder::class);
        // $this->call(PacienteTableSeeder::class);
        // $this->call(AgendaProfissionalTableSeeder::class);
    }
}
