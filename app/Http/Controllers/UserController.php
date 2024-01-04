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
    public function register(UserRegisterRequest $req): JsonResponse
    {
        $data = $req->validated();
        $registerValidate = User::where('username', $data['username'])->count() == 1;
        if ($registerValidate) {
            throw new HttpResponseException(DontUseController::errorsResponse(register: $registerValidate));
        }
        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();
        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function login(UserLoginRequest $req): UserResource
    {
        $data = $req->validated();
        $user = User::where("username", $data['username'])->first();
        $loginValidate = !$user || !Hash::check($data['password'], $user->password);
        if ($loginValidate) {
            throw new HttpResponseException(DontUseController::errorsResponse(login: $loginValidate));
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
        $user = Auth::user();
        $data = $req->validated();
        if (isset($data["name"])) {
            $user->name = $data["name"];
        }
        if (isset($data["password"])) {
            $user->password = Hash::make($data["password"]);
        }
        $user->save();
        return new UserResource($user);
    }

    public function logout(Request $req): JsonResponse
    {
        $user = Auth::user();
        $user->token = null;
        $user->save();
        return response()->json([
            "data" => true
        ])->setStatusCode(200);
    }
}
