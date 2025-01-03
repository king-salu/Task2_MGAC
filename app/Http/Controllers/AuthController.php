<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use App\Models\User;
use App\Models\wallet;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;
use Laravel\Passport\Token;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="registerUser",
     *      tags={"Registration"},
     *      summary="Create a user",
     *      description="Returns Created User data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","email","password"},
     *              @OA\Property(property="name", type="string", format="string", example="King Salu"),
     *              @OA\Property(property="email", type="string", format="email", example="kingsalu@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="King Salu"),
     *              @OA\Property(property="email", type="string", example="kingsalu@example.com"),
     *              @OA\Property(property="updated_at", type="string", format="datetime", example="2025-01-02T21:47:26.000000Z"),
     *              @OA\Property(property="created_at", type="string", format="datetime", example="2025-01-02T21:47:26.000000Z"),
     *          )
     *      ),
     * )
     */
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();
        return $user->toJson();
    }

    /**
     * @OA\Post(
     *      path="/api/validate",
     *      operationId="validateToken",
     *      tags={"Authentication"},
     *      summary="Token validation.",
     *      description="Returns validation and User data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Token is valid"),
     *              @OA\Property(property="user", type="object", example={"id": 1, "name": "King Salu", "email":"kingsalu@exacmple.com","email_verified_at":null,"created_at":"2025-01-01T18:05:07.000000Z","updated_at":"2025-01-01T18:05:07.000000Z"}),
     *          ),
     *      ),
     *      @OA\Response(response=400, description="Token not provided"),
     *      @OA\Response(response=401, description="Invalid user"),
     *      @OA\Response(response=401, description="Invalid token")
     * )
     */
    public function validateToken(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Token not provided'], 400);
        }
        $publicKey = file_get_contents(storage_path('oauth/oauth-public.key'));
        try {
            $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));
            $user = Auth::guard('api')->user();
            if (!$user) {
                return response()->json(['message' => 'Invalid user'], 401);
            }
            return response()->json(['message' => 'Token is valid', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        }
    }
}
