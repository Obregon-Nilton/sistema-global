<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function iniciarSesion(Request $request)
    {
        $credenciales = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credenciales)) {
            return response()->json([
                'mensaje' => 'Credenciales incorrectas'
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            'mensaje' => 'Sesión iniciada',
            'usuario' => Auth::user()
        ]);
    }

    public function cerrarSesion(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'mensaje' => 'Sesión cerrada'
        ]);
    }

    public function usuarioAutenticado()
    {
        return response()->json([
            'usuario' => Auth::user()
        ]);
    }
}
