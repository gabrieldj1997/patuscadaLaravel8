@if (App\Models\Jogo::where('estado_jogo', 0)->get()->count() > 0)
    <div class="row" style="margin: 15px">
        <div class="tittle-stylle-1 col-12" style="text-align: center">
            <h5>Jogos em aberto</h5>
        </div>
        <div class="row col-12">
            @foreach (App\Models\Jogo::where('estado_jogo', 0)->get() as $jogo)
                <div class="col-6">
                    <div class="card card_jogo_aberto">
                        <a href="jogo/{{ $jogo->id }}">
                            <div class="card-header">
                                <h5 class="card-title">Sala: {{ $jogo->id }}</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Codigo: {{ $jogo->codigo }}</p>
                                <p class="card-text">Criador:
                                    {{ App\Models\User::find($jogo->id_jogador_criador)->nickname }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="row" style="margin: 15px">
        <div class="tittle-stylle-1 col-12" style="text-align: center">
            <h5>Sem jogos em aberto</h5>
        </div>
    </div>
@endif
