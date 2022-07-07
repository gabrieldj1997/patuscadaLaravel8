//Config
require('../bootstrap');

const { default: axios } = require('axios');

// Enable pusher logging - don't include this in production
// Pusher.logToConsole = true;

//URL's
const startGame = window.location.origin + '/api/jogoApi/start';
const finishRodada = window.location.origin + '/api/jogoApi/next';

//Variaveis
const jogadores_list = document.querySelector('#list_Jogadores');
const buttonFinalizarRodada = document.querySelector('#buttonFinalizarRodada');
const inputIdJogo = document.querySelector('#inputIdJogo');

window.Echo.channel('jogo-jogada-' + jogoId)
    .listen('.jogadas', (data) => {
        if (data.tp_jogada == 3) {
            buttonFinalizarRodada.parentElement.hidden = false
        }
    })

if (estadoJogo == 0) {
    var button_start = document.querySelector('#button_start');
    button_start.onclick = () => {
        let jogadores = [];
        let confirmMessage = 'Tem certeza que deseja iniciar o jogo? \n';
        for (i = 0; i < jogadores_list.children.length; i++) {
            confirmMessage += `Jogador ${i + 1}:  ${jogadores_list.children[i].className.replace('jogador-', '')}\n`;
            jogadores.push(parseInt(jogadores_list.children[i].attributes.user_id.value));
        }
        let host_confirm = confirm(confirmMessage);
        if (host_confirm) {
            const options = {
                method: 'POST',
                url: startGame,
                data: {
                    id_jogo: jogoId,
                    id_user: myId,
                    jogadores: jogadores
                }
            }

            axios(options);
        }
    }
}
if (buttonFinalizarRodada != null) {
    buttonFinalizarRodada.onclick = () => {
        options = {
            method: 'POST',
            url: finishRodada,
            data: {
                id_jogo: inputIdJogo.value,
                my_id: myId
            }
        }
        axios(options)

    }
}