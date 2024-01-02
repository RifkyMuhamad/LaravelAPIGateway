<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(UserRegisterRequest $req):JsonResponse
    {
        $data = $req->validated();

        // apakah username dari req sudah ada di database?
        if (User::where('username', $data['username'])->count() == 1)
        {
            // jika blok dieksekusi berati ada data di database
            throw new HttpResponseException(response([
                "errors" => [
                    "username" => [
                        "username already registered"
                    ]
                ]
            ], 400));
        }

        $user = new User($data);
        
        // password akan di-hashing dahulu baru disimpan ke database
        $user->password = Hash::make($data['password']);
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function login(UserLoginRequest $req):UserResource
    {
        $data = $req->validated();

        $user = User::where("username", $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password))
        {
            // jika blok dieksekusi berati ada data di database
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "username or password wrong"
                    ]
                ]
            ], 401));
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        return new UserResource($user);
    }

    public function get(Request $req): UserResource
    {
        $user = Auth::user();

        return new UserResource($user);
    }

    public function update(UserUpdateRequest $req): UserResource
    {
        $data = $req->validated();

        $user = Auth::user();

        if (isset($data["name"]))
        {
            $user->name = $data["name"];
        }

        if (isset($data["password"]))
        {
            $user->password = Hash::make($data["password"]);
        }

        $user->save();

        return new UserResource($user);
    }

    public function logout(Request $req):JsonResponse
    {
        $user = Auth::user();
        $user->token = null;

        $user->save();

        return response()->json([
            "data" => true
        ])->setStatusCode(200);
    }
}
