<?php 
require_once __DIR__."/../../config/conexion.php";

class User{
    private $conn;

    public function __construct(){
        global $conn;
        $this->conn=$conn;
    }

    public function eliminar_usuarios($id){
        $sql = "DELETE FROM usuarios WHERE id = '$id'";
        $this->conn->query($sql);
    } 

    public function loginUser ($nick, $contraseña) {
        $sql = "SELECT * FROM usuarios WHERE nick = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return false; // Usuario no encontrado
        }

        $user = $result->fetch_assoc();
        if (password_verify($contraseña, $user['contraseña'])) {
            return $user; // Credenciales correctas
        } else {
            return false; // Contraseña incorrecta
        }
    }

    public function registrarUser ($nombre, $apellido,$nick, $contraseña,$is_admin,$is_medium,$is_visitor) {
        $sql = "SELECT * FROM usuarios WHERE nick = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return "El usuario ya está registrado.";
        }

        $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre,apellido, nick,contraseña,is_admin,is_medium,is_visitor) VALUES (?, ?, ?, ?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre,$apellido, $nick, $contraseña_hash);
        if ($stmt->execute()) {
            return true;
        } else {
            return "Error al registrar el usuario.";
        }
    }

}