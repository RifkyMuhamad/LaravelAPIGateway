<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegisterRequest $req):UserResource
    {
        $data = $req->validate();

        // apakah username dari req sudah ada di database?
        if (User::where('username', $data['username'])->count() == 1)
        {
            // jika blok dieksekusi berati ada data di database
            throw new HttpResponseException(response([
                "errors" => [
                    "username" => [
                        "Username Already Registered"
                    ]
                ]
            ], 400));
        }

        $user = new User($data);
        
        // password akan di-hashing dahulu baru disimpan ke database
        $user->password = Hash::make($data['password']);
        $user->save();

        return new UserResource($user);
    }
}
