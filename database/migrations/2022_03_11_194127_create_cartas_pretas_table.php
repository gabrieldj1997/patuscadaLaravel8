<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_cartas_pretas', function (Blueprint $table) {
            $table->id();
            $table->string('texto');
            $table->integer('id_pack')->default(1);
            $table->integer('pontos')->default(0);
            $table->timestamps();
        });

        DB::table('tb_cartas_pretas')->insert([
            ['texto' => '___ ? Tem um aplicativo para isso.'],
            ['texto' => 'Por que não consigo dormir à noite?'],
            ['texto' => 'Que cheiro é esse?'],
            ['texto' => 'Eu tenho 99 problemas mas ___ não é um.'],
            ['texto' => 'Quem roubou biscoitos do pote de biscoitos?'],
            ['texto' => 'Qual o  próximo brinde do McLanche Feliz?'],
            ['texto' => 'Antropólogos recentemente descobriram uma antiga tribo que venerava ___'],
            ['texto' => 'É uma pena que crianças hoje em dia estejam todas se envolvendo com ___'],
            ['texto' => 'Durante o Período Marrom de Picasso ele pintou centenas de quadros de  ___'],
            ['texto' => 'A medicina alternativa está adotando os poderes curativos de ___'],
            ['texto' => 'Passarinho, que som é esse?'],
            ['texto' => 'O que fez meu último relacionamento acabar?'],
            ['texto' => 'A nova temporada de A Fazenda apresenta 17 celebridades falidas convivendo com ___'],
            ['texto' => 'Eu bebo para esquecer ___'],
            ['texto' => 'Desculpe, professor, não consegui terminar minha tarefa de casa por causa de___'],
            ['texto' => 'Qual o prazer secreto do Batman?'],
            ['texto' => 'É assim que o mundo acaba: não com uma explosão, mas com ___'],
            ['texto' => 'Qual o melhor amigo das garotas?'],
            ['texto' => 'As novas regras de seguranca agora proíbem ___ em aviões.'],
            ['texto' => '___. É assim que eu morro.'],
            ['texto' => 'Para meu próximo truque, eu  vou tirar da minha cartola ___'],
            ['texto' => 'No novo filme da Xuxa, ela precisa lidar com  ___  pela primeira vez'],
            ['texto' => '___‚ uma porta de entrada para vicios'],
            ['texto' => 'O que Aécio Neves prefere?'],
            ['texto' => 'Queria não ter perdido o manual de ___.'],
            ['texto' => 'Ao invés de carvão, agora o Papai Noel dá ___ para crianças mal comportadas.'],
            ['texto' => 'O que é o mais emo?'],
            ['texto' => 'Em 1000 anos, quando dinheiro impresso for uma memória distante, ___ vai ser a moeda de troca.'],
            ['texto' => 'Qual a próxima dupla de super-herói/ajudante? (2)'],
            ['texto' => 'Um jantar romântico à luz de velas estaria incompleto sem ___.'],
            ['texto' => '____ . Aposto que você não consegue ficar sem repetir!'],
            ['texto' => 'Gente branca gosta de  ___.'],
            ['texto' => '____. Toca aqui, mano!'],
            ['texto' => 'O próximo livro de  J.K Rowling : Harry Potter e ___.'],
            ['texto' => 'A TOPTHERM TRAZ PRA VOCÊ O LEGÍTIMO ___.'],
            ['texto' => 'Num pós apocalipse, nosso único consolo é ___.'],
            ['texto' => 'Guerra! Para que serve?'],
            ['texto' => 'Durante o sexo eu gosto de pensar em ___.'],
            ['texto' => 'O que os meus pais escondem de mim?'],
            ['texto' => 'O que sempre fará você conseguir uma transa?'],
            ['texto' => 'Quando eu estiver na prisão, eu vou  contrabandear  ___ .'],
            ['texto' => 'O que eu trouxe do Paraguai?'],
            ['texto' => 'O que você não gostaria de encontrar na sua comida chinesa ?'],
            ['texto' => 'O que eu vou trazer do passado para provar que sou um feiticeiro poderoso ?'],
            ['texto' => 'Como estou mantendo meu status de relacionamento ?'],
            ['texto' => '____. É uma cilada, Bino!'],
            ['texto' => 'Nos teatros mais próximos, ___: O musical.'],
            ['texto' => 'Enquanto os EUA e a URSS faziam a corrida espacial, o governo brasileiro gastou milhões de reais pesquisando ___'],
            ['texto' => 'Após os desastres de Mariana, Claudia Raia comprou ___ para o povo mineiro.'],
            ['texto' => 'Depois de um fiasco no setor de relacoes publicas, o Carrefour nao oferta mais ___'],
            ['texto' => 'Em sua ferias de verão vou te apresentar ___.'],
            ['texto' => 'Os rumores dizem que o prato predileto de Dilma Rousseff é cheio de ___.'],
            ['texto' => 'Mas antes de matá-lo, Sr. Bond, preciso te mostrar ___ '],
            ['texto' => 'O que me dá gases incontroláveis?'],
            ['texto' => 'Como as pessoas idosas cheiram?'],
            ['texto' => 'A viagem de campo foi arruinada por ___'],
            ['texto' => 'Quando o Faraó estava imóvel, Moisés chamou pela Praga de ___'],
            ['texto' => 'Qual o meu poder secreto ?'],
            ['texto' => 'O que tem em toneladas no paraíso ?'],
            ['texto' => 'O que a vovó acharia perturbador, porém estranhamente encantador ?'],
            ['texto' => 'Eu nunca entendi verdadeiramente a vida até encontrar ___'],
            ['texto' => 'A Polícia Militar comecou a enviar ___ para as crianças em Mãe Luiza.'],
            ['texto' => 'O que ajuda o Temer a relaxar ?'],
            ['texto' => 'O que o Leo Stronda comeu no jantar ?'],
            ['texto' => '___ : Bom até a última gota.'],
            ['texto' => 'Por que eu estou preguento ?'],
            ['texto' => 'O que fica melhor com a idade ?'],
            ['texto' => '____ : Testado por crianças, aprovado pelas mães.'],
            ['texto' => 'O que é o mais idiota ?'],
            ['texto' => 'O que o Prouni esta usando para incentivar estudantes do interior a tentar a universidade ?'],
            ['texto' => 'Estudos mostram que ratos de laboratório atravessam labirintos 50% mais rápido depois de expostos a ___'],
            ['texto' => 'A vida era difícil para os homens das cavernas antes de ___'],
            ['texto' => 'Um mundo perfeito seria um mundo com muita ___!'],
            ['texto' => 'Eu não sei que armas vao usar na terceira guerra mundial, mas na quarta usarão ___ '],
            ['texto' => 'Por que eu estou todo dolorido ?'],
            ['texto' => 'O que eu estou emprestando ?'],
            ['texto' => 'Nos ultimos momentos de Raul Seixas, ele pensou sobre ___'],
            ['texto' => 'Numa tentativa de obter maior audiência, o Museu Câmara Cascudo oferecerá uma exibição interativa de  ___'],
            ['texto' => 'Quando eu for presidente da república, vou criar o ministério de ___'],
            ['texto' => 'A sessão da tarde apresenta: ___, uma história de sucesso!'],
            ['texto' => 'Quando eu for um bilionário, vou erguer uma estátua de 20 metros em homenagem a ___'],
            ['texto' => 'Quando eu estava viajando com LSD, vi ____ inumeras vezes.'],
            ['texto' => 'Verdade, eu matei meu amigo. Como? ____'],
            ['texto' => 'Qual o meu anti-drogas ?'],
            ['texto' => 'O que nunca falha em animar a festa ?'],
            ['texto' => 'Qual a nova dieta do momento ?'],
            ['texto' => 'A FIFA baniu ___ por dar aos jogadores uma enorme vantagem'],
            ['texto' => 'Como eu perdi minha virgindade ?'],
            ['texto' => 'Talvez ela tenha nascido assim, talvez seja ___'],
            ['texto' => 'Eu consigo seguir em frente com uma pequena ajuda de ___ '],
            ['texto' => 'Querida tia Tereza, estou tendo um problema com ___ e gostaria da sua ajuda.'],
            ['texto' => 'Mais uma noite chega, e com ela ___'],
            ['texto' => 'Disseram que nós éramos loucos, disseram que não poderíamos criar ___. Eles estavam errados. '],
            ['texto' => 'Papai, por que a mamãe está chorando?'],
            ['texto' => 'Aqui também é ___'],
            ['texto' => 'Olha como ela é ___, dá pra ela !'],
            ['texto' => 'O próximo quadrao no show da xuxa será ___'],
            ['texto' => 'Ninguém espera a revolução comunista, nossas principais armas são medo, surpresa e ___ '],
            ['texto' => 'A TAM pede desculpas pelo atraso dos voos devido a ___'],
            ['texto' => 'A seguir, em Esporte Espetacular, o Campeonato Mundial de ___'],
            ['texto' => 'Hoje, em Casos de Família: Socorro! Meu filho é ___ !'],
            ['texto' => 'A vida dos povos indígenas no Brasil mudou para sempre quando o homem branco os introduziu a ___'],
            ['texto' => 'Quando o seu homem pedir para você fazer um oral, surpreenda-o com ___, no lugar'],
            ['texto' => 'Hoje, na Sessão da Tarde: ___.'],
            ['texto' => 'A história de ___ foi muito mais interessante que sessão da tarde'],
            ['texto' => '___. É por isso que as mães vão para o Acre'],
            ['texto' => 'Eu não acredito que cientistas inventaram ___'],
            ['texto' => 'A nova sensação do Funk é o Mc ___'],
            ['texto' => 'O Yudi girou a roleta do Bom Dia e Cia, e ao invés de vir um play station, veio ___'],
            ['texto' => 'Beijinho no ombro pra ___ passar longe'],
            ['texto' => 'Tu tá metida com ___, Morena?'],
            ['texto' => 'Após a Época do Café, o Brasil investiu na exportação de ___'],
            ['texto' => 'Casar, foder, matar.']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_cartas_pretas');
    }
};
