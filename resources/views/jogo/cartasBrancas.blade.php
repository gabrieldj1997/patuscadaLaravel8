<div id="box_cartas_brancas" class="row justify-element-center">
    @if (json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador == Auth::user()->id)
        <div class="col-md-6" style="text-align: center; padding: 20px">
            <div id="div_button_leitor">
                <button type="button" class="btn btn-primary" id="button_trocar_cartas">Trocar todas cartas
                    brancas</button>
                <button type="button" class="btn btn-primary" id="button_mostrar_cartas_brancas" hidden>Mostrar cartas
                    brancas</button>
            </div>
        </div>
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
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
</div>
