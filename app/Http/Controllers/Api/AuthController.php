<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Nette\Schema\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            throw ValidationException::withMessages([
                'email' => ['User does not exist']
            ]);
        }

        if(!Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['Provided creditionals are not correct']
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
           'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'logged out'
        ]);
    }
}
