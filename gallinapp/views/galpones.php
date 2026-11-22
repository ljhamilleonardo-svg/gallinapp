<?php require 'views/menu.php'; ?>

<div class="cabecera d-flex justify-content-between align-items-center">
  <div>
    <h2 class="fw-bold">🏠 Galpones</h2>
    <p class="mb-0">Dónde viven las aves y cuántas caben en cada uno.</p>
  </div>
  <img src="views/images/galpon.jpg" class="d-none d-md-block" alt="Galpón">
</div>

<div class="row g-4">

  <!-- Formulario: nuevo galpón o editar -->
  <div class="col-lg-3">
    <div class="caja caja-form">
      <h5 class="fw-bold mb-3"><?= !empty($galpon['id_galpon']) ? '✏️ Editar galpón' : '➕ Nuevo galpón' ?></h5>
      <?php if ($error): ?><div class="alert alert-danger">❌ <?= $error ?></div><?php endif; ?>
      <form method="POST" class="validar">
        <input type="hidden" name="id_galpon" value="<?= $galpon['id_galpon'] ?? '' ?>">

        <label class="form-label">Nombre</label>
        <input name="nombre" class="form-control mb-2" value="<?= e($galpon['nombre'] ?? '') ?>" placeholder="Galpón 4" required>

        <label class="form-label">¿Cuántas aves caben?</label>
        <input type="number" name="capacidad" min="1" class="form-control mb-3" value="<?= $galpon['capacidad'] ?? '' ?>" required>

        <button class="btn btn-success w-100 fw-bold">Guardar</button>
        <?php if (!empty($galpon['id_galpon'])): ?>
          <a href="index.php?p=galpon" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <!-- Tabla de galpones -->
  <div class="col-lg-9">
    <div class="caja p-0 table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead>
          <tr><th>N°</th><th>Galpón</th><th>Capacidad</th><th>Aves vivas</th><th>Ocupación</th><th>Acciones</th></tr>
        </thead>
        <tbody>
          <?php foreach ($galpones as $g): ?>
            <?php $ocupado = round($g['vivas'] * 100 / $g['capacidad']); ?>
            <tr>
              <td><?= $g['id_galpon'] ?></td>
              <td><?= e($g['nombre']) ?></td>
              <td><?= $g['capacidad'] ?></td>
              <td><?= $g['vivas'] ?></td>
              <td style="width: 22%">
                <div class="progress" style="height: 20px">
                  <div class="progress-bar <?= $ocupado > 100 ? 'bg-danger' : 'bg-success' ?>" style="width: <?= min($ocupado, 100) ?>%"><?= $ocupado ?>%</div>
                </div>
              </td>
              <td class="text-nowrap">
                <a href="index.php?p=lote&id_galpon=<?= $g['id_galpon'] ?>" class="btn btn-sm btn-info text-white">Ver lotes</a>
                <a href="index.php?p=galpon&editar=<?= $g['id_galpon'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este galpón? También se borrarán sus lotes.')">
                  <button name="eliminar" value="<?= $g['id_galpon'] ?>" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php require 'views/pie.php'; ?>
