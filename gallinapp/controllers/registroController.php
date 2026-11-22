<?php
// Registro diario: aves muertas, alimento y agua de cada lote
// Los dos roles pueden registrar y editar. Solo el administrador puede eliminar.
require 'models/registroModel.php';
require 'models/loteModel.php';
$modelo    = new RegistroModel($con);
$loteModel = new LoteModel($con);
$error     = '';

// 1. Si se presionó un botón: eliminar, guardar o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['eliminar'])) {
        if (esAdmin()) $modelo->eliminar($_POST['eliminar']);
        header('Location: index.php?p=registro');
        exit;
    }
    // Validaciones en PHP (por si alguien se salta las de JavaScript)
    if ($_POST['id_lote'] == '') {
        $error = 'Elige el lote.';
    } elseif ($_POST['fecha'] > date('Y-m-d')) {
        $error = 'La fecha no puede ser mayor a hoy.';
    } elseif ($_POST['muertas'] < 0 || $_POST['alimento_kg'] < 0 || $_POST['agua_litros'] < 0) {
        $error = 'No se permiten números negativos.';
    } elseif ($_POST['id_registro'] == '' && $_POST['muertas'] > $loteModel->vivas($_POST['id_lote'])) {
        $error = 'No pueden morir más aves de las que quedan vivas en el lote.';
    } else {
        if ($_POST['id_registro'] == '') {
            $modelo->guardar($_POST);
        } else {
            $modelo->actualizar($_POST);
        }
        header('Location: index.php?p=registro');
        exit;
    }
}

// 2. Datos para la pantalla
if ($error) {
    $registro = $_POST;
} else {
    $registro = isset($_GET['editar']) ? $modelo->buscar($_GET['editar']) : null;
}
$registros = $modelo->listar();
$lotes     = $loteModel->listar();                       // para elegir el lote

require 'views/registros.php';
