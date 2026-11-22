<?php
// Inicio de sesión
require 'models/usuarioModel.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = (new UsuarioModel($con))->buscarPorCorreo($_POST['correo']);

    // password_verify compara la contraseña escrita con la guardada (cifrada)
    if ($usuario && password_verify($_POST['clave'], $usuario['clave'])) {
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol']    = $usuario['rol'];           // administrador o usuario
        header('Location: index.php');
        exit;
    }
    $error = 'Correo o contraseña incorrectos.';
}

require 'views/login.php';
