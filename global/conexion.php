<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('config.php');

$con = new mysqli(SERVIDOR, USUARIO, PASSWORD, BD);

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}
?>