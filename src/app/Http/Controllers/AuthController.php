<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request) {
        try{
            $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
            ],
            [
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => '正しいメールアドレス形式で入力してください',
                'password.required' => 'パスワードを入力してください',
            ]
        );
        }catch(ValidationException $e){
             return response()->json([
            'message' => '入力エラーです',
            'errors' => $e->errors(),
        ], 422);
        }
        
        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'メールアドレスまたはパスワードが違います'
            ], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
         $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
        'message' => 'ログイン成功',
        'token' => $token,
        'user' => $user,
    ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'ログアウトしました',
        ]);
    }
}
