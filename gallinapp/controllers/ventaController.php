<?php
// Ventas (solo administrador): aves vendidas de cada lote
require 'models/ventaModel.php';
require 'models/loteModel.php';
$modelo    = new VentaModel($con);
$loteModel = new LoteModel($con);
$error     = '';

// 1. Si se presionó un botón: eliminar, guardar o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['eliminar'])) {
        $modelo->eliminar($_POST['eliminar']);
        header('Location: index.php?p=venta');
        exit;
    }
    // Validaciones en PHP (por si alguien se salta las de JavaScript)
    if ($_POST['id_lote'] == '') {
        $error = 'Elige el lote.';
    } elseif ($_POST['fecha'] > date('Y-m-d')) {
        $error = 'La fecha no puede ser mayor a hoy.';
    } elseif ($_POST['cantidad'] < 1 || $_POST['precio'] < 0) {
        $error = 'Revisa la cantidad (1 o más) y el precio (no negativo).';
    } elseif ($_POST['id_venta'] == '' && $_POST['cantidad'] > $loteModel->vivas($_POST['id_lote'])) {
        $error = 'No se pueden vender más aves de las que quedan vivas en el lote.';
    } else {
        if ($_POST['id_venta'] == '') {
            $modelo->guardar($_POST);
        } else {
            $modelo->actualizar($_POST);
        }
        header('Location: index.php?p=venta');
        exit;
    }
}

// 2. Datos para la pantalla
if ($error) {
    $venta = $_POST;
} else {
    $venta = isset($_GET['editar']) ? $modelo->buscar($_GET['editar']) : null;
}
$ventas = $modelo->listar($_GET);                        // con los filtros de búsqueda
$lotes  = $loteModel->listar();

require 'views/ventas.php';
