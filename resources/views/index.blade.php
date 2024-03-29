<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Patuscada v.Dj1997</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/e68b1aba6f.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">

        @include('layouts.header')

        @if (Session::has('message'))
            <div class="alert alert-success">
                {{ Session::get('message') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $input_error)
                <div class="alert alert-danger">
                    {{ $input_error }}
                </div>
            @endforeach
        @endif

        @if (!Auth::check())
            <div class="tittle-stylle-1 col-12" style="text-align: center">
                <h5>Faca o login e comece a jogar agora!</h5>
            </div>
        @else
            @include('jogo.jogoAberto')

            @include('jogo.jogador')
        @endif

        @include('layouts.footer')
    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
@if (Auth::check())
    <script>
        document.querySelector('#button-modal-game').onclick = () => {
            document.querySelector('#input-codigo').value = ''
            let codigo = ''
            for (i = 0; i < 5; i++) {
                codigo += String.fromCharCode(Math.floor((Math.random() * 26) + 65))
            }
            document.querySelector('#input-codigo').value = codigo
        }
        document.querySelector('#input-codigo_enter').addEventListener('keyup', (event) => {
            event.target.value = event.target.value.toUpperCase()
        }, false)
        document.querySelector('#input-codigo').addEventListener('keyup', (event) => {
            event.target.value = event.target.value.toUpperCase()
        }, false)
    </script>
@endif

</html>
