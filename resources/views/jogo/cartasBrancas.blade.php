<div id="box_cartas_brancas" class="row justify-element-center">
    @if (json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador == Auth::user()->id && $rodada->id_estado_rodada == 1)
        @if ($rodada->leitor_trocou_cartas == false)
            <div class="col-md-6 div_button_trocar_cartas" style="text-align: center; padding: 20px">
                <button type="button" class="btn btn-primary" id="button_trocar_cartas">Trocar todas cartas
                    brancas</button>
            </div>
        @endif
    @endif

    @if (Auth::user()->id == $jogo->id_jogador_criador)
        <div class="col-md-6 div_finalizar_rodada" style="text-align: center; padding: 20px;" hidden>
            <button type="button" class="btn btn-primary" id="buttonFinalizarRodada">Finalizar
                rodada</button>
        </div>
    @endif

    @foreach (json_decode($jogadores) as $jogador)
        @if (Auth::user()->id == $jogador->id_jogador)
            @foreach (json_decode($jogador->cartas) as $carta_branca)
                <div class="col-md-6">
                    <div class="carta_branca card bg-light mb-3" style="max-width: 18rem;"
                        idCartaBranca="{{ $carta_branca }}">
                        @if (array_search(Auth::user()->id, array_column(json_decode($rodada->cartas_brancas_escolhidas), 'id_jogador')) === false)
                            <a type="button" href="#" class="button_carta_branca"
                                idCartaBranca="{{ $carta_branca }}" disabled="disabled">
                                <div class="card-header">
                                    Patuscada carta_id = {{ $carta_branca }}
                                </div>
                            </a>
                            <div class="card-body">
                                <p class="card-text">
                                    {{ App\Models\CartasBrancas::find($carta_branca)->texto }}
                                </p>
                            </div>
                        @else
                            <div class="card-header">
                                Patuscada carta_id = {{ $carta_branca }}
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    {{ App\Models\CartasBrancas::find($carta_branca)->texto }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
</div>
