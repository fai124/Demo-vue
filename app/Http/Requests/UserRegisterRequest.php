<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => 'required|min:6|unique:users,login',
            'password' => 'required|min:8',
            'FIO' => 'required|string',
            'number' => 'required|integer',
            'email' => 'required|email|unique:users,email',
        ];
    }
}
