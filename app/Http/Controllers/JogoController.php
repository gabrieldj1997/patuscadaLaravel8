<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jogo;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CartasBrancas;
use App\Models\CartasPretas;
use App\Models\JogadorCartas;
use App\Models\Rodada;
use App\Events\MessageJogo;
use App\Events\JogadasJogo;
// use App\Events\CartasJogo;

class JogoController extends Controller
{
    public function Partida($id)
    {
        $jogo = Jogo::find($id);
        $jogadores = JogadorCartas::where('id_jogo', $id)->get();
        $rodada = Rodada::where('id_jogo', $id)->get()->first();
        return view('jogo.partida', ['jogo' => $jogo, 'jogadores' => $jogadores, 'rodada' => $rodada]);
    }

    public function CreatePartida(Request $req)
    {
        $jogo = new Jogo();
        $jogo->codigo = $req->input('codigo_jogo');
        $jogo->id_jogador_criador = Auth::user()->id;

        $cartas_brancas = CartasBrancas::all('id');
        $cartas_brancas = json_decode($cartas_brancas->map(function ($item) {
            return $item->id;
        })->toJson());
        $jogo->cartas_brancas_monte = json_encode($cartas_brancas);

        $cartas_pretas = CartasPretas::all('id');
        $cartas_pretas = json_decode($cartas_pretas->map(function ($item) {
            return $item->id;
        })->toJson());
        $jogo->cartas_pretas_monte = json_encode($cartas_pretas);
        $jogo->cartas_pretas_jogo = json_encode(array());

        $jogo->save();

        $rodada = new Rodada();
        $rodada->id_jogo = $jogo->id;
        $rodada->codigo_jogo = $jogo->codigo;
        $rodada->rodada_atual = 0;
        $rodada->id_estado_rodada = 0;
        $rodada->cartas_brancas_escolhidas = json_encode(array());
        $rodada->leitor_trocou_cartas = false;
        $rodada->save();

        return redirect()->route('jogo.partida', [$jogo->id, 'jogo' => $jogo]);
    }

    public function StartPartida(Request $req)
    {
        $jogo = Jogo::find($req->input('id_jogo'));
        
        // event(
        //     new MessageJogo($jogo->id, ['tp_message' => [1, 1], 'message' => 'Iniciando partida...'])
        // );

        if ($req->input('id_user') != $jogo->id_jogador_criador) {
            return json_encode(["error" => "Você não é o host do jogo"]);
        }
        $jogo->estado_jogo = 1;

        $jogadores = $req->input('jogadores');
        foreach ($jogadores as $jogador) {
            $jogador_carta = new JogadorCartas();
            $jogador_carta->id_jogo = $jogo->id;
            $jogador_carta->id_jogador = $jogador;
            $jogador_carta->cartas = json_encode(array());
            $jogador_carta->pontuacao = json_encode(array());
            $jogador_carta->save();
        }
        $jogo->save();

        $jogador_leitor = JogadorCartas::where('id_jogo', $jogo->id)->get()->first();

        $rodada = Rodada::where('id_jogo', $jogo->id)->get()->first();
        $rodada->rodada_atual = 1;
        $rodada->id_estado_rodada = 1;
        $rodada->cartas_brancas_escolhidas = json_encode(array());
        $rodada->id_leitor = $jogador_leitor->id_jogador;
        $rodada->leitor_trocou_cartas = false;
        $rodada->save();

        // event(
        //     new MessageJogo($jogo->id, ['tp_message' => [1, 2], 'message' => 'Partida iniciada'])
        // );

        $this->ProximaRodada($req);
    }

