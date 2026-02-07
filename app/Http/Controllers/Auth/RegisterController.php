<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Mostrar formulario de registro
     */
    public function mostrarFormulario()
    {
        return view('auth.register');
    }

    /**
     * Procesar registro
     */
    public function registrar(Request $request)
    {
        $request->validate([
            'nombre'             => 'required|string|max:100',
            'apellido'           => 'required|string|max:100',
            'dni'                => 'required|string|max:10|unique:personas,dni',
            'telefono'           => 'nullable|string|max:15',
            'fecha_nacimiento'   => 'required|date',
            'email'              => 'required|email|unique:users,email',
            'password'           => 'required|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request) {

            $persona = Persona::create([
                'nombre'           => $request->nombre,
                'apellido'         => $request->apellido,
                'dni'              => $request->dni,
                'telefono'         => $request->telefono,
                'fecha_nacimiento' => $request->fecha_nacimiento,
            ]);

            User::create([
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'persona_id' => $persona->id_persona,
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Cuenta creada correctamente');
    }
}
