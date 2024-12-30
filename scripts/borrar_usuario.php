<?php
include('../global/conexion.php');

if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Preparar la consulta para borrar el usuario
    $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id_usuario);
        if ($stmt->execute()) {
            echo "Usuario borrado exitosamente.";
            header("Location: ../administracion.php");
        } else {
            echo "Error al borrar el usuario: " . $stmt->error;
        }
    } else {
        echo "Error en la preparación de la consulta: " . $con->error;
    }
}
?>