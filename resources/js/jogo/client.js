//config
require('../bootstrap');

const { default: axios } = require('axios');

// Enable pusher logging - don't include this in production
// Pusher.logToConsole = true;

//URL's
const getCartaPreta = window.location.origin + '/api/cartaspretas';
const getCartaBranca = window.location.origin + '/api/cartasbrancas';
const chosseCartaPreta = window.location.origin + `/api/jogoApi/${document.location.pathname.split('/')[2]}/cartapreta`;
const chosseCartaBranca = window.location.origin + `/api/jogoApi/${document.location.pathname.split('/')[2]}/cartabranca`;
const chosseVencedor = window.location.origin + `/api/jogoApi/${document.location.pathname.split('/')[2]}/vencedor`;
const changeCartas = window.location.origin + `/api/jogoApi/${document.location.pathname.split('/')[2]}/changeCartas`;
const getNickname = window.location.origin + `/api/user`;

//Variaveis
const box_cartas_brancas_leitor = document.querySelector('#box_cartas_brancas_escolhidas');
const box_cartas_pretas_leitor = document.querySelector('#box_cartas_pretas_leitor');
const botao_cartas_brancas = document.querySelectorAll('.button_carta_branca');
const botao_cartas_pretas = document.querySelectorAll('.button_carta_preta');
const cartas_pretas_leitor = document.querySelectorAll('.carta_preta_leitor');
const button_trocar_cartas = document.querySelector('#button_trocar_cartas');
const button_mostrar_cartas_brancas = document.querySelector('#button_mostrar_cartas_brancas');


window.Echo.channel('jogo-message-' + jogoId)
    .listen('.message', (data) => {
        MessageTrigger(data)
    });

window.Echo.channel('jogo-jogada-' + jogoId)
    .listen('.jogadas', (data) => {
        JogadaTrigger(data)
    })
//Adicionando funcao aos botoes de cartas pretas
if (botao_cartas_pretas.length > 0) {
    botao_cartas_pretas.forEach(carta => {
        carta.addEventListener('click', (event) => {
            let idcarta = carta.attributes.idCartaPreta.value;
            let userConfirm = confirm('Escolher carta ' + idcarta + '?');
            if (userConfirm) {
                options = {
                    method: 'POST',
                    url: chosseCartaPreta,
                    data: {
                        id_carta_preta: idcarta,
                        my_id: myId
                    }
                }

                axios(options);
                cartas_pretas_leitor.forEach(item => {
                    if (item != idcarta) {
                        item.remove();
                    }
                })
                botao_cartas_pretas.forEach(item => {
                    item.remove();
                })
            }
        })
    })
}
//Adicionando funcao aos botoes de cartas brancas
if (botao_cartas_brancas.length > 0) {
    botao_cartas_brancas.forEach(carta => {
        carta.addEventListener('click', (event) => {
            if (!carta.attributes.disabled) {
                let idcarta = carta.attributes.idCartaBranca.value;
                let userConfirm = confirm('Escolher carta ' + idcarta + '?');
                if (userConfirm) {
                    options = {
                        method: 'POST',
                        url: chosseCartaBranca,
                        data: {
                            id_carta_branca: idcarta,
                            my_id: myId
                        }
                    }
                    document.querySelector('#mensagens').innerHTML = `<p>Aguarde o Leitor escolher uma carta branca</p>`
                    axios(options);
                    botao_cartas_brancas.forEach(item => {
                        item.remove();
                    })
                }
            } else {
                alert('Aguarde o Leitor escolher uma carta branca')
            }
        })
    })
}
//Retirando botoes de cartas brancas do leitor
if (estadoJogo != 0) {
    if (myId == jogadorLeitor) {
        botao_cartas_brancas.forEach(item => {
            card = item.parentElement;
            header = item.children[0];
            item.remove()
            card.append(header)
        })
    }
}
//Adicionando funcao ao botao de trocar todas cartas brancas
if (button_trocar_cartas != null) {
    button_trocar_cartas.addEventListener('click', (event) => {
        let userConfirm = confirm('Trocar todas suas cartas brancas?');
        if (userConfirm) {
            options = {
                method: 'POST',
                url: changeCartas,
                data: {
                    my_id: myId
                }
            }
            axios(options);
            button_trocar_cartas.parentElement.parentElement.remove();
        }
    })
}
//Adicionando funcao ao botao de mostrar cartas brancas
if (button_mostrar_cartas_brancas != null) {
    button_mostrar_cartas_brancas.addEventListener('click', (event) => {
        let userConfirm = confirm('Mostrar cartas brancas?');
        if (userConfirm) {
            if (document.querySelector('.carta_branca_empty')) {
                document.querySelector('.carta_branca_empty').parentElement.remove()
            }
            let cartas_brancas = document.querySelectorAll('.carta_branca')
            cartas_brancas.forEach(item => {
                item.hidden = false
            })
            button_mostrar_cartas_brancas.remove()
        }
    })
}
//Function's
function MessageTrigger(message) {
    //primeira classe
    //1 = Partida; 2 = cartas; 3= rodada; 4 = jogador;
    debugger
    switch (message.data.tp_message[0]) {
        case 1:
            if (message.data.tp_message[1] == 2) {
                location.reload();
            } else if (message.data.tp_message[1] == 3) {
                document.querySelector('#mensagens').innerHTML = `<h1>Jogo finalizado! ${message.data.message}</h1>`
            }
            break;
        case 2:
            if (message.data.tp_message[1] == 1) {
                //loading com mensagem "Embaralhando e distirbuindo as cartas..."
            } else {
                location.reload();
            }
            break;
        case 3:
            //implementar
            break;
    }
}

