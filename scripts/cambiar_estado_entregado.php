<?php
include('../global/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pedido = $_POST['id_pedido'];

    // Actualizar el estado de entregado en la base de datos
    $sql = "UPDATE pedido SET entregado = 'Sí' WHERE id_pedido = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id_pedido);

    if ($stmt->execute()) {
        echo "El pedido ha sido marcado como entregado.";
    } else {
        echo "Error al actualizar el estado: " . $stmt->error;
    }
} else {
    echo "Método no permitido.";
}
?>