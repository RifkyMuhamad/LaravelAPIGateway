<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DontUseController extends Controller
{
    public static function errorsResponse(bool $register = false, bool $login = false): JsonResponse
    {
        if ($register) {
            return new JsonResponse([
                "errors" => [
                    "username" => [
                        "username already registered"
                    ]
                ]
            ], 400);
        }
        if ($login) {
            return new JsonResponse([
                "errors" => [
                    "message" => [
                        "username or password wrong"
                    ]
                ]
            ], 401);
        }
    }

    public static function notFoundResponse(): JsonResponse
    {
        return response()->json([
            'errors' => [
                'message' => ['not found']
            ]
        ])->setStatusCode(404);
    }
}
