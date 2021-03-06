<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRodadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_rodada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jogo')->unique();
            $table->string('codigo_jogo')->unique();
            $table->integer('rodada_atual');
            $table->integer('id_estado_rodada');
            $table->integer('carta_preta_escolhida')->nullable();
            $table->string('cartas_brancas_escolhidas',1000)->nullable();
            $table->integer('jogador_vencedor')->nullable();
            $table->integer('carta_branca_vencedora')->nullable();
            $table->integer('id_leitor')->nullable();
            $table->boolean('leitor_trocou_cartas');
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
        Schema::dropIfExists('tb_rodada');
    }
}
