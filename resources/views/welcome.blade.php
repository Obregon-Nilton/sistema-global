<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
        }

        .container {
            text-align: center;
            background: rgba(0,0,0,0.5);
            padding: 60px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 40px;
        }

        .button {
            display: inline-block;
            text-decoration: none;
            padding: 15px 50px;
            background-color: #11d462;
            color: #fff;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: 0.3s;
            font-weight: bold;
        }

        .button:hover {
            background-color: #0aa14d;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        /* Responsivo */
        @media (max-width: 500px) {
            h1 {
                font-size: 2rem;
            }
            .button {
                padding: 12px 30px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido</h1>
        <a href="{{ route('inicio.index') }}" class="button">Entrar al Sistema</a>
    </div>
</body>
</html>
