<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $fakeData = [
        'id' => 1,
        'name' => "DyoneStrankers",
        'email' => "dyone@dyone.com"
    ];

    return response() -> json([
        "message" => "DyoneStrankers use Laravel"
    ]);
});
