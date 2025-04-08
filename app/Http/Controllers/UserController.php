<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     summary="Obter usuário por ID",
 *     description="Retorna os dados de um usuário específico pelo seu ID.",
 *     operationId="getUserById",
 *     tags={"Usuários"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do usuário",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário encontrado com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Gabriel"),
 *             @OA\Property(property="email", type="string", example="gabriel@email.com"),
 *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuário não encontrado"
 *     )
 * )
 */
class UserController extends Controller
{
    public function GetUser($id){
        $user = User::find($id);
        return $user;
    }
}
