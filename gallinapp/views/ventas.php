<?php require 'views/menu.php'; ?>

<div class="cabecera d-flex justify-content-between align-items-center">
  <div>
    <h2 class="fw-bold">💰 Ventas</h2>
    <p class="mb-0">Aves vendidas de cada lote y cuánto se ganó.</p>
  </div>
  <img src="views/images/pollitos.jpg" class="d-none d-md-block" alt="Pollitos">
</div>

<div class="row g-4">

  <!-- Formulario: nueva venta o editar -->
  <div class="col-lg-3">
    <div class="caja caja-form">
      <h5 class="fw-bold mb-3"><?= !empty($venta['id_venta']) ? '✏️ Editar venta' : '➕ Nueva venta' ?></h5>
      <?php if ($error): ?><div class="alert alert-danger">❌ <?= $error ?></div><?php endif; ?>
      <form method="POST" class="validar">
        <input type="hidden" name="id_venta" value="<?= $venta['id_venta'] ?? '' ?>">

        <label class="form-label">Lote</label>
        <select name="id_lote" class="form-select mb-2" required>
          <option value="">-- Elegir --</option>
          <?php foreach ($lotes as $l): ?>
            <option value="<?= $l['id_lote'] ?>" <?= ($venta['id_lote'] ?? '') == $l['id_lote'] ? 'selected' : '' ?>>
              Lote <?= $l['id_lote'] ?> - <?= $l['tipo'] ?> (<?= e($l['galpon']) ?>)
            </option>
          <?php endforeach; ?>
        </select>

        <label class="form-label">Fecha</label>
        <input type="date" name="fecha" class="form-control mb-2" value="<?= $venta['fecha'] ?? date('Y-m-d') ?>" required>

        <label class="form-label">Cantidad de aves</label>
        <input type="number" name="cantidad" min="1" class="form-control mb-2" value="<?= $venta['cantidad'] ?? '' ?>" required>

        <label class="form-label">Precio por ave (Bs)</label>
        <input type="number" name="precio" min="0" step="0.01" class="form-control mb-2" value="<?= $venta['precio'] ?? '' ?>" required>

        <label class="form-label">Comprador</label>
        <input name="comprador" class="form-control mb-3" value="<?= e($venta['comprador'] ?? '') ?>">

        <button class="btn btn-success w-100 fw-bold">Guardar</button>
        <?php if (!empty($venta['id_venta'])): ?>
          <a href="index.php?p=venta" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <div class="col-lg-9">

    <!-- Búsqueda y filtros -->
    <form method="GET" class="caja filtros d-flex flex-wrap gap-2 align-items-end mb-3">
      <input type="hidden" name="p" value="venta">
      <div>
        <label class="form-label small mb-1">Comprador</label>
        <input name="comprador" class="form-control form-control-sm" placeholder="Buscar por nombre" value="<?= e($_GET['comprador'] ?? '') ?>">
      </div>
      <div>
        <label class="form-label small mb-1">Desde</label>
        <input type="date" name="desde" class="form-control form-control-sm" value="<?= e($_GET['desde'] ?? '') ?>">
      </div>
      <div>
        <label class="form-label small mb-1">Hasta</label>
        <input type="date" name="hasta" class="form-control form-control-sm" value="<?= e($_GET['hasta'] ?? '') ?>">
      </div>
      <button class="btn btn-sm btn-success">🔍 Filtrar</button>
      <a href="index.php?p=venta" class="btn btn-sm btn-outline-secondary">Limpiar</a>
    </form>

    <!-- Tabla de ventas -->
    <div class="caja p-0 table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead>
          <tr><th>Fecha</th><th>Lote</th><th>Comprador</th><th>Cantidad</th><th>Precio (Bs)</th><th>Total (Bs)</th><th>Acciones</th></tr>
        </thead>
        <tbody>
          <?php foreach ($ventas as $v): ?>
            <tr>
              <td class="text-nowrap"><?= $v['fecha'] ?></td>
              <td>Lote <?= $v['id_lote'] ?> - <?= $v['tipo'] ?></td>
              <td><?= e($v['comprador']) ?></td>
              <td><?= $v['cantidad'] ?></td>
              <td><?= $v['precio'] ?></td>
              <td><?= number_format($v['total'], 2) ?></td>
              <td class="text-nowrap">
                <a href="index.php?p=venta&editar=<?= $v['id_venta'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta venta?')">
                  <button name="eliminar" value="<?= $v['id_venta'] ?>" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$ventas): ?>
            <tr><td colspan="7" class="text-center text-muted py-4">No se encontraron ventas con esos filtros.</td></tr>
          <?php endif; ?>
        </tbody>
        <tfoot>
          <tr class="table-warning">
            <th colspan="5" class="text-end">Total vendido:</th>
            <th colspan="2">Bs <?= number_format(array_sum(array_column($ventas, 'total')), 2) ?></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

</div>

<?php require 'views/pie.php'; ?>
