<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_estado_jogo', function (Blueprint $table) {
            $table->string('id_estado_jogo')->primary();
            $table->string('descricao_estado_jogo');
        });

        DB::table('tb_estado_jogo')->insert([
        ['id_estado_jogo' => 0, 'descricao_estado_jogo' => 'jogo criado'],
        ['id_estado_jogo' => 1, 'descricao_estado_jogo' => 'jogo iniciado'],
        ['id_estado_jogo' => 2, 'descricao_estado_jogo' => 'jogo finalizado'],
    ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_estado_jogo');
    }
};
