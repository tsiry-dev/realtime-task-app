<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserCreated;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
         $fields = $request->all();

         $errors = Validator::make($fields,[
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
         ]);

         if($errors->fails()) {
            return response($errors->errors()->toArray(),422);
         }

         $user = User::create([
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'emailIsValid' => User::IS_INVALID_EMAIL,
            'remember_token' => $this->generateRandomToken()
         ]);

         NewUserCreated::dispatch($user);

         return response(['message' => 'user created'],200);
    }

    public function generateRandomToken()
    {
        $token = Str::random(10) . time();
        return $token;
    }
}
