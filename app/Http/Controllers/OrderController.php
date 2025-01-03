<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/api/order/initiate",
     *      operationId="initiateOrder",
     *      tags={"Order"},
     *      summary="Start an order if balance permits.",
     *      description="Returns Created Order data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"item","price"},
     *              @OA\Property(property="item", type="string", format="string", example="Item 1"),
     *              @OA\Property(property="price", type="float", format="float", example="3000"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="success"),
     *              @OA\Property(property="data", type="object", example={"user_id": 1, "item": "item x", "price": 1000, "status": "success", "updated_at": "2025-01-03T08:10:47.000000Z", "created_at": "2025-01-03T08:10:47.000000Z"}),
     *          )
     *      ),
     *      @OA\Response(response=400, description="Insufficient Funds"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function create(Request $request)
    {
        //
        $user = $request->user();
        if ($user) {
            $state = true;
            $message = null;
            $o_status = 'success';
            $o_price = $request->price;
            $uwallet = $user->wallet();
            if ($o_price > $uwallet->balance) {
                $message = 'Insufficient Funds';
                $o_status = 'pending';
            }

            $order = new order();
            $order->user_id = $user->id;
            $order->item = $request->item;
            $order->price = $o_price;
            $order->status = $o_status;

            $order->save();
            if ($o_status == 'success') {
                $uwallet->debit($o_price);
            }

            return response()->json(['message' => ($message ?? $o_status), 'data' => $order], 400);
        } else return response()->json(['message' => 'Unauthorized'], 401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/api/order/status",
     *      operationId="orderStatus",
     *      tags={"Order"},
     *      summary="Retrieve order status.",
     *      description="Returns latest Order data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="user_id", type="integr", example="1"),
     *              @OA\Property(property="item", type="string", example="item x"),
     *              @OA\Property(property="price", type="float", example="1000"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="updated_at", type="string", example="2025-01-03T08:10:47.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2025-01-03T08:10:47.000000Z"),
     *          )
     *      ),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function status(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $iorder = order::where('user_id', $user->id)->orderBy('updated_at', 'desc')->first();
            return response()->json($iorder);
        } else return response()->json(['message' => 'Unauthorized'], 401);
    }
}
