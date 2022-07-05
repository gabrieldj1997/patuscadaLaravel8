<div id="box_cartas_brancas_escolhidas" class="row justify-content-center">
    @if ($rodada->id_estado_rodada == 3 && json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador == Auth::user()->id)
        @if (count(json_decode($rodada->cartas_brancas_escolhidas)) > 0)
            @foreach (json_decode($rodada->cartas_brancas_escolhidas) as $carta)
                <div class="col-md-6">
                    @if (count(json_decode($rodada->cartas_brancas_escolhidas)) == count($jogadores) - 1)
                        <div class="carta_branca carta_branca_empty card bg-light mb-3" style="max-width: 18rem;">
                        @else
                            <div cartaVirada class="carta_branca carta_branca_empty card bg-light mb-3"
                                style="max-width: 18rem;">
                    @endif
                    <div class="card-header">
                        Aguarde
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Aguarde os jogadores escolherem as cartas brancas
                        </p>
                    </div>
                </div>
</div>
@endforeach
@else
<div class="col-md-6">
    <div class="carta_branca carta_branca_empty card bg-light mb-3" style="max-width: 18rem;">
        <div class="card-header">
            Aguarde
        </div>
        <div class="card-body">
            <p class="card-text">
                Aguarde os jogadores escolherem as cartas brancas
            </p>
        </div>
    </div>
</div>
@endif
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
