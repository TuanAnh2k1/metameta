<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class CasController extends Controller
{
    /**
     * @return bool
     */
    public function login(): bool
    {
        return cas()->authenticate();
    }

    /**
     * @return JsonResponse
     */
    public function info()
    : JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => cas()->user()
        ]);
    }

    /**
     * @return void
     */
    public function logout()
    : void
    {
        cas()->logout();
    }
}
