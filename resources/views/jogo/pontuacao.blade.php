<div id="pontuacao_board" class="row justify-content-center">
    <div class="col-md-6">
    <h2>Pontuação:</h2>
    <div id="pontuacao">
        @foreach ($jogadores as $jogador)
            <div>
                <p>{{ App\Models\User::find($jogador->id_jogador)->nickname }} :
                    {{ count(json_decode($jogador->pontuacao)) }}</p>
            </div>
        @endforeach
        <div>
            <p>Cartas Brancas restantes:
                {{ count(json_decode($jogo->cartas_brancas_monte)) }}
            </p>
        </div>
        <div>
            <p>Cartas Pretas restantes:
                {{ count(json_decode($jogo->cartas_pretas_monte)) }}
            </p>
        </div>
    </div>
    </div>
</div>