<?php
include('../global/conexion.php'); // Asegúrate de que la conexión a la base de datos esté incluida

// Verificar si se ha recibido el ID del producto
if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Consulta para borrar el producto
    $sql = "DELETE FROM productos WHERE id_producto = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id_producto);

    if ($stmt->execute()) {
        echo "Producto borrado correctamente.";
    } else {
        echo "Error al borrar el producto: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID de producto no proporcionado.";
}
?>