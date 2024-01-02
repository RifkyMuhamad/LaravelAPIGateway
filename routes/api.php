<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Simple;
use App\Http\Controllers\UserController;

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
    $fakeData = [
        'id' => 1,
        'name' => "DyoneStrankers",
        'email' => "dyone@dyone.com"
    ];

    return response() -> json($fakeData);
});

Route::get('/dyone', function () {
    $fakeData = [
        'id' => "dyonese",
        'name' => "Dyonese",
        'email' => "dyonese@dyone.com"
    ];

    return response() -> json($fakeData);
});

// Route::post('/users', [UserController::class, 'register']);