    public function DistribuirCartas($jogo)
    {
        // event(
        //     new MessageJogo($jogo->id, ['tp_message' => [2, 1], 'message' => 'Distribuindo cartas...'])

        // );
        $jogadores = JogadorCartas::where('id_jogo', $jogo->id)->get();
        $cartas_brancas_monte = json_decode($jogo->cartas_brancas_monte);

        foreach ($jogadores as $jogador) {
            $jogador_cartas = json_decode($jogador->cartas);
            for ($i = count($jogador_cartas); $i < 5; $i++) {
                $carta_branca_do_monte = array_splice($cartas_brancas_monte, rand(0, count($cartas_brancas_monte) - 1), 1);
                array_push($jogador_cartas, $carta_branca_do_monte[0]);
            }
            $jogador->cartas = json_encode($jogador_cartas);
            $jogador->save();
        };

        $jogo->cartas_brancas_monte = json_encode($cartas_brancas_monte);

        $cartas_pretas_monte = json_decode($jogo->cartas_pretas_monte);
        $cartas_pretas_jogo = array();

        for ($i = count($cartas_pretas_jogo); $i < (3 < count($cartas_pretas_monte) ? 3 : count($cartas_pretas_monte)); $i++) {
            $carta = array_splice($cartas_pretas_monte, rand(0, count($cartas_pretas_monte) - 1), 1);
            array_push($cartas_pretas_jogo, $carta[0]);
        }

        $jogo->cartas_pretas_jogo = json_encode($cartas_pretas_jogo);

        // for ($i = 0; $i < count($jogadores); $i++) {
        //     event(
        //         new CartasJogo($jogo->id,$jogadores[$i]->jogador, $jogadores[$i]->cartas_brancas)
        //     );
        // }

        $jogo->save();

        event(
            new MessageJogo($jogo->id, ['tp_message' => [2, 2], 'message' => 'Cartas distribuidas'])
        );
    }

    public function FinalizarRodada(Request $req)
    {
        $jogo = Jogo::find($req->input('id_jogo'));
        if ($req->input('my_id') != $jogo->id_jogador_criador) {
            return json_encode(["error" => "Você não é o host do jogo"]);
        }
        // event(
        //     new MessageJogo($jogo->id, ['tp_message' => [3, 3], 'message' => 'Finalizando rodada...'])

        // );
        $jogadores = JogadorCartas::where('id_jogo', $jogo->id)->get();
        $rodada = Rodada::where('id_jogo', $jogo->id)->get()->first();
        $cartas_brancas_descartadas = json_decode($rodada->cartas_brancas_escolhidas);
        if($rodada->leitor_trocou_cartas == true){
            $indJogador = array_search($rodada->id_leitor, array_column(json_decode($jogadores), 'id_jogador'));
            array_push($cartas_brancas_descartadas, (Object)["id_jogador"=>$rodada->id_leitor, "carta_branca"=>json_decode($jogadores[$indJogador]->cartas)]);
        }

        $jogador_ganhador = $rodada->jogador_vencedor;
        $carta_preta_descartada = $rodada->carta_preta_escolhida;
        $carta_branca_ganhadora = $rodada->carta_branca_vencedora;
        $cartas_pretas_monte = json_decode($jogo->cartas_pretas_monte);

        //pontuando jogador ganhador
        $indexJogador = array_search($jogador_ganhador, array_column(json_decode($jogadores), 'id_jogador'));
        $jogador_vencedor = $jogadores[$indexJogador];
        $pontuacao = json_decode($jogador_vencedor->pontuacao);
        array_push($pontuacao, array($carta_branca_ganhadora, $carta_preta_descartada));
        $jogador_vencedor->pontuacao = json_encode($pontuacao);
        $jogador_vencedor->save();
        $jogadores[$indexJogador] = $jogador_vencedor;

        $count_cartas_descartadas = 0;
        foreach ($cartas_brancas_descartadas as $cartas_descartadas) {
            $count_cartas_descartadas += count($cartas_descartadas->carta_branca);
        }

        if (
            count(json_decode($jogo->cartas_brancas_monte)) < count($jogadores)
            || (count(json_decode($jogo->cartas_pretas_monte)) + count(json_decode($jogo->cartas_pretas_jogo))) == 0
            || count(json_decode($jogo->cartas_brancas_monte)) < $count_cartas_descartadas
        ) {
            $this->FinalizarPartida($jogo->id);
            $jogador_vencedor = ["id_jogador" => 0, "pontuacao" => 0];
            foreach ($jogadores as $jogador) {
                if (count(json_decode($jogador->pontuacao)) > $jogador_vencedor['pontuacao']) {
                    $jogador_vencedor = ["id_jogador" => $jogador->id_jogador, "pontuacao" => count(json_decode($jogador->pontuacao))];
                }
            }
            event(
                new MessageJogo($jogo->id, ['tp_message' => [1, 3], 'message' => 'Jogador vencedor: ' . User::find($jogador_vencedor["id_jogador"])->nickname . '. Pontuacao: ' . $jogador_vencedor["pontuacao"]])
            );
            return json_encode(["message" => "Partida finalizada", "jogador_vencedor" => $jogador_vencedor["id_jogador"]]);
        }
        //retirando da mão dos jogadores a carta que foi jogada
        foreach ($cartas_brancas_descartadas as $cartas_descartadas) {
            $id_jogador = $cartas_descartadas->id_jogador;
            foreach ($cartas_descartadas->carta_branca as $carta) {
                $indJogador = array_search($id_jogador, array_column(json_decode($jogadores), 'id_jogador'));
                $indCarta = array_search($carta, json_decode($jogadores[$indJogador]->cartas));
                $array_cartas = json_decode($jogadores[$indJogador]->cartas);
                array_splice($array_cartas, $indCarta, 1);
                $jogadores[$indJogador]->cartas = json_encode($array_cartas);
                $jogadores[$indJogador]->save();
            }
        }



        //retirando do jogo a carta preta descartada
        array_splice($cartas_pretas_monte, array_search($carta_preta_descartada, $cartas_pretas_monte), 1);
        $jogo->cartas_pretas_monte = json_encode($cartas_pretas_monte);
        $jogo->cartas_pretas_jogo = json_encode(array());
        $jogo->save();

        $rodada = Rodada::where('id_jogo', $jogo->id)->first();
        $rodada->rodada_atual = $rodada->rodada_atual + 1;
        $rodada->id_estado_rodada = 1;
        $rodada->carta_preta_escolhida = null;
        $rodada->cartas_brancas_escolhidas = json_encode(array());
        $rodada->jogador_vencedor = null;
        $rodada->carta_branca_vencedora = null;
        $rodada->id_leitor = $jogadores[($rodada->rodada_atual - 1) % count($jogadores)]->id_jogador;
        $rodada->leitor_trocou_cartas = false;
        $rodada->save();

        // event(
        //     new MessageJogo($jogo->id, ['tp_message' => [3, 4], 'message' => 'Rodada Finalizada'])
        // );
        $this->ProximaRodada($req);
    }

