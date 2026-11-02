/*
 * Cuidado Felino - JavaScript del tema
 * 1. Validación de formularios con clases de Bootstrap
 * 2. Contador de caracteres del mensaje
 * 3. Filtro rápido de la tabla de guías
 * 4. Botón "volver arriba"
 */
(function () {
    'use strict';

    // 1. Validación: no deja enviar el formulario si algún campo no cumple.
    var formularios = document.querySelectorAll('.needs-validation');
    Array.prototype.forEach.call(formularios, function (formulario) {
        formulario.addEventListener('submit', function (evento) {
            if (!formulario.checkValidity()) {
                evento.preventDefault();
                evento.stopPropagation();
            }
            formulario.classList.add('was-validated');
        }, false);
    });

    // 2. Contador de caracteres (el textarea indica el id del contador en data-cf-contador).
    var area = document.querySelector('[data-cf-contador]');
    if (area) {
        var salida = document.getElementById(area.getAttribute('data-cf-contador'));
        var maximo = area.getAttribute('maxlength');
        var actualizarContador = function () {
            if (salida) {
                salida.textContent = area.value.length + ' / ' + maximo;
            }
        };
        area.addEventListener('input', actualizarContador);
        actualizarContador();
    }

    // 3. Filtro de tabla: oculta las filas que no contienen el texto escrito.
    var filtro = document.getElementById('cf-filtro-tabla');
    var filas = document.querySelectorAll('#cf-tabla-guias tbody tr');
    if (filtro && filas.length) {
        filtro.addEventListener('input', function () {
            var texto = filtro.value.trim().toLowerCase();
            Array.prototype.forEach.call(filas, function (fila) {
                var coincide = fila.textContent.toLowerCase().indexOf(texto) !== -1;
                fila.hidden = !coincide;
            });
        });
    }

    // 4. Botón "volver arriba": aparece al bajar y sube suavemente.
    var botonSubir = document.getElementById('cf-subir');
    if (botonSubir) {
        window.addEventListener('scroll', function () {
            botonSubir.hidden = window.scrollY < 400;
        });
        botonSubir.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
})();
