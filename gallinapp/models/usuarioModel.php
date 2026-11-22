<?php
// Modelo de usuarios: cuentas, contraseñas y roles
class UsuarioModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function buscarPorCorreo($correo) {
        $st = $this->con->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $st->execute([$correo]);
        return $st->fetch();
    }

    // Crea una cuenta nueva. password_hash guarda la contraseña cifrada.
    // El rol queda como "usuario" (valor por defecto de la tabla).
    public function guardar($nombre, $correo, $clave) {
        $st = $this->con->prepare("INSERT INTO usuarios (nombre, correo, clave) VALUES (?, ?, ?)");
        $st->execute([$nombre, $correo, password_hash($clave, PASSWORD_DEFAULT)]);
    }
}
