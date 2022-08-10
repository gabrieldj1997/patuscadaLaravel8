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
RodadaEstado(rodada)

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
                    if (item.attributes.idcartapreta.value != idcarta) {
                        item.parentElement.remove();
                    }
                })

                if (button_trocar_cartas != null) {
                    button_trocar_cartas.parentElement.remove();
                }
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
                    document.querySelector('#mensagens').innerHTML = `<p>Aguarde os outros jogadores escolherem uma carta branca</p>`
                    axios(options);
                    RetirarBotaoCartasBrancasJogador()
                }
            } else {
                alert('Aguarde o Leitor escolher uma carta branca')
            }
        })
    })
}
//Retirando botoes de cartas Leitor e Jogador
if (estadoJogo != 0) {
    if (myId == jogadorLeitor) {
        RetirarBotaoCartasBrancasJogador()
    } else {
        RetirarBotaoCartasBrancasLeitor()
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
            button_trocar_cartas.parentElement.remove();
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
    switch (message.data.tp_message[0]) {
        case 1:
            if (message.data.tp_message[1] == 2) {
                location.reload();
            } else if (message.data.tp_message[1] == 3) {
                RodadaEstado(4);
            }
            break;
        case 2:
            if (!(message.data.tp_message[1] == 1)) {
                location.reload();
            }
            break;
        case 3:
            //implementar
            break;
    }
}

async function JogadaTrigger(message) {
    var tpJogador = TipoJogador();
    if (tpJogador == 1) {//Leitor
        if (message.tp_jogada == 1) {
            document.querySelector('#mensagens').innerHTML = `<p>Aguarde jogadores escolherem as cartas brancas: </p>`
        } else if (message.tp_jogada == 2) {
            if (document.querySelector('.carta_branca_empty')) {
                document.querySelector('.carta_branca_empty').parentElement.remove()
            }
            var carta = await GeradorCarta(message.cartas.id, 'branca', message.jogadorId, true);
            var leitor = await ConsultarUsuario(jogadorLeitor)
            box_cartas_brancas_leitor.innerHTML += carta;
            let botao_cartas_brancas_leitor = document.querySelectorAll('.button_carta_branca_leitor');
            if (botao_cartas_brancas_leitor.length == jogadores.length - 1) {
                window.navigator.vibrate(600)
                EmbaralharCartasBrancas();
                document.querySelector('#mensagens').innerHTML = `<p>Escolha a carta branca vencedora.</p>`
                botao_cartas_brancas_leitor.forEach(carta => {
                    carta.addEventListener('click', (event) => {
                        let idCartaBranca = carta.attributes.idCartaBranca.value;
                        let jogadorGanhador = carta.attributes.idjogador.value;
                        let userConfirm = confirm('Escolher carta ' + idCartaBranca + ' como vencedora?');
                        if (userConfirm) {
                            options = {
                                method: 'POST',
                                url: chosseVencedor,
                                data: {
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
        }
    } else {//Jogador
        if (message.tp_jogada == 1) {
            window.navigator.vibrate(600)
            botao_cartas_brancas.forEach(botao => {
                botao.attributes.removeNamedItem('disabled');
            })
            document.querySelector('#mensagens').innerHTML = `<p>Escolha uma carta branca</p>`
            var carta = await GeradorCarta(message.cartas.id, 'preta', message.jogadorId);
            box_cartas_pretas_leitor.innerHTML = carta;
        } else if (message.tp_jogada == 2) {
            if (document.querySelector('.carta_branca_empty')) {
                document.querySelector('.carta_branca_empty').parentElement.remove()
            }
            var carta = await GeradorCarta(message.cartas.id, 'branca', message.jogadorId, true);
            var leitor = await ConsultarUsuario(jogadorLeitor)
            box_cartas_brancas_leitor.innerHTML += carta;
            let botao_cartas_brancas_leitor = document.querySelectorAll('#box_cartas_brancas_escolhidas .carta_branca');
            if (botao_cartas_brancas_leitor.length == jogadores.length - 1) {
                window.navigator.vibrate(200)
                EmbaralharCartasBrancas();
                document.querySelector('#mensagens').innerHTML = `<p>Aguarde o ${leitor.nickname} escolher a carta branca vencedora</p>`
                RetirarBotaoCartasBrancasLeitor()
            }
        }
    }
    if (message.tp_jogada == 1) {
        RetirarBotaoCartasPreta()
    } else if (message.tp_jogada == 3) {
        window.navigator.vibrate(200)
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
    } else if (message.tp_jogada == 4) {
        window.navigator.vibrate(200)
        user = await ConsultarUsuario(message.cartas.id_jogador)
        document.querySelector('#mensagens').children[0].append(`   Leitor trocou suas cartas.`)
    }
}

async function GeradorCarta(id, tipo, idUser, cartavirada = false) {
    var cartaObj;
    var option = {
        method: 'GET',
        url: ((tipo == 'branca') ? getCartaBranca : getCartaPreta) + '/' + id
    }
    cartaObj = await axios(option);
    cartaObj = cartaObj.data
    user = await ConsultarUsuario(idUser)
    var carta = `<div class="col-md-6">`
    carta += (tipo == 'branca') ? `<div ${((cartavirada) ? 'cartavirada' : '')} class="carta_branca card bg-light mb-3" style="max-width: 18rem;" ` : `<div class="carta_preta_leitor card text-white bg-dark mb-3" style="max-width: 18rem;"`
    carta += ((tipo == 'branca') ? `idCartaBranca="${cartaObj.id}"` : `idCartaPreta="${cartaObj.id}"`) + ` idJogador="${idUser}">`
    carta += ((tipo == 'branca') ? `<a href='#' class='button_carta_branca_leitor' idCartaBranca="${cartaObj.id}" idJogador="${idUser}">` : `<a href='#' class=''>`)
    carta += `<div class="card-header">`
    carta += `Patuscada carta_id = ${cartaObj.id}</div></a>`
    carta += `<div class="card-body">`
    carta += `<p class="card-text">`
    carta += `${cartaObj.texto}`
    carta += `</p>`
    carta += `</div>`
    carta += `<div class="card-back"><p>${user.nickname}</p></div>`
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

function RodadaEstado(id) {
    switch (id) {
        case '1':
            Estado1();
            break;
        case '2':
            Estado2();
            break;
        case '3':
            Estado3();
            break;
        case '4':
            Estado4();
            break;
    }
}

function Estado1() {
    //vincular função a cartas pretas do leitor
    //vincular função de alerta nas cartas brancas jogadores
}

function Estado2() {
    botao_cartas_brancas.forEach(botao => {
        botao.attributes.removeNamedItem('disabled');
    })
}

function Estado3() {
    EmbaralharCartasBrancas()
    if (myId == jogadorLeitor) {
        let botao_cartas_brancas_leitor = document.querySelectorAll('.button_carta_branca_leitor');
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
}

function Estado4() {
    if (myId == jogadorCriador) {
        document.querySelector('.div_finalizar_rodada').hidden = false;
    }
}

function RetirarBotaoCartasBrancasJogador() {
    document.querySelectorAll('#box_cartas_brancas .carta_branca').forEach(i => {
        header = i.children[0].children
        i.children[0].remove()
        i.insertAdjacentHTML('afterBegin', header[0].outerHTML)
    })
}

function RetirarBotaoCartasPreta() {
    document.querySelectorAll('#box_cartas_pretas_leitor .carta_preta_leitor').forEach(i => {
        header = i.children[0].children
        i.children[0].remove()
        i.insertAdjacentHTML('afterBegin', header[0].outerHTML)
    })
}

function RetirarBotaoCartasBrancasLeitor() {
    document.querySelectorAll('#box_cartas_brancas_escolhidas .carta_branca').forEach(i => {
        if (i.children[0].tagName == "A") {
            header = i.children[0].children
            i.children[0].remove()
            i.insertAdjacentHTML('afterBegin', header[0].outerHTML)
        }
    })
}

function EmbaralharCartasBrancas() {
    let elements = [];
    let cartasCount = document.querySelectorAll('[cartavirada]').length
    if (cartasCount > 0) {
        for (i = 0; i < cartasCount; i++) {
            elements.push(document.querySelectorAll('[cartavirada]')[0].parentElement)
            document.querySelectorAll('[cartavirada]')[0].parentElement.remove()
        }
        for (i = 0; i < cartasCount; i++) {
            box_cartas_brancas_leitor.append(elements.splice((elements.length * Math.random()) >> 0, 1)[0])
            box_cartas_brancas_leitor.children[i].children[0].attributes.removeNamedItem('cartavirada')
        }
    }
}
