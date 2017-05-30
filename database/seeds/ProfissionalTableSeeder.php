<?php

use Illuminate\Database\Seeder;
use App\Models\Profissional;

class ProfissionalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	Profissional::insert(
            [        
                'id_pessoa' => 1,
                'codigo_cadastro' => '1231231',
            ],
            [        
            	'id_pessoa' => 3,
            	'codigo_cadastro' => '9999999',
          	]
        );
    }
}
