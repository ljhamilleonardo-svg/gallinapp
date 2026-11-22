<?php
// Vista del reporte: dibuja el PDF con la librería FPDF
require 'libs/fpdf/fpdf.php';

// FPDF no entiende UTF-8: esta función convierte las tildes y la ñ
function t($texto) {
    return iconv('UTF-8', 'windows-1252//TRANSLIT', $texto);
}

$pdf = new FPDF();                                   // hoja A4 vertical, medidas en milímetros
$pdf->AddPage();

// Título
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(0, 10, t('GallinApp - Reporte de lotes'), 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(0, 6, t('Fecha: ' . date('d/m/Y') . '     Generado por: ' . $_SESSION['nombre']), 0, 1, 'C');
$pdf->Ln(4);

// Encabezado de la tabla: fondo verde y letra blanca
$anchos  = [12, 42, 30, 26, 22, 20, 20, 18];        // suman 190 mm (ancho útil de la hoja)
$titulos = ['N°', 'Tipo de ave', 'Galpón', 'Ingreso', 'Ingresaron', 'Muertas', 'Vendidas', 'Vivas'];
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->SetFillColor(21, 128, 61);
$pdf->SetTextColor(255, 255, 255);
foreach ($titulos as $i => $titulo) {
    $pdf->Cell($anchos[$i], 8, t($titulo), 1, 0, 'C', true);
}
$pdf->Ln();

// Una fila por cada lote
$pdf->SetFont('Helvetica', '', 9);
$pdf->SetTextColor(0, 0, 0);
foreach ($lotes as $l) {
    $fila = [$l['id_lote'], $l['tipo'], $l['galpon'], $l['fecha_ingreso'], $l['cantidad'],
             $l['muertas'], $l['vendidas'], $l['cantidad'] - $l['muertas'] - $l['vendidas']];
    foreach ($fila as $i => $dato) {
        $pdf->Cell($anchos[$i], 7, t($dato), 1, 0, 'C');
    }
    $pdf->Ln();
}

// Total vendido
$pdf->Ln(4);
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->Cell(0, 8, t('Total vendido: Bs ' . number_format(array_sum(array_column($ventas, 'total')), 2)), 0, 1);

$pdf->Output('I', 'reporte_gallinapp.pdf');          // 'I' = mostrar el PDF en el navegador
