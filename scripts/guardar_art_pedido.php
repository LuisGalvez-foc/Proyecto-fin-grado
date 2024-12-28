<?php 
include('../global/conexion.php');

// Obtener los parámetros de la solicitud GET
$id_producto = $_GET['id_producto'];
$id_pedido = $_GET['id_pedido'];

// Consulta para insertar el artículo en la lista de pedidos
$sql = "INSERT INTO pedido_lista (id_producto, id_pedido) VALUES ('$id_producto', '$id_pedido')";

// Ejecutar la consulta
if ($con->query($sql) === TRUE) {
    // Opcional: puedes agregar un mensaje de éxito o realizar otras acciones
    echo "Artículo agregado al pedido con éxito.";
} else {
    // Manejo de errores en caso de que la consulta falle
    echo "Error al agregar el artículo al pedido: " . $con->error;
}
?>