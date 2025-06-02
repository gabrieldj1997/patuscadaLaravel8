<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <a class="navbar-brand" href="{{ route('index') }}">Patuscada</a>
        </div>
    </div>
    @if (!isset($jogo))
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <div>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('index') }}">GBLTech</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal"
                            data-target="#modal-game-rules">Regras</a>
                    </li>
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('chat') }}">chat</a>
                        </li>
                        <li class="nav-item">
                            <a id="button-modal-game" class="nav-link" href="#" data-toggle="modal"
                                data-target="#modal-game-create">Criar Jogo</a>
                        </li>
                        <li class="nav-item">
                            <a id="button_game_enter" class="nav-link" href="#" data-toggle="modal"
                                data-target="#modal-game-enter">Entrar
                                Jogo</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        @if (Auth::check())
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('login.logout') }}">Log out</a>
                                <a class="dropdown-item" href="#">Alterar senha (não ativado)</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#modal-delete-user">Excluir meu login</a>
                                @if (Auth::user()->tp_usuario == 1)
                                    <a class="dropdown-item" href="#">Excluir um login (não ativado)</a>
                                    <a class="dropdown-item" href="{{ route('login.truncate') }}">Excluir todos
                                        login</a>
                                @endif
                            </div>
                        @else
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('Login') }}
                            </a>
                            <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#modal-login-cadaster">Log up</a>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#modal-form-login">Log in</a>
                            </div>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">version 3.5.0</a>
                    </li>

                </ul>
            </div>
        </div>
    @else
        <ul class="navbar-nav mr-auto">
            <div class="row row-cols-12">
                <div class="col">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('index') }}">Voltar</a>
                    </li>
                </div>
                <div class="col">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">{{ $jogo->codigo }}</a>
                    </li>
                </div>
                @if ($jogo->estado_jogo == 1 && Auth::user()->id == $jogo->id_jogador_criador)
                    <div class="col">
                        <li class="nav-item active">
                            <a class="nav-link" href="finish/{{ $jogo->id }}">Finalizar</a>
                        </li>
                    </div>
                @endif
            </div>
        </ul>
    @endif
</nav>
<div id="modal-game-rules" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark modal-style">
                <h5 class="modal-title">Regras</h5>
                <button type="button" class="btn btn-danger" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark modal-style">
                <p>O jogo consiste em cartas de perguntas e respostas, cartas pretas são perguntas e cartas brancas
                    respostas;</p>
                <p>Para começar o jogo será distribuídas 5 cartas brancas para cada jogador, assim está pronto para
                    começar a primeira rodada.</p>
                <p>Para cada rodada será escolhido um jogador "Leitor" que lhe será apresentada 3 cartas pretas
                    aleatórias, o Leitor deverá escolher apenas uma.</p>
                <p>A carta escolhida pelo Leitor será apresentada aos outros jogadores, as outras serão devolvidas ao
                    monte.</p>
                <p>Após a carta preta ser revelada, todos os jogadores escolherão uma carta branca das 5 que ele tem. As
                    cartas são viradas de face para baixo e reveladas apenas quando todos tiverem escolhido suas
                    respectivas cartas.</p>
                <p>Logo após de todos os jogadores terem escolhido uma carta branca, o Leitor então poderá ler as
                    respostas e escolher conforme seu critério a carta vencedora.</p>
                <p>O jogador que escolheu a carta branca vencedora será o vencedor da rodada, podendo assim finalizar a
                    rodada e começar uma nova, assim como um Leitor novo.</p>
            </div>
            <div class="modal-footer bg-dark modal-style">
                <p>@GBLTech produção</p>
            </div>
        </div>
    </div>
</div>
@if (!isset($jogo))
    @if (Auth::check())
        @include('layouts.modalForm', [
            'id_modal' => 'modal-delete-user',
            'title_modal' => 'Deletar meu usuario',
            'id_modal_form' => 'form_delete',
            'method_modal_form' => 'POST',
            'action_modal_form' => route('login.delete', Auth::user()->id),
            'inputs_modal_form' => [
                (object) [
                    'label' => 'Confirme sua senha:',
                    'id' => 'password',
                    'name' => 'password',
                    'type' => 'text',
                ],
            ],
            'text_modal_button' => 'Texto do botão',
        ])
        @include('layouts.modalForm', [
            'id_modal' => 'modal-game-create',
            'title_modal' => 'Criar Sala de Jogo',
            'id_modal_form' => 'form_game',
            'method_modal_form' => 'POST',
            'action_modal_form' => route('jogo.create'),
            'inputs_modal_form' => [
                (object) [
                    'label' => 'Codigo do sala: (max 5 caracter)',
                    'id' => 'input-codigo',
                    'name' => 'codigo_jogo',
                    'type' => 'text',
                ],
            ],
            'text_modal_button' => 'Criar',
        ])
        @include('layouts.modalForm', [
            'id_modal' => 'modal-game-enter',
            'title_modal' => 'Entrar Sala de Jogo',
            'id_modal_form' => 'form_game_input',
            'method_modal_form' => 'POST',
            'action_modal_form' => route('jogoApi.find'),
            'inputs_modal_form' => [
                (object) [
                    'label' => 'Codigo do sala:',
                    'id' => 'input-codigo_enter',
                    'name' => 'codigo',
                    'type' => 'text',
                ],
            ],
            'text_modal_button' => 'Entrar',
        ])
    @else
        @include('layouts.modalForm', [
            'id_modal' => 'modal-form-login',
            'title_modal' => 'Login',
            'id_modal_form' => 'form_login',
            'method_modal_form' => 'POST',
            'action_modal_form' => route('login.autenticate'),
            'inputs_modal_form' => [
                (object) [
                    'label' => 'nickname:',
                    'id' => 'input_nickname',
                    'name' => 'nickname',
                    'type' => 'text',
                ],
                (object) [
                    'label' => 'senha:',
                    'id' => 'input_password',
                    'name' => 'password',
                    'type' => 'password',
                ],
            ],
            'text_modal_button' => 'Entrar',
        ])
        @include('layouts.modalForm', [
            'id_modal' => 'modal-login-cadaster',
            'title_modal' => 'Cadastrar Login',
            'id_modal_form' => 'login_cadaster_form',
            'method_modal_form' => 'POST',
            'action_modal_form' => route('login.register'),
            'inputs_modal_form' => [
                (object) [
                    'label' => 'Digite seu nome:',
                    'id' => 'name_input',
                    'name' => 'name',
                    'type' => 'text',
                ],
                (object) [
                    'label' => 'Digite seu nick:',
                    'id' => 'nickname_input',
                    'name' => 'nickname',
                    'type' => 'text',
                ],
                (object) [
                    'label' => 'Digite uma senha:',
                    'id' => 'password_input',
                    'name' => 'password',
                    'type' => 'password',
                ],
                (object) [
                    'label' => 'Confirme sua senha:',
                    'id' => 'password_confirmation_input',
                    'name' => 'password_confirmation',
                    'type' => 'password',
                ],
                (object) [
                    'label' => 'Digite seu email: (opcional)',
                    'id' => 'email_input',
                    'name' => 'email',
                    'type' => 'text',
                ],
            ],
            'text_modal_button' => 'Entrar',
        ])
    @endif
@endif