function EmbaralharCartasBrancas() {
    let elements = [];
    let cartasCount = box_cartas_brancas_leitor.childElementCount
    for (i = 0; i < cartasCount; i++) {
        elements.push(box_cartas_brancas_leitor.children[0])
        box_cartas_brancas_leitor.children[0].remove()
    }
    for (i = 0; i < cartasCount; i++) {
        box_cartas_brancas_leitor.append(elements.splice((elements.length * Math.random()) >> 0, 1)[0])
        box_cartas_brancas_leitor.children[i].firstChild.attributes.removeNamedItem('cartaVirada')
    }
}

async function JogadaTrigger(message) {
    var tpJogador = TipoJogador();
    if (tpJogador == 1) {
        if (message.tp_jogada == 2) {
            if (document.querySelector('.carta_branca_empty')) {
                document.querySelector('.carta_branca_empty').parentElement.remove()
            }
            var carta = await GeradorCarta(message.cartas.id, 'branca', message.jogadorId, true);
            box_cartas_brancas_leitor.innerHTML += carta;
            let botao_cartas_brancas_leitor = document.querySelectorAll('.button_carta_branca_leitor');
            if (botao_cartas_brancas_leitor.length == jogadores.length - 1) {
                EmbaralharCartasBrancas();
                document.querySelector('#mensagens').innerHTML = `<p>Escolha a carta branca vencedora.</p>`
                botao_cartas_brancas_leitor.forEach(carta => {
                    carta.addEventListener('click', (event) => {
                        let idCartaPreta = document.querySelector('.carta_preta').attributes.idcartapreta.value
                        let idCartaBranca = carta.attributes.idCartaBranca.value;
                        let jogadorGanhador = carta.attributes.idjogador.value;
                        let userConfirm = confirm('Escolher carta ' + idCartaBranca + ' como vencedora?');
                        if (userConfirm) {
                            options = {
                                method: 'POST',
                                url: chosseVencedor,
                                data: {
                                    id_carta_preta: idCartaPreta,
                                    id_carta_branca: idCartaBranca,
                                    my_id: myId,
                                    id_jogador_ganhador: jogadorGanhador
                                }
                            }
                            axios(options);
                            botao_cartas_brancas_leitor.forEach(item => {
                                item.remove();
                            })
                        }
                    })
                })
            }
        } else if (message.tp_jogada == 1) {
            document.querySelector('#mensagens').innerHTML = `<p>Aguarde todos escolherem uma carta branca</p>`
            button_trocar_cartas.parentElement.remove();
        }
    } else {
        if (message.tp_jogada == 1) {
            botao_cartas_brancas.forEach(botao => {
                botao.attributes.removeNamedItem('disabled');
            })
            document.querySelector('#mensagens').innerHTML = `<p>Escolha uma carta branca</p>`
        }
    }
    if (message.tp_jogada == 1) {
        var carta = await GeradorCarta(message.cartas.id, 'preta', message.jogadorId);
        box_cartas_pretas_leitor.innerHTML = carta;
    }
    if (message.tp_jogada == 3) {
        user = await ConsultarUsuario(message.cartas.id_jogador)
        document.querySelector('#mensagens').innerHTML = `<p>Jogador ${user.nickname} venceu a rodada!</p>`
        var carta = await GeradorCarta(message.cartas.id_carta_branca, 'branca', message.cartas.id_jogador);
        if (document.querySelector('.carta_branca_empty')) {
            document.querySelector('.carta_branca_empty').parentElement.remove()
        }
        box_cartas_brancas_leitor.innerHTML = carta;
        let cartas_brancas = document.querySelectorAll('.carta_branca')
        cartas_brancas.forEach(item => {
            item.hidden = false
        })
    }
    if (message.tp_jogada == 4) {
        user = await ConsultarUsuario(message.cartas.id_jogador)
        document.querySelector('#mensagens').children[0].append(`   Leitor trocou suas cartas.`)
    }
}

async function GeradorCarta(id, tipo, idUser, cartaVirada = false) {
    var cartaObj;
    var option = {
        method: 'GET',
        url: ((tipo == 'branca') ? getCartaBranca : getCartaPreta) + '/' + id
    }
    cartaObj = await axios(option);
    cartaObj = cartaObj.data
    var carta = `<div class="col-md-6">`
    carta += (tipo == 'branca') ? `<div ${((cartaVirada) ? 'cartaVirada' : '')} class="carta_branca card bg-light mb-3" style="max-width: 18rem;" ` : `<div class="carta_preta card text-white bg-dark mb-3" style="max-width: 18rem;"`
    carta += ((tipo == 'branca') ? `idCartaBranca="${cartaObj.id}"` : `idCartaPreta="${cartaObj.id}"`) + ` idJogador="${idUser}">`
    carta += ((tipo == 'branca') ? `<a href='#' class='button_carta_branca_leitor' idCartaBranca="${cartaObj.id}" idJogador="${idUser}">` : `<a href='#' class=''>`)
    carta += `<div class="card-header">`
    carta += `Patuscada carta_id = ${cartaObj.id}</div></a>`
    carta += `<div class="card-body">`
    carta += `<p class="card-text">`
    carta += `${cartaObj.texto}`
    carta += `</p>`
    carta += `</div>`
    carta += `</div>`
    carta += `</div>`
    return carta;
}

async function ConsultarUsuario(id) {
    var option = {
        method: 'GET',
        url: getNickname + '/' + id
    }
    var user = await axios(option);
    user = user.data
    return user;
}