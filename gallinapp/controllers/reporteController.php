<?php
// Reporte PDF (solo administrador): junta los datos y llama a la vista que dibuja el PDF
require 'models/loteModel.php';
require 'models/ventaModel.php';
$lotes  = (new LoteModel($con))->listar();
$ventas = (new VentaModel($con))->listar();

require 'views/reporte.php';
