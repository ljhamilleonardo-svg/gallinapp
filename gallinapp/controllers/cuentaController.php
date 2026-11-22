<?php
// Crear cuenta: registra un usuario nuevo (con rol "usuario")
require 'models/usuarioModel.php';
$modelo = new UsuarioModel($con);
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validaciones en PHP (por si alguien se salta las de JavaScript)
    if (trim($_POST['nombre']) == '') {
        $error = 'Escribe tu nombre.';
    } elseif (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo no es válido.';
    } elseif (strlen($_POST['clave']) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif ($_POST['clave'] != $_POST['clave2']) {
        $error = 'Las dos contraseñas no son iguales.';
    } elseif ($modelo->buscarPorCorreo($_POST['correo'])) {
        $error = 'Ese correo ya está registrado.';
    } else {
        $modelo->guardar(trim($_POST['nombre']), $_POST['correo'], $_POST['clave']);
        header('Location: index.php?creada=1');     // vuelve al login con aviso verde
        exit;
    }
}

require 'views/cuenta.php';
