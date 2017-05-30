<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaltaProfissionaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('falta_profissionais', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_profissional');
            $table->date('data_inicial');
            $table->date('data_final');
            $table->integer('status');
            $table->time('hora_incial');
            $table->time('hora_final');
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
