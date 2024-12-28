<?php
include('global/conexion.php');

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

// Datos de prueba
$nombre = "Juan";
$apellido = "Pérez";
$nick = "juanp";
$email = "juan@example.com";
$telefono = "123456789";
$contraseña = password_hash("contraseña123", PASSWORD_DEFAULT); // Encriptar la contraseña
$rol = 1;

// Preparar la consulta
$sql = "INSERT INTO usuarios (nombre, apellido, nick, email, telefono, contraseña, rol) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($sql);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $con->error);
}

$stmt->bind_param("sssssdi", $nombre, $apellido, $nick, $email, $telefono, $contraseña, $rol);

if ($stmt->execute()) {
    echo "Inserción manual exitosa";
} else {
    echo "Error en inserción manual: " . $stmt->error;
}
?>