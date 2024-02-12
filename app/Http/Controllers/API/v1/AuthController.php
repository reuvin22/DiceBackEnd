<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\v1\Auth\UserAccountRequest;

class AuthController extends Controller
{
    public function login(UserAccountRequest $request)
    {
        $account = $request->validated();

        $user = User::where('email', $account['email'])->first();

        if(!$user || !Hash::check($account['password'], $user->password)){
            return response()->json([
                'status' => 401,
                'message' => 'Wrong Username or Password'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Login Successfully',
            'data' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logout Successfully'
        ], 200);
    }
}
