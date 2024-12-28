<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" type="text/css" href="css/base.css"> <!-- Asegúrate de tener estilos -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <style>
        /* Aquí puedes incluir el CSS que proporcionaste */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Jost', sans-serif;
            background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e); /* Degradado de fondo */
        }
        .main {
            width: 350px;
            height: auto; /* Cambiado a auto para adaptarse al contenido */
            background: rgba(255, 255, 255, 0.9); /* Fondo blanco con opacidad */
            border-radius: 10px;
            box-shadow: 5px 20px 50px #000;
            padding: 20px; /* Añadido padding para mejor espaciado */
        }
        .login {
            position: relative;
            width: 100%;
        }
        label {
            color: #573b8a;
            font-size: 2.3em;
            justify-content: center;
            display: flex;
            margin: 20px 0; /* Ajustado el margen */
            font-weight: bold;
            cursor: pointer;
            transition: .5s ease-in-out;
        }
        input {
            width: 100%; /* Cambiado a 100% para ocupar todo el ancho */
            height: 40px; /* Ajustado para mejor apariencia */
            background: #e0dede;
            margin: 10px 0; /* Ajustado el margen */
            padding: 12px;
            border: none;
            outline: none;
            border-radius: 5px;
        }
        button {
            width: 100%; /* Cambiado a 100% para ocupar todo el ancho */
            height: 40px;
            margin: 20px 0; /* Ajustado el margen */
            color: #fff;
            background: #573b8a;
            font-size: 1em;
            font-weight: bold;
            outline: none;
            border: none;
            border-radius: 5px;
            transition: .2s ease-in;
            cursor: pointer;
        }
        button:hover {
            background: #6d44b8;
        }
        p {
            text-align: center; /* Centrar el texto */
            color: #573b8a;
        }
        a {
            color: #573b8a; /* Color del enlace */
            text-decoration: underline; /* Subrayado */
        }
    </style>
</head>
<body>
    <div class="main">  	
        <div class="login">
            <form action="scripts/login.php" method="POST">
                <label for="chk" aria-hidden="true">Iniciar Sesión</label>
                <input type="text" name="nick" placeholder="Nombre de Usuario" required>
                <input type="password" name="pswd" placeholder="Contraseña" required>
                <button type="submit">Iniciar Sesión</button>
            </form>
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>