    public function ProximaRodada(Request $req)
    {
        $jogo = Jogo::find($req->input('id_jogo'));

        // event(
        //     new MessageJogo($jogo->id, ['tp_message' => [3, 1], 'message' => 'Iniciando proxima rodada'])
        // );
        $jogo->rodada_jogo++;
        $jogo->save();

        // event(
        //     new MessageJogo($jogo->id, ['tp_message' => [3, 2], 'message' => 'Rodada iniciada', 'jogador_leitor' => $jogadores[$jogo->rodada_jogo % count($jogadores)]->id_jogador])
        // );

        $this->DistribuirCartas($jogo);
    }

    public function FinalizarPartida($id)
    {
        $jogo = Jogo::find($id);

        if(Auth::user()->id != $jogo->id_jogador_criador)
            return redirect()->route('jogo.partida', ["id" => $id, "error" => "Você não é o criador do jogo"]);
        
        $jogo->estado_jogo = 2;
        $jogo->save();
        return redirect()->route('jogo.partida', $id);
    }

    public function FindPartida(Request $req)
    {
        $jogo = Jogo::where('codigo', $req->input('codigo'))->first();
        if ($jogo == null) {
            return redirect()->route('index')->with(["error" => "Jogo não encontrado"]);
        }
        return redirect()->route('jogo.partida', ["id" => $jogo->id]);
    }

