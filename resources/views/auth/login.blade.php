<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            /* Asegúrate de que la imagen de fondo se ajuste y se centre */
            background-image: url('URL_DE_LA_IMAGEN_DE_FONDO'); /* Reemplaza con la URL de tu imagen */
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: sans-serif; /* Fuente más común para legibilidad */
        }

        .login-container {
            /* Fondo semi-transparente para el contenedor del formulario */
            background-color: rgba(0, 0, 0, 0.5); /* Fondo más oscuro y más transparente */
            padding: 20px; /* Espacio interno alrededor del contenido */
            border-radius: 8px; /* Bordes redondeados para suavizar el formulario */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Sombra sutil para destacar el formulario */
            text-align: center; /* Centrar el texto dentro del contenedor */
            width: 320px; /* Ancho fijo para el formulario, ajustable según necesidad */
            border: 1px solid rgba(255, 255, 255, 0.1); /* Agregamos un borde muy ligero */
        }

        .login-container h2 {
            margin-bottom: 20px; /* Espacio debajo del título */
            color: #fff; /* Color de texto blanco para el título */
            font-size: 24px; /* Tamaño de fuente más grande para el título */
            font-weight: bold; /* Hace que el título sea más prominente */
        }


       
      
        

        .login-container button:hover {
            background-color: #7b1fa2; /* Un tono más oscuro al pasar el mouse */
        }

        /* Estilos para el mensaje de error */
        .error-message {
            color: #ff6666; /* Un rojo más llamativo */
            margin-top: 15px;
            font-size: 14px;
            background-color: rgba(255, 255, 255, 0.2); /* Fondo muy claro para el error */
            padding: 10px;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <h1 class="mb-4" style="color: var(--color_menu)">QUIRIQUIRE GAS S.A.</h1>
    <div class="login-container">
        
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="mb-3">
              <input class="form-control" type="text" name="email" placeholder="Correo electrónico" required autofocus>
            </div>
            <div class="mb-3">
              <input class="form-control" type="password" name="password" placeholder="Contraseña" required>
            </div>
            <button class="btn btn-danger" type="submit">Iniciar sesión</button>
             @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif
        </form>
    </div>
</body>
</html>
