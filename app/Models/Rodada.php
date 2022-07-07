<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rodada extends Model
{
    protected $table = 'tb_rodada';

    protected $fillable = [
        'id_jogo',
        'codigo_jogo',
        'rodada_atual',
        'id_estado_rodada',
        'carta_preta_escolhida',
        'cartas_brancas_escolhidas',
        'jogador_vencedor',
        'carta_branca_vencedora',
        'id_leitor',
        'leitor_trocou_cartas'
    ];
}
