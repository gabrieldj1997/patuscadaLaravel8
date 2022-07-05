<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="APP_KEY" content="{{ config('broadcasting.connections.pusher.key') }}" />

    <title>Jogo</title>

    <link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/jogo.css') }}" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ url(mix('js/app.js')) }}"></script>
    @if (isset($jogo))
        <script>
            var myId = '<?= Auth::user()->id ?>';
            var estadoJogo = `<?= $jogo->estado_jogo ?>`;
            var jogoId = `<?= $jogo->id ?>`;
        </script>
        @if ($jogo->estado_jogo != 0)
            <script>
                var jogadorLeitor =
                    '<?= json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador ?>';
                var jogadorCriador = '<?= $jogo->id_jogador_criador ?>';
                var jogadores = '<?= $jogadores ?>';
                jogadores = JSON.parse(jogadores);
                jogadores = jogadores.map(i => {
                    return i.id
                })
            </script>
        @endif
    @endif
</head>

<body>
    <div class="container">

        @include('layouts.header', ['jogo', $jogo])
        @if (isset($jogo))

            {{-- Jogo estado aguardando inicio --}}
            @if ($jogo->estado_jogo == 0)
                @include('jogo.salaEspera')

                {{-- Jogo estado iniciado --}}
            @else
                <div id="mensagens">
                    @switch($rodada->id_estado_rodada)
                        {{-- Leitor escolhendo carta preta --}}
                        @case(1)
                            @if (json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador == Auth::user()->id)
                                <p>Escolha uma carta preta</p>
                            @else
                                <p>Aguarde o
                                    {{ App\Models\User::find(json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador)->nickname }}
                                    escolher uma carta preta</p>
                            @endif
                        @break

                        {{-- Jogadores escolhendo cartas brancas --}}
                        @case(2)
                            @if (json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador == Auth::user()->id)
                                <p>
                                    Aguarde jogadores escolherem as cartas brancas:
                                    @foreach (json_decode($rodada->cartas_brancas_escolhidas) as $carta_branca)
                                        {{ App\Models\User::find($carta_branca->id_jogador)->nickname }};
                                    @endforeach
                                </p>
                            @else
                                @if (array_search(Auth::user()->id, array_column(json_decode($rodada->cartas_brancas_escolhidas), 'id_jogador')) === false)
                                    <p>Escolha uma carta branca.</p>
                                @else
                                    Aguarde jogadores escolherem as cartas brancas:
                                    @foreach (json_decode($rodada->cartas_brancas_escolhidas) as $carta_branca)
                                        {{ App\Models\User::find($carta_branca->id_jogador)->nickname }};
                                    @endforeach
                                @endif
                            @endif
                        @break

                        {{-- Leitor escolhendo carta branca vencedora --}}
                        @case(3)
                            @if (json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador == Auth::user()->id)
                                <p>Escolha a carta branca vencedora.</p>
                            @else
                                <p>Aguarde o
                                    {{ App\Models\User::find(json_decode($jogadores)[($jogo->rodada_jogo - 1) % count(json_decode($jogadores))]->id_jogador)->nickname }}
                                    escolher a carta branca vencedora</p>
                            @endif
                        @break

                        {{-- Rodada finalizada --}}
                        @case(4)
                            <p>{{ App\Models\User::find($rodada->jogador_vencedor)->nickname }} ganhou esta rodada.</p>
                        @break

                    @endswitch
                </div>
                <div class="row">
                    <div class="col-6" style="padding: 0px 0px 0px 15px;">
                        @include('jogo.cartasPretas')

                        @include('jogo.cartasBrancasEscolhidas')

                        @include('jogo.pontuacao')
                    </div>
                    <div class="col-6" style="padding: 0px 15px 0px 0px;">
                        @include('jogo.cartasBrancas')
                    </div>
                </div>
            @endif
        @else
            <h1>Jogo não encontrado</h1>
            <button type="button" class="btn btn-primary"
                onclick="window.location='{{ route('index') }}'">Voltar</button>
        @endif

        @if (Auth::user()->id == $jogo->id_jogador_criador)
            <input id="inputIdJogo" type="text" style="display: none;" />
            <input id="inputJogadorGanhador" type="text" style="display: none;" />
            <input id="inputCartaBrancaDescartada" type="text" style="display: none;" />
            <input id="inputCartaPretaDescartada" type="text" style="display: none;" />
            <input id="inputCartaBrancaGanhadora" type="text" style="display: none;" />
        @endif

    </div>
</body>
@if ($jogo->estado_jogo == 0)
    <script src="{{ url(mix('js/jogo.js')) }}"></script>
@else
    <script src="{{ url(mix('js/jogo/client.js')) }}"></script>
@endif
@if (Auth::user()->id == $jogo->id_jogador_criador)
    <script src="{{ url('./js/jogo/host.js') }}"></script>
@endif

<script>
    var TipoJogador = () => {
        if (myId == jogadorLeitor) {
            return 1;
        } else {
            return 0;
        }
    }
</script>

</html>
