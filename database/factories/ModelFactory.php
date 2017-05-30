<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//@var \Illuminate\Database\Eloquent\Factory $factory

$factory->define(App\Models\Pessoa::class, function (Faker\Generator $faker) {

    return [
        'nome' => $faker->name,
        'dtnasc' => $faker->dateTime(),
    ];

});

$factory->define(App\Models\Paciente::class, function (Faker\Generator $faker) {

    return [
        'id_pessoa' => App\Models\Pessoa::all()->random()->id,
        'ficha_atendimento' => $faker->randomNumber(3),
    ];

});

$factory->define(App\Models\Profissional::class, function (Faker\Generator $faker) {

    return [
        'id_pessoa' => App\Models\Pessoa::all()->random()->id,
        'codigo_cadastro' => $faker->text(10),
    ];

});
