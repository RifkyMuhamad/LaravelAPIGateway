<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Simple extends Controller
{
    public function index()
    {
        $fakeData = [
            'id' => 1,
            'name' => "DyoneStrankers",
            'email' => "dyone@dyone.com"
        ];

        return response() -> json($fakeData);
    }
}
