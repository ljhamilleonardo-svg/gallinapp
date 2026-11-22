<?php require 'views/menu.php'; ?>

<div class="cabecera d-flex justify-content-between align-items-center">
  <div>
    <h2 class="fw-bold">📝 Registro diario</h2>
    <p class="mb-0">Cada día: aves muertas, alimento y agua de cada lote.</p>
  </div>
  <img src="views/images/bebedero.jpg" class="d-none d-md-block" alt="Bebedero">
</div>

<div class="row g-4">

  <!-- Formulario: nuevo registro o editar (los dos roles) -->
  <div class="col-lg-3">
    <div class="caja caja-form">
      <h5 class="fw-bold mb-3"><?= !empty($registro['id_registro']) ? '✏️ Editar registro' : '➕ Registro del día' ?></h5>
      <?php if ($error): ?><div class="alert alert-danger">❌ <?= $error ?></div><?php endif; ?>
      <form method="POST" class="validar">
        <input type="hidden" name="id_registro" value="<?= $registro['id_registro'] ?? '' ?>">

        <label class="form-label">Lote</label>
        <select name="id_lote" class="form-select mb-2" required>
          <option value="">-- Elegir --</option>
          <?php foreach ($lotes as $l): ?>
            <option value="<?= $l['id_lote'] ?>" <?= ($registro['id_lote'] ?? '') == $l['id_lote'] ? 'selected' : '' ?>>
              Lote <?= $l['id_lote'] ?> - <?= $l['tipo'] ?> (<?= e($l['galpon']) ?>)
            </option>
          <?php endforeach; ?>
        </select>

        <label class="form-label">Fecha</label>
        <input type="date" name="fecha" class="form-control mb-2" value="<?= $registro['fecha'] ?? date('Y-m-d') ?>" required>

        <label class="form-label">Aves muertas</label>
        <input type="number" name="muertas" min="0" class="form-control mb-2" value="<?= $registro['muertas'] ?? 0 ?>" required>

        <label class="form-label">Alimento (kg)</label>
        <input type="number" name="alimento_kg" min="0" step="0.01" class="form-control mb-2" value="<?= $registro['alimento_kg'] ?? '' ?>" required>

        <label class="form-label">Agua (litros)</label>
        <input type="number" name="agua_litros" min="0" step="0.01" class="form-control mb-3" value="<?= $registro['agua_litros'] ?? '' ?>" required>

        <button class="btn btn-success w-100 fw-bold">Guardar</button>
        <?php if (!empty($registro['id_registro'])): ?>
          <a href="index.php?p=registro" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <div class="col-lg-9">

    <!-- Tabla de registros -->
    <div class="caja p-0 table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead>
          <tr><th>Fecha</th><th>Lote</th><th>Galpón</th><th>Muertas</th><th>Alimento (kg)</th><th>Agua (L)</th><th>Acciones</th></tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $r): ?>
            <tr>
              <td class="text-nowrap"><?= $r['fecha'] ?></td>
              <td>Lote <?= $r['id_lote'] ?> - <?= $r['tipo'] ?></td>
              <td class="text-nowrap"><?= e($r['galpon']) ?></td>
              <td><?= $r['muertas'] ?></td>
              <td><?= $r['alimento_kg'] ?></td>
              <td><?= $r['agua_litros'] ?></td>
              <td class="text-nowrap">
                <a href="index.php?p=registro&editar=<?= $r['id_registro'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <?php if (esAdmin()): ?>
                  <form method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este registro?')">
                    <button name="eliminar" value="<?= $r['id_registro'] ?>" class="btn btn-sm btn-danger">Eliminar</button>
                  </form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$registros): ?>
            <tr><td colspan="7" class="text-center text-muted py-4">Todavía no hay registros.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php require 'views/pie.php'; ?>
