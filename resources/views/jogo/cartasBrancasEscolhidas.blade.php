<div id="box_cartas_brancas_escolhidas" class="row justify-content-center">
    @if (($rodada->id_estado_rodada == 2 || $rodada->id_estado_rodada == 3) && count(json_decode($rodada->cartas_brancas_escolhidas)) > 0)
        @foreach (json_decode($rodada->cartas_brancas_escolhidas) as $objCarta)
            <div class="col-md-6">
                <div cartavirada class="carta_branca card bg-light mb-3" style="max-width: 18rem;">
                    <a href='#' class='button_carta_branca_leitor' idCartaBranca="{{ $objCarta->carta_branca[0] }}"
                        idJogador="{{ $objCarta->id_jogador }}">
                        <div class="card-header">
                            Patuscada carta_id = {{ $objCarta->carta_branca[0] }}
                        </div>
                    </a>
                    <div class="card-body">
                        <p class="card-text">
                            {{ App\Models\CartasBrancas::find($objCarta->carta_branca[0])->texto }}
                        </p>
                    </div>
                    <div class="card-back">
                        {{ App\Models\User::find($objCarta->id_jogador)->nickname }}
                    </div>
                </div>
            </div>
        @endforeach
    @elseif($rodada->id_estado_rodada == 4)
        <div class="col-md-6">
            <div class="carta_branca card bg-light mb-3" style="max-width: 18rem;" idcartabranca="{{$rodada->carta_branca_vencedora}}">

                <div class="card-header">
                    Patuscada carta_id = {{ $rodada->carta_branca_vencedora }}
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ App\Models\CartasBrancas::find($rodada->carta_branca_vencedora)->texto }}
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="carta_branca carta_branca_empty card bg-light mb-3" style="max-width: 18rem;">

                <div class="card-header">
                    Aguarde
                </div>
                <div class="card-body">
                    <p class="card-text">
                        @if (json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador == Auth::user()->id)
                            Aguarde os jogadores escolherem as cartas brancas
                        @else
                            Aguarde o Leitor escolher uma carta branca vencedora
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
