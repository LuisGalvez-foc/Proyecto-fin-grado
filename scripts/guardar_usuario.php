<?php
include('../global/conexion.php');

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
    $rol = 1; // Asignar rol por defecto (puedes cambiarlo según tu lógica)

    if ($stmt) {
        $stmt->bind_param("ssssssi", $nombre, $apellido, $nick, $email, $telefono, $contraseña_hash, $rol);
        if ($stmt->execute()) {
            echo "Usuario registrado exitosamente.";
            header("Location: ../administracion.php");
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }
    } else {
        echo "Error en la preparación de la consulta: " . $con->error;
    }
}
?>