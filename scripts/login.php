<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Asegúrate de iniciar la sesión al principio
include('../global/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nick = isset($_POST['nick']) ? trim($_POST['nick']) : null;
    $contraseña = isset($_POST['pswd']) ? trim($_POST['pswd']) : null;

    if ($nick && $contraseña) {
        $sql = "SELECT * FROM usuarios WHERE nick = ?";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $nick);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                $usuario = $result->fetch_assoc();
                if (password_verify($contraseña, $usuario['contraseña'])) {
                    // Iniciar sesión y redirigir al usuario
                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['nombre'] = $usuario['nombre'];
                    header("Location: ../index.php");
                    exit();
                } else {
                    echo "Contraseña incorrecta.";
                }
            } else {
                echo "Usuario no encontrado.";
            }
        } else {
            echo "Error en la preparación de la consulta: " . $con->error;
        }
    } else {
        echo "Por favor, completa todos los campos requeridos.";
    }
}
?>