    public function ChooseCartaPreta(Request $req, $jogoId)
    {
        $carta_preta = CartasPretas::find($req->input('id_carta_preta'));
        $rodada = Rodada::where('id_jogo', $jogoId)->first();
        $rodada->carta_preta_escolhida = $req->input('id_carta_preta');
        $rodada->id_estado_rodada = 2;
        $rodada->save();
        event(
            new JogadasJogo(
                $jogoId,
                $req->input('my_id'),
                1,
                $carta_preta
            )
        );
    }

    public function ChooseCartaBranca(Request $req, $jogoId)
    {
        $carta_branca = CartasBrancas::find($req->input('id_carta_branca'));
        $jogadores = JogadorCartas::where('id_jogo', $jogoId)->get('id_jogador');
        $rodada = Rodada::where('id_jogo', $jogoId)->first();
        $cartas_brancas_escolhidas = json_decode($rodada->cartas_brancas_escolhidas);
        $ind_jogador = array_search($req->input('my_id'), array_column($cartas_brancas_escolhidas, 'id_jogador'));
        if (!$ind_jogador) {
            array_push($cartas_brancas_escolhidas, ["id_jogador" => json_decode($req->input('my_id')), "carta_branca" => array($carta_branca->id)]);
        }
        if (count($cartas_brancas_escolhidas) == count(json_decode($jogadores)) - 1) {
            $rodada->id_estado_rodada = 3;
        }
        $rodada->cartas_brancas_escolhidas = json_encode($cartas_brancas_escolhidas);
        $rodada->save();
        event(
            new JogadasJogo(
                $jogoId,
                $req->input('my_id'),
                2,
                $carta_branca
            )
        );
    }

    public function ChooseJogadorVencedor(Request $req, $jogoId)
    {
        $carta_branca = CartasBrancas::find($req->input('id_carta_branca'));
        $rodada = Rodada::where('id_jogo', $jogoId)->first();
        $rodada->jogador_vencedor = $req->input('id_jogador_ganhador');
        $rodada->carta_branca_vencedora = $carta_branca->id;
        $rodada->id_estado_rodada = 4;
        $rodada->save();
        event(
            new JogadasJogo(
                $jogoId,
                $req->input('my_id'),
                3,
                ["id_jogador" => $req->input('id_jogador_ganhador'), "id_carta_preta" => $rodada->carta_preta_escolhida, "id_carta_branca" => $carta_branca->id]
            )
        );
    }

    public function ChangeCartasBrancas(Request $req, $jogoId)
    {

        $jogador_carta = JogadorCartas::where('id_jogador', $req->input('my_id'))->where('id_jogo', $jogoId)->first();
        $rodada = Rodada::where('id_jogo', $jogoId)->first();
        if($rodada->id_estado_rodada == 1){
            $rodada->leitor_trocou_cartas = true;
            $rodada->save();
        }
        event(
            new JogadasJogo(
                $jogoId,
                $req->input('my_id'),
                4,
                json_decode($jogador_carta->cartas)
            )
        );
    }

    public function TesteJogadores(Request $req, $id)
    {
        $jogo = Jogo::find($id);
        $jogadores = JogadorCartas::where('id_jogo', $jogo->id)->get();
        $cartas_brancas_monte = json_decode($jogo->cartas_brancas_monte);
        foreach ($jogadores as $jogador) {
            $jogador_cartas = json_decode($jogador->cartas);
            for ($i = count($jogador_cartas); $i < 5; $i++) {
                $carta_branca_do_monte = array_splice($cartas_brancas_monte, rand(0, count($cartas_brancas_monte) - 1), 1);
                array_push($jogador_cartas, $carta_branca_do_monte[0]);
            }
            $jogador->cartas = json_encode($jogador_cartas);
            $jogador->save();
        };
        return $jogadores;
    }

    public function DeletePartida(Request $req){

        $jogo = Jogo::find($req->input('id_jogo'));

        if($req->input('my_id') != $jogo->id_jogador_criador){
            return ["codigo" => 0, "error" => "Você não tem permissão para deletar essa partida!"];
        }

        if($jogo->estado_jogo != 0)
            return ["codigo" => 0, "error" => "Você não pode deletar uma partida que já começou/finalizou!"];

        $jogo->delete();

        return ["codigo" => 1, "success" => "Partida deletada com sucesso"];
    }
}
