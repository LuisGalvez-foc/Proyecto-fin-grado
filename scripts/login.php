<?php
include('../global/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que los campos estén definidos y no estén vacíos
    $nick = isset($_POST['nick']) ? trim($_POST['nick']) : null;
    $contraseña = isset($_POST['pswd']) ? trim($_POST['pswd']) : null;

    // Validar que los campos requeridos estén presentes
    if ($nick && $contraseña) {
        // Preparar la consulta para buscar el usuario
        $sql = "SELECT * FROM usuarios WHERE nick = ?";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $nick);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Verificar si se encontró el usuario
            if ($result->num_rows > 0) {
                $usuario = $result->fetch_assoc();
        
                // Verificar la contraseña
                if (password_verify($contraseña, $usuario['contraseña'])) {
                    // Iniciar sesión y redirigir al usuario
                    session_start();
                    $_SESSION['id_usuario'] = $usuario['id_usuario']; // Asegúrate de que 'id_usuario' sea el identificador correcto
                    $_SESSION['nombre'] = $usuario['nombre']; // Almacena el nombre del usuario en la sesión
                    header("Location: ../index.php"); // Redirigir a la página de inicio
                    exit(); // Asegúrate de llamar a exit() después de header()
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