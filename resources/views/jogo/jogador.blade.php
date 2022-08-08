@if (DB::table('tb_jogador_cartas')->join('tb_jogos', 'tb_jogador_cartas.id_jogo', '=', 'tb_jogos.id')->where('tb_jogador_cartas.id_jogador', Auth::user()->id)->where('tb_jogos.estado_jogo', '1')->count() > 0)
    <div class="row" style="margin: 15px">
        <div class="tittle-stylle-1 col-12" style="text-align: center">
            <h5>Seus jogos nao terminados</h5>
        </div>
        <div class="row col-12">
            @foreach (DB::table('tb_jogador_cartas')->join('tb_jogos', 'tb_jogador_cartas.id_jogo', '=', 'tb_jogos.id')->where('tb_jogador_cartas.id_jogador', Auth::user()->id)->where('tb_jogos.estado_jogo', '1')->get() as $jogadorCartas)
                @if ($jogadorCartas->estado_jogo == 1)
                    <div class="col-6">
                        <div class="card card_jogo_aberto">
                            <a href="jogo/{{ $jogadorCartas->id_jogo }}">
                                <div class="card-header">
                                    <h5 class="card-title">Sala: {{ $jogadorCartas->id_jogo }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Codigo:
                                        {{ $jogadorCartas->codigo }}</p>
                                    <p class="card-text">Criador:
                                        {{ App\Models\User::find($jogadorCartas->id_jogador)->nickname }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
