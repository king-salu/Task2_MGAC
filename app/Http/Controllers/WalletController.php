<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($user_id)
    {
        $wallet = new wallet(['user_id' => $user_id, 'balance' => 20000, 'status' => true]);
        $wallet->save();

        return $wallet;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/api/wallet/balance",
     *      operationId="walletBalance",
     *      tags={"Wallet"},
     *      summary="Fetch user balance",
     *      description="Returns wallet information data from logged in user",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="user_id", type="integer", example="1"),
     *              @OA\Property(property="status", type="boolean", example="1"),
     *              @OA\Property(property="balance", type="float", example="20000"),
     *              @OA\Property(property="created_at", type="string", example="2025-01-02T21:47:26.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2025-01-02T21:47:26.000000Z"),
     *          ),
     *      )
     * )
     */
    public function show(Request $request)
    {
        //
        $user = $request->user();
        if ($user) {
            $iwallet = $user->wallet();

            return response()->json($iwallet);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(wallet $wallet)
    {
        //
    }


    /**
     * @OA\Post(
     *      path="/api/wallet/transfer",
     *      operationId="transfer",
     *      tags={"Wallet"},
     *      summary="Simulate wallet transfer",
     *      description="Returns message showing transfer successful",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"amount","to"},
     *              @OA\Property(property="amount", type="float", format="float", example="10000"),
     *              @OA\Property(property="to", type="string", format="email", example="kingsalu@example.com"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Transfer Successful"),
     *          )
     *      ),
     *     @OA\Response(response=400, description="Insufficient Funds"),
     *     @OA\Response(response=400, description="Transfereable amount must be greater than zero"),
     *     @OA\Response(response=404, description="Beneficiary Not Found"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */

    public function transfer(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user_wallet = $user->wallet();
            $_to = $request->to ?? null;
            $_amount = $request->amount ?? 0;
            if (empty($_to)) return response()->json(['message' => "Specify who's wallet email do you want to transfer to"], 400);
            $benef = User::where('email', $_to)->first();
            if (empty($benef)) return response()->json(['message' => "Beneficiary Not Found"], 404);
            if (($_amount < 0) || (empty($_amount)))
                return response()->json(['message' => "Transfereable amount must be greater than zero"], 400);

            if ($user_wallet->balance < $_amount) return response()->json(['message' => 'Insufficient Funds'], 400);

            $user_wallet->debit($_amount);
            $benef->wallet()->credit($_amount);

            return response()->json(['message' => 'Transfer Successful']);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
