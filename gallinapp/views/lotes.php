<?php require 'views/menu.php'; ?>

<div class="cabecera d-flex justify-content-between align-items-center">
  <div>
    <h2 class="fw-bold">🐥 Lotes de aves</h2>
    <p class="mb-0">Qué tipo de ave ingresó, a qué galpón y cuántas.</p>
  </div>
  <img src="views/images/gallinas-galpon.jpg" class="d-none d-md-block" alt="Gallinas en el galpón">
</div>

<div class="row g-4">

  <!-- Formulario: nuevo lote o editar (solo administrador) -->
  <?php if (esAdmin()): ?>
  <div class="col-lg-3">
    <div class="caja caja-form">
      <h5 class="fw-bold mb-3"><?= !empty($lote['id_lote']) ? '✏️ Editar lote' : '➕ Nuevo lote' ?></h5>
      <?php if ($error): ?><div class="alert alert-danger">❌ <?= $error ?></div><?php endif; ?>
      <form method="POST" class="validar">
        <input type="hidden" name="id_lote" value="<?= $lote['id_lote'] ?? '' ?>">

        <label class="form-label">Galpón</label>
        <select name="id_galpon" class="form-select mb-2" required>
          <option value="">-- Elegir --</option>
          <?php foreach ($galpones as $g): ?>
            <option value="<?= $g['id_galpon'] ?>" <?= ($lote['id_galpon'] ?? '') == $g['id_galpon'] ? 'selected' : '' ?>><?= e($g['nombre']) ?></option>
          <?php endforeach; ?>
        </select>

        <label class="form-label">Tipo de ave</label>
        <select name="id_tipo" class="form-select mb-2" required>
          <option value="">-- Elegir --</option>
          <?php foreach ($tipos as $t): ?>
            <option value="<?= $t['id_tipo'] ?>" <?= ($lote['id_tipo'] ?? '') == $t['id_tipo'] ? 'selected' : '' ?>><?= $t['nombre'] ?></option>
          <?php endforeach; ?>
        </select>

        <label class="form-label">Fecha de ingreso</label>
        <input type="date" name="fecha_ingreso" class="form-control mb-2" value="<?= $lote['fecha_ingreso'] ?? date('Y-m-d') ?>" required>

        <label class="form-label">¿Cuántas aves ingresaron?</label>
        <input type="number" name="cantidad" min="1" class="form-control mb-3" value="<?= $lote['cantidad'] ?? '' ?>" required>

        <button class="btn btn-success w-100 fw-bold">Guardar</button>
        <?php if (!empty($lote['id_lote'])): ?>
          <a href="index.php?p=lote" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        <?php endif; ?>
      </form>
    </div>
  </div>
  <?php endif; ?>

  <div class="<?= esAdmin() ? 'col-lg-9' : 'col-12' ?>">

    <!-- Búsqueda y filtros -->
    <form method="GET" class="caja filtros d-flex flex-wrap gap-2 align-items-end mb-3">
      <input type="hidden" name="p" value="lote">
      <div>
        <label class="form-label small mb-1">Tipo de ave</label>
        <select name="id_tipo" class="form-select form-select-sm">
          <option value="">Todos</option>
          <?php foreach ($tipos as $t): ?>
            <option value="<?= $t['id_tipo'] ?>" <?= ($_GET['id_tipo'] ?? '') == $t['id_tipo'] ? 'selected' : '' ?>><?= $t['nombre'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="form-label small mb-1">Galpón</label>
        <select name="id_galpon" class="form-select form-select-sm">
          <option value="">Todos</option>
          <?php foreach ($galpones as $g): ?>
            <option value="<?= $g['id_galpon'] ?>" <?= ($_GET['id_galpon'] ?? '') == $g['id_galpon'] ? 'selected' : '' ?>><?= e($g['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button class="btn btn-sm btn-success">🔍 Filtrar</button>
      <a href="index.php?p=lote" class="btn btn-sm btn-outline-secondary">Limpiar</a>
    </form>

    <!-- Tabla de lotes -->
    <div class="caja p-0 table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead>
          <tr><th>N°</th><th>Tipo de ave</th><th>Galpón</th><th>Ingreso</th><th>Ingresaron</th><th>Muertas</th><th>Vendidas</th><th>Vivas</th><?= esAdmin() ? '<th>Acciones</th>' : '' ?></tr>
        </thead>
        <tbody>
          <?php foreach ($lotes as $l): ?>
            <tr>
              <td><?= $l['id_lote'] ?></td>
              <td><?= $l['tipo'] ?></td>
              <td class="text-nowrap"><?= e($l['galpon']) ?></td>
              <td class="text-nowrap"><?= $l['fecha_ingreso'] ?></td>
              <td><?= $l['cantidad'] ?></td>
              <td><?= $l['muertas'] ?></td>
              <td><?= $l['vendidas'] ?></td>
              <td><span class="badge bg-success fs-6"><?= $l['cantidad'] - $l['muertas'] - $l['vendidas'] ?></span></td>
              <?php if (esAdmin()): ?>
                <td class="text-nowrap">
                  <a href="index.php?p=lote&editar=<?= $l['id_lote'] ?>" class="btn btn-sm btn-warning">Editar</a>
                  <form method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este lote con sus registros y ventas?')">
                    <button name="eliminar" value="<?= $l['id_lote'] ?>" class="btn btn-sm btn-danger">Eliminar</button>
                  </form>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
          <?php if (!$lotes): ?>
            <tr><td colspan="9" class="text-center text-muted py-4">No se encontraron lotes con esos filtros.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php require 'views/pie.php'; ?>
