<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-sm" style="width: 400px;">
        <div class="card-body">

            <h4 class="text-center mb-4">Iniciar sesión</h4>

            {{-- Mensaje de éxito (registro) --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.procesar') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                {{-- Botón login --}}
                <div class="d-grid mb-3">
                    <button class="btn btn-primary">
                        Entrar
                    </button>
                </div>
            </form>

            {{-- Registro --}}
            <div class="text-center">
                <span>¿No tienes cuenta?</span>
                <a href="{{ route('register') }}">Registrarse</a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
