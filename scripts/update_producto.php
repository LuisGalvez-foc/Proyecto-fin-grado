<?php
include('../global/conexion.php');

$descripcion = $_GET['descripcion'];
$color = $_GET['color'];
$talle = $_GET['talle'];
$cantidad = $_GET['cantidad'];
$precio = $_GET['precio'];
$id = $_GET['id_producto'];

// Usar declaraciones preparadas para evitar inyección SQL
$stmt = $con->prepare("UPDATE productos SET 
                        descripcion = ?, 
                        talle = ?, 
                        color = ?, 
                        cantidad = ?, 
                        precio = ? 
                        WHERE id_producto = ?");
$stmt->bind_param("sssiid", $descripcion, $talle, $color, $cantidad, $precio, $id);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Producto actualizado correctamente.";
} else {
    echo "Error al actualizar el producto: " . $stmt->error;
}

$stmt->close();
?>