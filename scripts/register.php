<?php
// Habilitar el reporte de errores de mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Incluir el archivo de conexión
include('../global/conexion.php');

// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar la conexión a la base de datos
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que los campos estén definidos y no estén vacíos
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : null;
    $apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : null;
    $nick = isset($_POST['nick']) ? trim($_POST['nick']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;
    $contraseña = isset($_POST['pswd']) ? trim($_POST['pswd']) : null; // Obtener la contraseña correctamente

    // Verificar que todos los campos requeridos estén presentes
    if ($nombre && $apellido && $nick && $email && $telefono && $contraseña) {
        // Encriptar la contraseña
        $contraseña_hash = password_hash($contraseña, PASSWORD_ARGON2ID); // Encriptar la contraseña

        // Mostrar la contraseña encriptada en la consola
        echo "<script>alert('Contraseña encriptada: " . $contraseña_hash . "');</script>";

        // Preparar la consulta para insertar el nuevo usuario
        $sql = "INSERT INTO usuarios (nombre, apellido, nick, email, telefono, contraseña, rol) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $con->error);
        }

        // Asignar un rol por defecto
        $rol = 1; 
        $bind_result = $stmt->bind_param("ssssssi", $nombre, $apellido, $nick, $email, $telefono, $contraseña_hash, $rol);

        // Verificar si el bind_param fue exitoso
        if ($bind_result === false) {
            die("Error al bindear parámetros: " . $stmt->error);
        }

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir a login.php después de un registro exitoso
            header("Location: ../login.php");
            exit(); // Asegúrate de llamar a exit() después de header()
        } else {
            echo "Error al registrar el usuario: " . $stmt->error; // Muestra el error si la inserción falla
        }
    } else {
        echo "Por favor, completa todos los campos requeridos."; // Mensaje si faltan campos
    }
}
?>