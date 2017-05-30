<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
        	'name' => 'Matheus Hahn.',
        	'email' => 'hahnnmatheus@gmail.com',
        	'password' => bcrypt('123'),
        ],
        [
        	'name' => 'Professor.',
        	'email' => 'prof@prof.com',
        	'password' => bcrypt('123'),
        ]);
    }
}
