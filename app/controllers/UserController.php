<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function registrarUsuario($data) {
        return $this->userModel->registrarUser ($data['nombre'], $data['apellido'], $data['nick'], $data['contraseña'], $data['is_admin'], $data['is_medium'], $data['is_visitor']);
    }

    public function eliminarUsuario($id) {
        return $this->userModel->eliminar_usuarios($id);
    }

    public function login($nick, $contraseña) {
        return $this->userModel->loginUser ($nick, $contraseña);
    }
}
    ?>