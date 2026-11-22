<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GallinApp - Crear cuenta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="views/css/estilos.css?v=5" rel="stylesheet">
</head>
<body>
<div class="row g-0 min-vh-100">

  <!-- Lado izquierdo: foto grande -->
  <div class="col-lg-7 d-none d-lg-flex align-items-end registro-foto p-5">
    <div class="text-white">
      <h1 class="display-5 fw-bold">Únete a GallinApp 🐔</h1>
      <p class="fs-5 mb-0">Crea tu cuenta y empieza a registrar tu granja.</p>
    </div>
  </div>

  <!-- Lado derecho: formulario de registro -->
  <div class="col-lg-5 d-flex align-items-center justify-content-center p-4">
    <div class="caja caja-form caja-login">
      <div class="text-center mb-4">
        <img src="views/images/gallinas.jpg" class="logo-login" alt="GallinApp">
        <h3 class="fw-bold mt-3 mb-0">Crear cuenta</h3>
        <p class="text-muted">Llena tus datos para registrarte</p>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-danger">❌ <?= $error ?></div>
      <?php endif; ?>

      <form method="POST" class="validar">
        <label class="form-label fw-semibold">Nombre completo</label>
        <div class="input-group mb-3">
          <span class="input-group-text">👤</span>
          <input name="nombre" class="form-control" placeholder="Ej: Juan Pérez" value="<?= e($_POST['nombre'] ?? '') ?>" required>
        </div>

        <label class="form-label fw-semibold">Correo</label>
        <div class="input-group mb-3">
          <span class="input-group-text">📧</span>
          <input type="email" name="correo" class="form-control" placeholder="Ej: juan@gmail.com" value="<?= e($_POST['correo'] ?? '') ?>" required>
        </div>

        <label class="form-label fw-semibold">Contraseña</label>
        <div class="input-group mb-3">
          <span class="input-group-text">🔒</span>
          <input type="password" name="clave" minlength="6" class="form-control" placeholder="Mínimo 6 letras o números" required>
        </div>

        <label class="form-label fw-semibold">Repite la contraseña</label>
        <div class="input-group mb-4">
          <span class="input-group-text">🔒</span>
          <input type="password" name="clave2" minlength="6" class="form-control" placeholder="Escríbela otra vez" required>
        </div>

        <button class="btn btn-success btn-lg w-100 fw-bold">Crear cuenta</button>
      </form>

      <p class="small text-muted text-center mt-3 mb-1">Las cuentas nuevas tienen el rol <b>Usuario</b>.</p>
      <p class="text-center mb-0">
        ¿Ya tienes cuenta? <a href="index.php" class="fw-bold text-success">Ingresar</a>
      </p>
    </div>
  </div>

</div>
<!-- Validaciones en JavaScript -->
<script src="views/js/validaciones.js?v=5"></script>
</body>
</html>
