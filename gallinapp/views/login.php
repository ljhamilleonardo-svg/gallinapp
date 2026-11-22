<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GallinApp - Ingresar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- ?v=5 obliga al navegador a cargar el diseño nuevo -->
  <link href="views/css/estilos.css?v=5" rel="stylesheet">
</head>
<body>
<div class="row g-0 min-vh-100">

  <!-- Lado izquierdo: foto grande -->
  <div class="col-lg-7 d-none d-lg-flex align-items-end login-foto p-5">
    <div class="text-white">
      <h1 class="display-5 fw-bold">Tu granja, en orden 🐣</h1>
      <p class="fs-5">Controla tus aves desde que ingresan hasta que se venden.</p>
      <span class="chip">🏠 Galpones</span>
      <span class="chip">🐥 Lotes</span>
      <span class="chip">📝 Registro diario</span>
      <span class="chip">💰 Ventas</span>
    </div>
  </div>

  <!-- Lado derecho: formulario -->
  <div class="col-lg-5 d-flex align-items-center justify-content-center p-4">
    <div class="caja caja-form caja-login">
      <div class="text-center mb-4">
        <img src="views/images/pollitos.jpg" class="logo-login" alt="GallinApp">
        <h3 class="fw-bold mt-3 mb-0">GallinApp</h3>
        <p class="text-muted">Ingresa con tu correo y contraseña</p>
      </div>

      <?php if (isset($_GET['creada'])): ?>
        <div class="alert alert-success">✅ Cuenta creada. Ahora ingresa con tu correo y contraseña.</div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-danger">❌ <?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <label class="form-label fw-semibold">Correo</label>
        <div class="input-group mb-3">
          <span class="input-group-text">📧</span>
          <input type="email" name="correo" class="form-control" placeholder="ejemplo@gallinapp.com" value="<?= e($_POST['correo'] ?? '') ?>" required>
        </div>

        <label class="form-label fw-semibold">Contraseña</label>
        <div class="input-group mb-4">
          <span class="input-group-text">🔒</span>
          <input type="password" name="clave" class="form-control" placeholder="Tu contraseña" required>
        </div>

        <button class="btn btn-success btn-lg w-100 fw-bold">Ingresar</button>
      </form>

      <!-- Usuarios de ejemplo para probar los dos roles -->
      <div class="ejemplo mt-4 small">
        👉 <b>Usuarios de ejemplo</b><br>
        <b>Administrador:</b> admin@gallinapp.com · admin123<br>
        <b>Usuario:</b> trabajador@gallinapp.com · trabajador123
      </div>

      <p class="text-center mt-3 mb-0">
        ¿No tienes cuenta? <a href="index.php?p=cuenta" class="fw-bold text-success">Crear cuenta</a>
      </p>
    </div>
  </div>

</div>
</body>
</html>
