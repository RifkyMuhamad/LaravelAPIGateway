<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Simple;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return response()->json([
        "message" => "DyoneStrankers use Laravel",
        "documentation" => "https://github.com/RifkyMuhamad/LaravelAPIGateway"
    ], 200, [], JSON_UNESCAPED_SLASHES);
});

Route::get('/dyone', function () {

    $fakeData = [
        'id' => "dyonese",
        'name' => "Dyonese",
        'email' => "dyonese@dyone.com"
    ];

    return response()->json($fakeData);
});

Route::post('/users', [UserController::class, 'register']);
Route::post('/users/login', [UserController::class, 'login']);

Route::middleware(ApiAuthMiddleware::class)->group(function () {
    Route::get('/users/current', [UserController::class, 'get']);
    Route::patch('/users/current', [UserController::class, 'update']);
    Route::delete('/users/logout', [UserController::class, 'logout']);

    Route::post('/contacts', [ContactController::class, 'create']);
    Route::get('/contacts', [ContactController::class, 'search']);
    Route::get('/contacts/{id}', [ContactController::class, 'get'])->where('id', '[0-9]+');
    Route::put('/contacts/{id}', [ContactController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/contacts/{id}', [ContactController::class, 'delete'])->where('id', '[0-9]+');

    Route::post('/contacts/{idContact}/addresses', [AddressController::class, 'create'])->where('idContact', '[0-9]+');
    Route::get('/contacts/{idContact}/addresses', [AddressController::class, 'list'])->where('idContact', '[0-9]+');
    Route::get('/contacts/{idContact}/addresses/{idAddress}', [AddressController::class, 'get'])->where('idContact', '[0-9]+')->where('idAddress', '[0-9]+');
    Route::put('/contacts/{idContact}/addresses/{idAddress}', [AddressController::class, 'update'])->where('idContact', '[0-9]+')->where('idAddress', '[0-9]+');
    Route::delete('/contacts/{idContact}/addresses/{idAddress}', [AddressController::class, 'delete'])->where('idContact', '[0-9]+')->where('idAddress', '[0-9]+');
});
