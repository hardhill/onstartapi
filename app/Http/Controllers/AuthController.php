<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function registration(Request $request){
        $fields = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users,email',
            'password'=>'required|string|confirmed|min:8'
        ]);
        
            $user = User::create([
                'name'=>$fields['name'],
                'email'=>$fields['email'],
                'password'=>bcrypt($fields['password'])
            ]);
            
            $token = $user->createToken('onstart')->plainTextToken;
            $response = [
                'user'=> $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ];
        return response($response,201);
    }
    public function login(Request $request){
        $fields = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response('Login invalid', 503);
        }
        $token = $user->createToken('onstart')->plainTextToken;
        $response = [
            'user'=> $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
        return response($response,200);
    }

    public function logout()
    {
        //auth()->user()->tokens()->delete();
        Auth::user()->tokens()->delete();
        return [
            'message' => 'Tokens Revoked'
        ];
    }

    public function me(Request $request)
    {
        return $request->user();
    }
}
