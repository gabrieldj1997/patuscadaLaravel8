<div class="row justify-content-center">
    <div class="col-md-6">
        <div id="sala_espera">
            <h1>Codigo do jogo: {{ $jogo->codigo }}</h1>
            <h2>Jogadores:</h2>
            <div id="list_Jogadores">
            </div>
            <br>
            <div class="row justify-content-center">
                @if (Auth::user()->id == $jogo->id_jogador_criador)
                    <div class="col-md-6" style="text-align: center">
                        <button type="button" class="btn btn-primary" id="button_start">Iniciar Partida</button>
                    </div>
                    <div class="col-md-6" style="text-align: center">
                        <button type="button" class="btn btn-danger" id="button_delete">Deletar Partida</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
