<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('AuthJwt', ['except' => ['registration', 'login']]);
    }

    public function registration(RegistrationRequest $request)
    {
        $request->validated();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function login(LoginRequest $request)
    {
        $request->validated();
        try {
            $credentials = $request->only('email', 'password');
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Login fail'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 502);
        }
        
        $data = [
            'user' => Auth()->user(),
            'token' => $token
        ];
        return response()->json($data, 200);
    }

    public function logout()
    {
        try{
            auth()->logout();
            return response()->json(['message' => 'Logout successfully' ], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Logout fail' ], 502);
        }
    }
}
