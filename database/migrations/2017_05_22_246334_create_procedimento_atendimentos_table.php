<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedimentoAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedimento_atendimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_atendimento');
            $table->integer('id_procedimento');
            $table->integer('quantidade');
            $table->text('observacao');
            $table->foreign('id_atendimento')->references('id')->on('atendimentos')->onDelete('cascade');
            $table->foreign('id_procedimento')->references('id')->on('procedimentos');
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
        Schema::dropIfExists('procedimento_atendimentos');
    }
}
