<?php require 'views/menu.php'; ?>

<div class="cabecera d-flex justify-content-between align-items-center">
  <div>
    <h2 class="fw-bold">¡Hola, <?= e($_SESSION['nombre']) ?>! 👋</h2>
    <p class="mb-0">Así está tu granja hoy, <?= date('d/m/Y') ?>.</p>
  </div>
  <img src="views/images/gallinas.jpg" class="d-none d-md-block" alt="Gallinas">
</div>

<!-- Tarjetas de colores con los totales (los ven los dos roles) -->
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3"><div class="tarjeta amarillo"><div class="icono">🐣</div>Ingresaron<h2 class="fw-bold"><?= $ingresaron ?></h2></div></div>
  <div class="col-6 col-md-3"><div class="tarjeta rojo"><div class="icono">💔</div>Muertas<h2 class="fw-bold"><?= $muertas ?></h2></div></div>
  <div class="col-6 col-md-3"><div class="tarjeta azul"><div class="icono">💰</div>Vendidas<h2 class="fw-bold"><?= $vendidas ?></h2></div></div>
  <div class="col-6 col-md-3"><div class="tarjeta verde"><div class="icono">🐔</div>Vivas<h2 class="fw-bold"><?= $vivas ?></h2></div></div>
</div>

<!-- Panel según el rol -->
<div class="caja mb-4">
  <?php if (esAdmin()): ?>
    <h5 class="fw-bold">🛠️ Panel de administración</h5>
    <p class="fs-5">Total vendido: <b>Bs <?= number_format($totalVendido, 2) ?></b></p>
    <a href="index.php?p=reporte" target="_blank" class="btn btn-danger">📄 Descargar reporte PDF</a>
  <?php else: ?>
    <h5 class="fw-bold">👷 Tu trabajo de hoy</h5>
    <p>Anota en el registro diario las aves muertas, el alimento y el agua de cada lote.</p>
    <a href="index.php?p=registro" class="btn btn-success">📝 Registrar control diario</a>
  <?php endif; ?>
</div>

<div class="row g-4">

  <!-- Alertas -->
  <div class="col-lg-5">
    <div class="caja h-100">
      <h5 class="fw-bold mb-3">🔔 Alertas</h5>
      <?php if (!$alertas): ?>
        <div class="alert alert-success mb-0">✅ Todo en orden, no hay alertas.</div>
      <?php endif; ?>
      <?php foreach ($alertas as $a): ?>
        <div class="alert alert-<?= $a[0] ?> py-2"><?= e($a[1]) ?></div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Tabla: cuántas aves hay de cada tipo -->
  <div class="col-lg-7">
    <div class="caja p-0 table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead>
          <tr><th>Tipo de ave</th><th>Ingresaron</th><th>Muertas</th><th>Vendidas</th><th>Vivas</th></tr>
        </thead>
        <tbody>
          <?php foreach ($resumen as $r): ?>
            <tr>
              <td><?= $r['tipo'] ?></td>
              <td><?= $r['ingresaron'] ?></td>
              <td><?= $r['muertas'] ?></td>
              <td><?= $r['vendidas'] ?></td>
              <td><span class="badge bg-success fs-6"><?= $r['ingresaron'] - $r['muertas'] - $r['vendidas'] ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php require 'views/pie.php'; ?>
