# Cuidado Felino

Tema de WordPress hecho desde cero para un sitio de guías prácticas sobre el cuidado de gatos, desarrollado para una asignatura de la carrera de Desarrollo y Diseño Web (Duoc UC).

**Sitio en vivo:** https://fernriffor.laboratoriodiseno.cl/cuidadofelino/

## Funcionalidades

- Custom Post Type **Guías** y taxonomía **Tipos de cuidado** (alimentación, salud, juego y enriquecimiento).
- Portada con un bucle `WP_Query` + `tax_query` que se repite por cada tipo de cuidado.
- Campos personalizados con ACF definidos en código (tiempo de lectura, nivel y consejo rápido). Si ACF no está activo, el sitio sigue funcionando.
- Buscador de guías y páginas de archivo, etiqueta y detalle.
- Formulario de contacto con nonce, sanitización y validación.
- Contenido inicial que se carga al activar el tema.
- Medidas de seguridad a nivel de tema: oculta la versión de WordPress, desactiva XML-RPC, usa errores de login genéricos, bloquea la enumeración de autores, oculta usuarios en la API REST, agrega cabeceras HTTP de protección y SRI para Bootstrap.

## Tecnologías

- WordPress (tema clásico en PHP)
- Bootstrap 5.3.3
- CSS con variables nativas
- JavaScript
- Advanced Custom Fields (ACF)

## Estructura

```
cuidado-felino/
├── functions.php           # Punto de entrada: carga assets/assets.php
├── style.css               # Cabecera del tema y estilos
├── front-page.php, archive.php, single-guias.php, page-*.php, search.php ...
├── template-parts/card.php # Tarjeta de guía reutilizable
└── assets/
    ├── assets.php          # Incluye los archivos de assets/inc
    ├── inc/                # CSS, JS, menús, CPT, páginas, imágenes, contenido inicial y seguridad
    ├── modulos/            # Guías (CPT y bucle), ACF y formulario de contacto
    ├── js/main.js
    └── img/
```

## Instalación

1. Copiar esta carpeta en `wp-content/themes/cuidado-felino`.
2. Instalar y activar el plugin **Advanced Custom Fields**.
3. Activar el tema desde *Apariencia → Temas*. Al activarlo se crea el contenido de ejemplo.

## Autoría

Desarrollado por Fernanda Riffo.
