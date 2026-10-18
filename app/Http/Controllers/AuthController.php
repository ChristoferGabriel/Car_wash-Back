<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credenciais = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $usuario = User::where('email', $credenciais['email'])->first();

        $hashFalso = Cache::rememberForever('auth:hash-falso', fn () => Hash::make(Str::random(32)));

        $senhaConfere = Hash::check($credenciais['password'], $usuario?->password ?? $hashFalso);

        if (! $usuario || ! $senhaConfere) {
            throw ValidationException::withMessages([
                'email' => 'E-mail ou senha inválidos',
            ]);
        }

        $usuario->tokens()->delete();

        return response()->json([
            'token' => $usuario->createToken('admin')->plainTextToken,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sessão encerrada']);
    }
}