<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Mostrar formulario de login
    |--------------------------------------------------------------------------
    | Solo devuelve la vista
    |--------------------------------------------------------------------------
    */
    public function mostrarFormulario()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Procesar login (WEB)
    |--------------------------------------------------------------------------
    | Usa sesión (auth:web)
    |--------------------------------------------------------------------------
    */
    public function iniciarSesion(Request $request)
    {
        $credenciales = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credenciales)) {
            return back()
                ->withErrors(['email' => 'Credenciales incorrectas'])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('inicio.index');
    }

    /*
    |--------------------------------------------------------------------------
    | Cerrar sesión (WEB)
    |--------------------------------------------------------------------------
    */
    public function cerrarSesion(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}
