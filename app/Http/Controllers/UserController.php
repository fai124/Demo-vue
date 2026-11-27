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
        $user = new User();
        $user->name = $request->login;
        $user->login = $request->login;
        $user->password = Hash::make($request->password);
        $user->FIO = $request->FIO;
        $user->number = $request->number;
        $user->email = $request->email;
        $user->role = 'user';
        $user->save();

        return ['token' => $user->createToken('api')->plainTextToken];
    }

    public function login(UserLoginRequest $request)
    {
        $user = User::where('login', $request->login)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            return ['token' => $user->createToken('api')->plainTextToken];
        }

        return ['errors' => ['login' => ['Неверный логин или пароль']]];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ['message' => 'ok'];
    }
}
