<?php
// Galpones (solo administrador): dónde viven las aves y cuántas caben
require 'models/galponModel.php';
$modelo = new GalponModel($con);
$error  = '';

// 1. Si se presionó un botón: eliminar, guardar o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['eliminar'])) {
        $modelo->eliminar($_POST['eliminar']);
        header('Location: index.php?p=galpon');
        exit;
    }
    // Validaciones en PHP (por si alguien se salta las de JavaScript)
    if (trim($_POST['nombre']) == '') {
        $error = 'Escribe el nombre del galpón.';
    } elseif ($_POST['capacidad'] < 1) {
        $error = 'La capacidad debe ser 1 o más.';
    } else {
        if ($_POST['id_galpon'] == '') {
            $modelo->guardar($_POST);
        } else {
            $modelo->actualizar($_POST);
        }
        header('Location: index.php?p=galpon');
        exit;
    }
}

// 2. Datos para la pantalla
if ($error) {
    $galpon = $_POST;                                    // vuelve a mostrar lo que se escribió
} else {
    $galpon = isset($_GET['editar']) ? $modelo->buscar($_GET['editar']) : null;
}
$galpones = $modelo->listar();

require 'views/galpones.php';
