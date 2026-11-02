<?php
defined('ABSPATH') || exit;

/*
 * MAPA DEL TEMA (dónde está cada cosa)
 *
 * functions.php -> assets/assets.php -> assets/inc/*.php
 *
 *  - CPT "guias" y taxonomía "tipo_cuidado":
 *      assets/inc/custom-post-type.php -> assets/modulos/modulo-guias/core-guias.php
 *      (register_post_type y register_taxonomy; las etiquetas se activan con 'taxonomies' => post_tag)
 *  - Bucle WP_Query + tax_query (se repite una vez por término en la portada):
 *      assets/modulos/modulo-guias/custom-loop-guias-tipo.php, incluido desde front-page.php
 *  - Campos ACF (tiempo_lectura, nivel, consejo_rapido): assets/modulos/modulo-acf/core-acf.php
 *  - Formulario de contacto (nonce y sanitización): assets/modulos/modulo-contacto/core-contacto.php
 *  - Seguridad del tema: assets/inc/seguridad-functions.php
 *  - Estilos y scripts: assets/inc/css-functions.php, assets/inc/js-functions.php, style.css, assets/js/main.js
 */

function cuidado_felino_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'cuidado_felino_setup');

include get_template_directory() . '/assets/assets.php';
