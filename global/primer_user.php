<?php
include('../global/conexion.php'); // Asegúrate de que la conexión a la base de datos esté incluida

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $nick = $_POST['nick'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $contraseña = $_POST['pswd'];

    // Encriptar la contraseña
    $contraseña_hash = password_hash($contraseña, PASSWORD_ARGON2ID);

    // Preparar la consulta para insertar el nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, apellido, nick, email, telefono, contraseña, rol) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $rol = 2; // Asignar rol por defecto (administrador)

    if ($stmt) {
        $stmt->bind_param("ssssssi", $nombre, $apellido, $nick, $email, $telefono, $contraseña_hash, $rol);
        if ($stmt->execute()) {
            echo "Usuario registrado exitosamente.";
          
            exit(); // Asegúrate de salir después de redirigir
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }
    } else {
        echo "Error en la preparación de la consulta: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="css/base.css"> <!-- Asegúrate de tener estilos -->
</head>
<body>
    <div class="container">
        <h2>Registrar Nuevo Usuario</h2>
        <form action="" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" required>

            <label for="nick">Nombre de Usuario:</label>
            <input type="text" name="nick" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" required>

            <label for="pswd">Contraseña:</label>
            <input type="password" name="pswd" required>

            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>