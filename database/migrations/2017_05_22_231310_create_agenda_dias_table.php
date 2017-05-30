<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaDiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_dias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_agenda_profissional');
            $table->integer('id_paciente');
            $table->date('data');
            $table->time('hora');
            $table->text('observacao')->nullable();
            $table->integer('status')->nullable();
            $table->foreign('id_agenda_profissional')->references('id')->on('agenda_profissionais');
            $table->foreign('id_paciente')->references('id')->on('pacientes');
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
        Schema::dropIfExists('agenda_dias');
    }
}
