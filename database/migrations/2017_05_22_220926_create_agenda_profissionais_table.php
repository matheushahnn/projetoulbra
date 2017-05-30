<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaProfissionaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_profissionais', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_profissional');
            $table->date('data_inicial');
            $table->date('data_final');
            $table->boolean('status');
            $table->time('hora_inicial');
            $table->time('hora_final');
            $table->integer('duracao');
            $table->foreign('id_profissional')->references('id')->on('profissionais');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agenda_profissionais');
    }
}
