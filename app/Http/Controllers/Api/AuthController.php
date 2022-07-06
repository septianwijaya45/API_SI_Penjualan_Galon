<?php

namespace App\Http\Controllers\Api;

use App\Helper\UserServices;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $response = (new UserServices($request->email, $request->password))->login($request->deviceName);
        return response()->json($response);
    }

    function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout Success', 'data' => $request]);
    }
}
