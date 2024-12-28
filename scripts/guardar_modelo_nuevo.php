<script>
    function guardado() {
        alert('Modelo registrado correctamente');
        window.location = '../alta_baja.php?buscar=';
    }
</script>

<?php
include('../global/conexion.php');

// Obtener los datos del formulario
$descripcion = $_GET['descripcion'];
$color = $_GET['color'];
$talle = $_GET['talle'];
$cantidad = $_GET['cantidad'];
$precio = $_GET['precio'];

// Consulta para insertar el nuevo modelo
$sql_guardar_nuevo = "INSERT INTO productos (descripcion, talle, color, cantidad, precio) VALUES (
    '$descripcion', '$talle', '$color', '$cantidad', '$precio')";

// Ejecutar la consulta
if ($con->query($sql_guardar_nuevo)) {
    echo "<script>guardado();</script>";
} else {
    // Manejo de errores en caso de que la consulta falle
    if ($con->errno == 1062) {
        echo "<script>alert('No guardado !! ..El artículo ya existe');</script>";
        echo "<script>window.location = '../alta_baja.php?buscar=';</script>";
    } else {
        echo "<script>alert('Error al guardar el modelo: " . $con->error . "');</script>";
    }
}
?>