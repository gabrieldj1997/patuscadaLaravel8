<div class="row" style="margin: 15px">
    <div class="tittle-stylle-1 col-12" style="text-align: center">
        <h5>Jogo finalizado</h5>
    </div>
    @foreach (DB::table('tb_jogador_cartas')->join('tb_jogos', 'tb_jogador_cartas.id_jogo', '=', 'tb_jogos.id')->where('tb_jogos.id', $jogo->id)->get() as $jogador)
        <div class="col-12 col-md-6">
            <div class="card card_jogo_aberto">
                    <div class="card-header">
                        <h5 class="card-title">Jogador: {{ App\Models\User::find($jogador->id_jogador)->nickname }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">pontuacao: {{ count(json_decode($jogador->pontuacao)) }}</p>
                    </div>
            </div>
        </div>
    @endforeach
</div>
