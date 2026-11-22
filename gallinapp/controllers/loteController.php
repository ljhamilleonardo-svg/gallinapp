<?php
// Lotes: qué tipo de ave ingresó, a qué galpón y cuántas
// El administrador registra, edita y elimina. El usuario solo puede ver y buscar.
require 'models/loteModel.php';
require 'models/galponModel.php';
$modelo = new LoteModel($con);
$error  = '';

// 1. Si se presionó un botón (solo el administrador puede cambiar lotes)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && esAdmin()) {
    if (isset($_POST['eliminar'])) {
        $modelo->eliminar($_POST['eliminar']);
        header('Location: index.php?p=lote');
        exit;
    }
    // Validaciones en PHP (por si alguien se salta las de JavaScript)
    if ($_POST['id_galpon'] == '' || $_POST['id_tipo'] == '') {
        $error = 'Elige el galpón y el tipo de ave.';
    } elseif ($_POST['fecha_ingreso'] > date('Y-m-d')) {
        $error = 'La fecha de ingreso no puede ser mayor a hoy.';
    } elseif ($_POST['cantidad'] < 1) {
        $error = 'La cantidad de aves debe ser 1 o más.';
    } else {
        if ($_POST['id_lote'] == '') {
            $modelo->guardar($_POST);
        } else {
            $modelo->actualizar($_POST);
        }
        header('Location: index.php?p=lote');
        exit;
    }
}

// 2. Datos para la pantalla
if ($error) {
    $lote = $_POST;                                      // vuelve a mostrar lo que se escribió
} else {
    $lote = isset($_GET['editar']) ? $modelo->buscar($_GET['editar']) : null;
}
$lotes    = $modelo->listar($_GET);                      // con los filtros de búsqueda
$tipos    = $modelo->tipos();
$galpones = (new GalponModel($con))->listar();

require 'views/lotes.php';
