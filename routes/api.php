<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\ApproveAuthorizationController;
use Laravel\Passport\Http\Controllers\DenyAuthorizationController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\ScopeController;

// Route::post('/oauth/token', [AccessTokenController::class, 'issueToken']);
Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])->middleware('auth:api');
Route::get('/oauth/authorize', [AuthorizationController::class, 'authorize']);
Route::post('/oauth/authorize', [ApproveAuthorizationController::class, 'approve']);
Route::delete('/oauth/authorize', [DenyAuthorizationController::class, 'deny']);
Route::post('/oauth/token/refresh', [TransientTokenController::class, 'refresh'])->middleware('auth:api');
Route::get('/oauth/clients', [ClientController::class, 'forUser']);
Route::post('/oauth/clients', [ClientController::class, 'store']);
Route::put('/oauth/clients/{client_id}', [ClientController::class, 'update']);
Route::delete('/oauth/clients/{client_id}', [ClientController::class, 'destroy']);
Route::get('/oauth/scopes', [ScopeController::class, 'all']);
Route::get('/oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'forUser']);
Route::post('/oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'store']);
Route::delete('/oauth/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy']);


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AccessTokenController::class, 'issueToken'])->middleware('populate.tokenReq')->name('login');
Route::middleware(['web'])->group(function () {
    Route::post('/refresh', [TransientTokenController::class, 'refresh'])->middleware(['auth:api', 'populate.refreshtokenreq']);
});
Route::middleware('auth:api')->group(function () {
    Route::get('/wallet/balance', [WalletController::class, 'show']);
    Route::post('/wallet/transfer', [WalletController::class, 'transfer']);

    Route::post('/validate', [AuthController::class, 'validateToken']);

    Route::post('/order/initiate', [OrderController::class, 'create']);
    Route::get('/order/status', [OrderController::class, 'status']);
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
