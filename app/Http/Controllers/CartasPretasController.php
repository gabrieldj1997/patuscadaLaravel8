<?php

namespace App\Http\Controllers;

use App\Models\CartasPretas;
use App\Http\Requests\CartasPretasRequest;
use Illuminate\Http\Request;

class CartasPretasController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/cartaspretas",
 *     summary="Listar todas as cartas pretas",
 *     tags={"Cartas Pretas"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de cartas pretas",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="texto", type="string", example="__________ é tudo que preciso."),
 *                 @OA\Property(property="created_at", type="string", format="date-time"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time")
 *             )
 *         )
 *     )
 * )
 */

    public function GetCartasPretas(){
        $cartasBrancas = CartasPretas::all();
        return $cartasBrancas;
    }
    /**
 * @OA\Get(
 *     path="/api/cartaspretas/{id}",
 *     summary="Obter uma carta preta por ID",
 *     tags={"Cartas Pretas"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID da carta preta",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Carta preta encontrada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="texto", type="string", example="__________ é tudo que preciso."),
 *             @OA\Property(property="created_at", type="string", format="date-time"),
 *             @OA\Property(property="updated_at", type="string", format="date-time")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Carta preta não encontrada"
 *     )
 * )
 */

    public function GetCartaPreta($id){
        $CartaPreta = CartasPretas::find($id);
        return $CartaPreta;
    }
    /**
 * @OA\Post(
 *     path="/api/cartaspretas",
 *     summary="Cadastrar nova carta preta",
 *     tags={"Cartas Pretas"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"texto"},
 *             @OA\Property(property="texto", type="string", example="__________ é tudo que preciso.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Carta preta criada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="texto", type="string", example="__________ é tudo que preciso."),
 *             @OA\Property(property="created_at", type="string", format="date-time"),
 *             @OA\Property(property="updated_at", type="string", format="date-time")
 *         )
 *     )
 * )
 */

    public function RegisterCartaPreta(CartasPretasRequest $req){
        $CartaPreta = new CartasPretas();
        $CartaPreta->texto = $req->texto;
        $CartaPreta->save();
        return $CartaPreta;
    }
    /**
 * @OA\Delete(
 *     path="/api/cartaspretas/{id}",
 *     summary="Deletar uma carta preta",
 *     tags={"Cartas Pretas"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID da carta preta a ser deletada",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Carta preta deletada com sucesso"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Carta preta não encontrada"
 *     )
 * )
 */

    public function DeleteCartaPreta($id){
        $CartaPreta = CartasPretas::find($id);
        $CartaPreta->delete();
        return $CartaPreta;
    }
    /**
 * @OA\Put(
 *     path="/api/cartaspretas/{id}",
 *     summary="Atualizar uma carta preta",
 *     tags={"Cartas Pretas"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID da carta preta a ser atualizada",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"texto"},
 *             @OA\Property(property="texto", type="string", example="Texto atualizado da carta preta.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Carta preta atualizada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="texto", type="string", example="Texto atualizado da carta preta."),
 *             @OA\Property(property="created_at", type="string", format="date-time"),
 *             @OA\Property(property="updated_at", type="string", format="date-time")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Carta preta não encontrada"
 *     )
 * )
 */

    public function AlterCartaPreta(Request $req, $id){
        $cartaPreta = CartasPretas::find($id);
        $cartaPreta->texto = $req->texto;
        $cartaPreta->save();
        return $cartaPreta;
    }
}
