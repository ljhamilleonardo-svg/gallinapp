<?php
// Puerta de entrada: revisa la sesión y abre el controlador de la página pedida.
// Ejemplo: index.php?p=lote  abre  controllers/loteController.php
session_start();
date_default_timezone_set('America/La_Paz');      // hora de Bolivia
require 'config/conexion.php';

// Muestra un texto escrito por el usuario de forma segura
function e($texto) {
    return htmlspecialchars($texto ?? '');
}

// ¿La persona que entró es administrador?
function esAdmin() {
    return ($_SESSION['rol'] ?? '') == 'administrador';
}

// ROLES Y PERMISOS: páginas que puede abrir cada rol
$permisos = [
    'administrador' => ['panel', 'galpon', 'lote', 'registro', 'venta', 'reporte'],
    'usuario'       => ['panel', 'lote', 'registro'],
];

$p = $_GET['p'] ?? 'panel';

if ($p == 'salir') {
    session_destroy();
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['rol'])) {
    if ($p != 'cuenta') $p = 'login';               // sin sesión: solo login o crear cuenta
} elseif (!in_array($p, $permisos[$_SESSION['rol']])) {
    $p = 'panel';                                    // página no permitida para su rol
}

require "controllers/{$p}Controller.php";
