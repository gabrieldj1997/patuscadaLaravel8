<div id="box_cartas_pretas_leitor" class="row justify-content-center">
    @if ($rodada->id_estado_rodada == 1)
        @if (json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador == Auth::user()->id)
            @foreach (json_decode($jogo->cartas_pretas_jogo) as $carta_preta)
                <div class="col-md-6">
                    <div class="carta_preta_leitor card text-white bg-dark mb-3" style="max-width: 18rem;"
                        idCartaPreta="{{ $carta_preta }}">
                        <a href="#" class="button_carta_preta" idCartaPreta="{{ $carta_preta }}">
                            <div class="card-header">
                                Patuscada
                                carta_id = {{ $carta_preta }}
                            </div>
                        </a>
                        <div class="card-body">
                            <p class="card-text">
                                {{ App\Models\CartasPretas::find($carta_preta)->texto }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-6">
                <div class="carta_preta_leitor card bg-dark text-white mb-3" style="max-width: 18rem;">

                    <div class="card-header">
                        Aguarde
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Aguarde o Leitor escolher uma carta preta para a partida
                        </p>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="col-md-6">
            <div class="carta_preta card bg-dark text-white mb-3" style="max-width: 18rem;" idCartaPreta="{{$rodada->carta_preta_escolhida}}">
                <div class="card-header">
                    Patuscada
                    carta_id = {{ $rodada->carta_preta_escolhida }}
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ App\Models\CartasPretas::find($rodada->carta_preta_escolhida)->texto }}
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
