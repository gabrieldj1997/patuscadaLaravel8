<div id="box_cartas_brancas_escolhidas" class="row justify-content-center">
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
</div>
