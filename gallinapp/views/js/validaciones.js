// =============================================================
// GallinApp - Validaciones en JavaScript
// Revisan los datos ANTES de enviarlos al servidor (PHP vuelve a revisar todo)
// =============================================================
document.querySelectorAll('form.validar').forEach(function (form) {
  form.addEventListener('submit', function (evento) {
    var error = '';

    // 1. Ninguna fecha puede ser mayor a hoy
    form.querySelectorAll('input[type="date"]').forEach(function (campo) {
      if (campo.value > fechaDeHoy()) error = 'La fecha no puede ser mayor a hoy.';
    });

    // 2. Ningún número puede ser negativo
    form.querySelectorAll('input[type="number"]').forEach(function (campo) {
      if (Number(campo.value) < 0) error = 'No se permiten números negativos.';
    });

    // 3. Crear cuenta: las dos contraseñas deben ser iguales
    if (form.clave2 && form.clave.value != form.clave2.value) {
      error = 'Las dos contraseñas no son iguales.';
    }

    // Si hay un error: NO se envía el formulario y se muestra en rojo
    if (error != '') {
      evento.preventDefault();
      form.querySelector('.alert')?.remove();
      form.insertAdjacentHTML('afterbegin', '<div class="alert alert-danger">❌ ' + error + '</div>');
    }
  });
});

// Fecha de hoy en formato año-mes-día (2026-11-22)
function fechaDeHoy() {
  var d = new Date();
  return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
}
