<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = new User;
        $user->name = $request->login;
        $user->login = $request->login;
        $user->password = Hash::make($request->password);
        $user->FIO = $request->FIO;
        $user->number = $request->number;
        $user->email = $request->email;
        $user->role = 'user';
        $user->save();

        return response()->json(['token' => $user->createToken('api')->plainTextToken]);
    }

    public function login(UserLoginRequest $request)
    {
        $user = User::where('login', $request->login)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json(['token' => $user->createToken('api')->plainTextToken]);
        }

        return response()->json(['errors' => ['login' => ['Неверный логин или пароль']]], 422);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
