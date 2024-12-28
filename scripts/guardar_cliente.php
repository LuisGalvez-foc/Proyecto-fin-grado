<?php
include('../global/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST['nombre_completo'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $provincia = $_POST['provincia'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $cod_postal = $_POST['cod_postal'];
    $dni = $_POST['dni'];
    $revendedora = $_POST['revendedora'];
    $descuento = $_POST['descuento'];

    $sql_insertar_cliente = "INSERT INTO clientes (nombre_completo, direccion, ciudad, provincia, telefono, email, codigo_postal, dni, revendedora, descuento) VALUES ('$nombre_completo', '$direccion', '$ciudad', '$provincia', '$telefono', '$email', '$cod_postal', '$dni', '$revendedora', '$descuento')";

    if ($con->query($sql_insertar_cliente) === TRUE) {
        echo "Nuevo cliente registrado exitosamente.";
    } else {
        echo "Error: " . $sql_insertar_cliente . "<br>" . $con->error;
    }
}
?>