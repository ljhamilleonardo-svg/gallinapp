<?php
// Panel: resumen de la granja, alertas y panel de administración según el rol
require 'models/loteModel.php';
require 'models/galponModel.php';
require 'models/ventaModel.php';
$loteModel = new LoteModel($con);
$resumen   = $loteModel->resumenPorTipo();

// Totales para las tarjetas de colores
$ingresaron = array_sum(array_column($resumen, 'ingresaron'));
$muertas    = array_sum(array_column($resumen, 'muertas'));
$vendidas   = array_sum(array_column($resumen, 'vendidas'));
$vivas      = $ingresaron - $muertas - $vendidas;

// Solo para el administrador: dinero vendido
if (esAdmin()) {
    $totalVendido = array_sum(array_column((new VentaModel($con))->listar(), 'total'));
}

// Alertas: [color, mensaje]
$alertas = [];

foreach ($loteModel->listar() as $l) {
    $vivasLote = $l['cantidad'] - $l['muertas'] - $l['vendidas'];
    if ($vivasLote <= 0) continue;                         // lote terminado, no avisa

    if ($l['muertas'] >= $l['cantidad'] * 0.05) {          // murió el 5 % o más
        $alertas[] = ['danger', "🚨 Lote {$l['id_lote']} ({$l['tipo']}): ya murieron {$l['muertas']} aves, el 5 % o más del lote."];
    }
    if ($l['ultimo_registro'] != date('Y-m-d')) {          // no hay registro de hoy
        $alertas[] = ['warning', "📝 Lote {$l['id_lote']} ({$l['tipo']}): falta el registro de hoy."];
    }
}

foreach ((new GalponModel($con))->listar() as $g) {
    if ($g['vivas'] > $g['capacidad']) {                   // galpón demasiado lleno
        $alertas[] = ['danger', "🏠 {$g['nombre']}: tiene {$g['vivas']} aves y solo caben {$g['capacidad']}."];
    }
}

require 'views/panel.php';
