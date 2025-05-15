<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserCreated;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    private $secretKey = '$2y$13$uDvlE8vyQu3RA6iS6Szqhuysk9zLc9xLwTVpWxOiedHI7LcgdH0zG';

    public function login(Request $request)
    {
         $fields = $request->all();

         $errors = Validator::make($fields,[
            'email' => 'required|email',
            'password' => 'required',
         ]);

         if($errors->fails()) {
            return response($errors->errors()->toArray(),422);
         }

         $user = User::where('email', $fields['email'])->first();

         if(!is_null($user)) {

            if(intval($user->emailIsValid) !== User::IS_VALID_EMAIL) {
                NewUserCreated::dispatch($user);
                return response(['message' => 'Nous vous envoyons un e-mail de vérification']);
            }

         }

         if(!$user || !Hash::check($fields['password'], $user->password))
         {
            return response(['message' => 'Email or password invalid'],422);
         }

         $token = $user->createToken($this->secretKey)->plainTextToken;

         return response([
            'user' => $user,
            'message' => 'Login successful',
            'token' => $token,
            'isLogin' => true
         ],200);
    }
}
