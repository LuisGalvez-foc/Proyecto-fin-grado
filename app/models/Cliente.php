<?php 
require_once __DIR__."/../../config/conexion.php";

class Cliente {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function añadir_cliente($nombre_completo, $direccion, $ciudad, $provincia, $codigo_postal, $telefono, $email, $descuento) {
        $query = "INSERT INTO clientes (nombre_completo, direccion, ciudad, provincia, codigo_postal, telefono, email, descuento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssiisi", $nombre_completo, $direccion, $ciudad, $provincia, $codigo_postal, $telefono, $email, $descuento);
        return $stmt->execute();
    }

    public function eliminar_cliente($id_cliente) {
        $query = "DELETE FROM clientes WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_cliente);
        return $stmt->execute();
    }

    public function mostrar_clientes() {
        $query = "SELECT * FROM clientes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function obtener_cliente($id_cliente) {
        $query = "SELECT * FROM clientes WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function actualizar_cliente($id_cliente, $nombre_completo, $direccion, $ciudad, $provincia, $codigo_postal, $telefono, $email, $descuento) {
        $query = "UPDATE clientes SET nombre_completo = ?, direccion = ?, ciudad = ?, provincia = ?, codigo_postal = ?, telefono = ?, email = ?, descuento = ? WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssiisii", $nombre_completo, $direccion, $ciudad, $provincia, $codigo_postal, $telefono, $email, $descuento, $id_cliente);
        return $stmt->execute();
    }
}
?>