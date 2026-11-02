<?php
defined('ABSPATH') || exit;

/*
 * Medidas de seguridad a nivel de tema.
 * (Las de servidor, como permisos de archivo o DISALLOW_FILE_EDIT, van en wp-config.php y el hosting.)
 */

// 1. No mostrar la versión de WordPress.
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

// 2. Desactivar XML-RPC (vía de ataques de fuerza bruta que este sitio no usa).
add_filter('xmlrpc_enabled', '__return_false');

// 3. Mensaje de error de login genérico: no revela si falló el usuario o la contraseña.
function cf_login_error_generico() {
    return 'Los datos de acceso no son correctos.';
}
add_filter('login_errors', 'cf_login_error_generico');

// 4. Evitar que se descubran nombres de usuario con ?author=1.
function cf_bloquear_enumeracion_autores() {
    if (!is_user_logged_in() && isset($_GET['author'])) {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
}
add_action('template_redirect', 'cf_bloquear_enumeracion_autores');

// 5. Ocultar la lista de usuarios en la API REST para visitantes.
function cf_ocultar_usuarios_rest($endpoints) {
    if (!is_user_logged_in()) {
        unset($endpoints['/wp/v2/users']);
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
}
add_filter('rest_endpoints', 'cf_ocultar_usuarios_rest');

// 6. Cabeceras HTTP de protección.
function cf_cabeceras_seguridad() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}
add_action('send_headers', 'cf_cabeceras_seguridad');

// 7. Integridad (SRI) de los archivos de Bootstrap cargados desde el CDN:
//    si alguien los alterara, el navegador los bloquearía.
function cf_agregar_sri($etiqueta, $handle) {
    $sri = array(
        'bootstrap'        => 'sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH',
        'bootstrap-bundle' => 'sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz',
    );
    if (isset($sri[$handle])) {
        $atributos = ' integrity="' . esc_attr($sri[$handle]) . '" crossorigin="anonymous"';
        $etiqueta  = preg_replace('/^(\s*<(?:link|script))/', '$1' . $atributos, $etiqueta, 1);
    }
    return $etiqueta;
}
add_filter('style_loader_tag', 'cf_agregar_sri', 10, 2);
add_filter('script_loader_tag', 'cf_agregar_sri', 10, 2);
