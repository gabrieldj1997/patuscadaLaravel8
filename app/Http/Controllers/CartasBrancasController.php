<?php

namespace App\Http\Controllers;

use App\Models\CartasBrancas;
use App\Http\Requests\CartasBrancasRequest;
use Illuminate\Http\Request;

class CartasBrancasController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/cartasbrancas",
 *     summary="Listar todas as cartas brancas",
 *     tags={"Cartas Brancas"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de cartas brancas",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="texto", type="string", example="Uma resposta engraçada"),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     )
 * )
 */

    public function GetCartasBrancas(){
        $cartasBrancas = CartasBrancas::all();
        return $cartasBrancas;
    }
    /**
 * @OA\Get(
 *     path="/api/cartasbrancas/{id}",
 *     summary="Obter uma carta branca por ID",
 *     tags={"Cartas Brancas"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID da carta branca",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Carta branca encontrada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="texto", type="string", example="Uma resposta engraçada"),
 *             @OA\Property(property="created_at", type="string", format="date-time"),
 *             @OA\Property(property="updated_at", type="string", format="date-time")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Carta branca não encontrada"
 *     )
 * )
 */

    public function GetCartaBranca($id){
        $cartaBranca = CartasBrancas::find($id);
        return $cartaBranca;
    }
    /**
 * @OA\Post(
 *     path="/api/cartasbrancas",
 *     summary="Cadastrar nova carta branca",
 *     tags={"Cartas Brancas"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"texto"},
 *             @OA\Property(property="texto", type="string", example="Algo engraçado para jogar")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Carta branca criada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="texto", type="string", example="Algo engraçado para jogar"),
 *             @OA\Property(property="created_at", type="string", format="date-time"),
 *             @OA\Property(property="updated_at", type="string", format="date-time")
 *         )
 *     )
 * )
 */

    public function RegisterCartaBranca(CartasBrancasRequest $req){
        $cartaBranca = new CartasBrancas();
        $cartaBranca->texto = $req->texto;
        $cartaBranca->save();
        return $cartaBranca;
    }
    /**
 * @OA\Delete(
 *     path="/api/cartasbrancas/{id}",
 *     summary="Deletar uma carta branca",
 *     tags={"Cartas Brancas"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID da carta branca a ser deletada",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Carta branca deletada com sucesso"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Carta branca não encontrada"
 *     )
 * )
 */

    public function DeleteCartaBranca($id){
        $cartaBranca = CartasBrancas::find($id);
        $cartaBranca->delete();
        return $cartaBranca;
    }
    /**
 * @OA\Put(
 *     path="/api/cartasbrancas/{id}",
 *     summary="Atualizar uma carta branca",
 *     tags={"Cartas Brancas"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID da carta branca a ser atualizada",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"texto"},
 *             @OA\Property(property="texto", type="string", example="Texto atualizado da carta")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Carta branca atualizada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="texto", type="string", example="Texto atualizado da carta"),
 *             @OA\Property(property="created_at", type="string", format="date-time"),
 *             @OA\Property(property="updated_at", type="string", format="date-time")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Carta branca não encontrada"
 *     )
 * )
 */

    
    public function AlterCartaBranca(Request $req, $id){
        $cartaBranca = CartasBrancas::find($id);
        $cartaBranca->texto = $req->texto;
        $cartaBranca->save();
        return $cartaBranca;
    }
}
