<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GallinApp</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Nuestro diseño (?v=5 obliga al navegador a cargar la versión nueva) -->
  <link href="views/css/estilos.css?v=5" rel="stylesheet">
</head>
<body>
<div class="d-md-flex">

  <!-- Menú: a la izquierda en computadora, arriba en celular -->
  <nav class="menu p-3 flex-shrink-0">
    <div class="text-center mb-3">
      <img src="views/images/pollitos.jpg" class="logo" alt="GallinApp">
      <h4 class="text-white fw-bold mt-2 mb-0">GallinApp</h4>
      <small class="text-white-50">Granja avícola</small>
    </div>

    <!-- Cada rol ve solo las páginas que tiene permitidas -->
    <a href="index.php?p=panel"    class="<?= $p == 'panel'    ? 'activo' : '' ?>">📊 Panel</a>
    <?php if (esAdmin()): ?>
      <a href="index.php?p=galpon" class="<?= $p == 'galpon'   ? 'activo' : '' ?>">🏠 Galpones</a>
    <?php endif; ?>
    <a href="index.php?p=lote"     class="<?= $p == 'lote'     ? 'activo' : '' ?>">🐥 Lotes</a>
    <a href="index.php?p=registro" class="<?= $p == 'registro' ? 'activo' : '' ?>">📝 Registro diario</a>
    <?php if (esAdmin()): ?>
      <a href="index.php?p=venta"   class="<?= $p == 'venta'   ? 'activo' : '' ?>">💰 Ventas</a>
      <a href="index.php?p=reporte" target="_blank">📄 Reporte PDF</a>
    <?php endif; ?>

    <hr class="text-white">
    <p class="text-white small mb-1">👤 <?= e($_SESSION['nombre']) ?></p>
    <span class="badge rol mb-2"><?= esAdmin() ? 'Administrador' : 'Usuario' ?></span>
    <a href="index.php?p=salir">🚪 Salir</a>
  </nav>

  <!-- Contenido de cada página -->
  <main class="flex-grow-1 p-3 p-md-4">
