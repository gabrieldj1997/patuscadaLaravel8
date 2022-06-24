Cards Against Humanity // Patuscada

Após baixar o projeto configure o arquivo '.env' pegando o '.env.example' de base
ao configurar o .env com a conexão ao banco de dados rode o comando:

php artisan migrate

Isso ira preencher o banco de dados automaticamente

Outra configuração importante é a do pusher, precisando primeraimente se cadastrar no site:
https://pusher.com/
Após cadastrado siga o passo a passo do site e depois da criação do seu aplicativo no pusher irá ser gerado as suas chaves
o site te da o passo a passo de como pegar as chaves e como configurar no .env do projeto.

Depois de tudo configurado vc poderá gerar as suas cartas brancas e pretas do jogo usando a api
A coleção da api para as cartas (get e post) esta no arquivo 'Patuscada.postman_collection.json' desse projeto

Função js aonde pode criar as cartas pelo axios criando 2 variaveis de array de string 'respostas' e 'perguntas'

var req = (url, texto,segundos)=>{
    return new Promise(
        (resolve,reject)=>{
            setTimeout(()=>{
                resolve((()=>{
                    option={
                        method:'POST',
                        url:url,
                        data:{
                            texto:texto
                        }
                    }
    				return axios(option)
                })(),(segundos == 1 ? 120000 : 3000))
            })
        }
    )
}
async function gerador(){
    for(i = 0; i < respostas.length; i++){
        console.log(`inserindo carta branca nº: ${i}`)
        try{
            let r = await req('http://localhost:8000/api/cartasbrancas', respostas[i], 0).then()
        }catch(e){
            let y = await req('http://localhost:8000/api/cartasbrancas', respostas[i], 1).then()
            await y.then()
        }
    }
    for(i = 0; i < perguntas.length; i++){
        console.log(`inserindo carta preta nº: ${i}`)
        try{
            let r = await req('http://localhost:8000/api/cartaspretas', perguntas[i], 0).then()
        }catch(e){
            let y = await req('http://localhost:8000/api/cartasbrancas', respostas[i], 1).then()
            await y.then()
        }
    }
}
gerador()