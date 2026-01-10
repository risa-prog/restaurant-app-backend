<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request) {
        try{
            $validated = $request->validate([
                'name' => 'required| string| max:255',
                'email' => 'required| email| unique:users,email',
                'password' => 'required| min:8| confirmed',
            ], [
                'name.required' => '名前を入力してください',
                'name.string' => '名前は文字列で入力してください',
                'name.max' => '名前は255文字以内で入力してください',
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => '正しいメールアドレス形式で入力してください',
                'email.unique' => 'このメールアドレスは既に登録されています',
                'password.required' => 'パスワードを入力してください',
                'password.min' => 'パスワードは8文字以上で入力してください',
                'password.confirmed' => 'パスワードが一致しません'
            ]);
        }catch(ValidationException $e){
           return response()->json([
                'message' => '入力エラーです',
                'errors' => $e->errors(),
           ], 422);
        }
        
        $user = User::create([
             'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => '新規登録に成功しました',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request) {
        try{
            $credentials = $request->validate([
                'email' => 'required| email',
                'password' => 'required'
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
        'message' => 'ログインしました',
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
