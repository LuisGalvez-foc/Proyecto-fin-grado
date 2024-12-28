<?php
include('config.php');

$con = new mysqli(SERVIDOR, USUARIO, PASSWORD, BD);

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}
?>