<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\CustomerRegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //register new user
    public function register(RegisterRequest $request)
    {
        //register user
        $user = $request->registerUser();

        //return response
        return response([
            "message" => "User registered successfully",
            "user" => $user,
        ], 201);
    }

    //customer register
    public function customerRegister(CustomerRegisterRequest $request)
    {
        //register user
        $user = $request->registerUser();

        //return response
        return response([
            "message" => "User registered successfully",
            "user" => $user,
        ], 201);
    }

    //login user
    public function login (LoginRequest $request)
    {
        //return response
        $token = $request->authenticated();
        if(!$token['success']){
            return response([
                "message" => $token['message']
            ], 401);
        }

        return response([
            "message" => "User logged in successfully",
            "token" => $token['token']
        ], 200);
    }

    //logout user
    public function logout(Request $request)
    {
        //logout user
        $request->user()->currentAccessToken()->delete();
        //return response
        return response([
            "message" => "User logged out successfully",
        ], 200);
    }
}
