<?php

use Illuminate\Database\Seeder;
use App\Models\Pessoa;

class PessoaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pessoa::insert([
            [
                'id' => 1,
                'nome' => 'Matheus Hahn.',
                'dtnasc' => '1993-12-06',
            ],
            [
                'id' => 2,
                'nome' => 'Jonson Stoncio',
                'dtnasc' => '1983-10-26',
            ],
            [
                'id' => 3,
                'nome' => 'Coragem o Cão Covarde',
                'dtnasc' => '1983-10-26',
            ],
            [
                'id' => 4,
                'nome' => 'Lorde Lucas',
                'dtnasc' => '1987-03-16',
            ],
            [
                'id' => 5,
                'nome' => 'sdlkjs jdskjsd',
                'dtnasc' => '1987-03-16',
            ],
            [
                'id' => 6,
            	'nome' => 'lalalalal lalsalsa',
            	'dtnasc' => '1987-03-16',
            ]
        ]);
    }
}
