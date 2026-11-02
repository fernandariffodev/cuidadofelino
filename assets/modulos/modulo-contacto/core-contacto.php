<?php
defined('ABSPATH') || exit;

/*
 * Módulo de contacto: procesa el formulario de page-contacto.php.
 * Medidas: nonce, campo trampa (honeypot), sanitización, validación,
 * límite de un envío por minuto y sin guardar datos en la base de datos.
 */

function cf_motivos_contacto() {
    return array(
        'consulta'   => 'Consulta sobre una guía',
        'sugerencia' => 'Sugerencia de contenido',
        'otro'       => 'Otro motivo',
    );
}

function cf_redirigir_contacto($estado) {
    $volver = wp_get_referer();
    if (!$volver) {
        $volver = home_url('/');
    }
    $volver = remove_query_arg('cf_estado', $volver);
    wp_safe_redirect(add_query_arg('cf_estado', $estado, $volver));
    exit;
}

function cf_procesar_contacto() {

    // 1. Verificar el nonce (protege contra envíos falsificados, CSRF).
    $nonce = isset($_POST['cf_contacto_nonce']) ? sanitize_text_field(wp_unslash($_POST['cf_contacto_nonce'])) : '';
    if (!wp_verify_nonce($nonce, 'cf_contacto')) {
        cf_redirigir_contacto('invalido');
    }

    // 2. Campo trampa: los bots lo llenan, las personas no lo ven.
    if (!empty($_POST['cf_web'])) {
        cf_redirigir_contacto('ok');
    }

    // 3. Sanitizar cada campo según su tipo.
    $nombre  = isset($_POST['cf_nombre'])  ? sanitize_text_field(wp_unslash($_POST['cf_nombre']))        : '';
    $correo  = isset($_POST['cf_correo'])  ? sanitize_email(wp_unslash($_POST['cf_correo']))             : '';
    $motivo  = isset($_POST['cf_motivo'])  ? sanitize_key(wp_unslash($_POST['cf_motivo']))               : '';
    $mensaje = isset($_POST['cf_mensaje']) ? sanitize_textarea_field(wp_unslash($_POST['cf_mensaje']))   : '';
    $acepta  = !empty($_POST['cf_acepta']);

    // 4. Validar en el servidor (la validación del navegador no basta).
    $motivos = cf_motivos_contacto();
    $largo   = mb_strlen($mensaje);

    if ($nombre === '' || !is_email($correo) || !isset($motivos[$motivo]) || $largo < 10 || $largo > 1000 || !$acepta) {
        cf_redirigir_contacto('invalido');
    }

    // 5. Límite simple: un envío por minuto por visitante (se guarda solo un hash, no la IP).
    $ip    = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
    $clave = 'cf_contacto_' . md5($ip);
    if (get_transient($clave)) {
        cf_redirigir_contacto('espera');
    }

    // 6. Enviar el correo al administrador del sitio.
    $asunto  = '[' . get_bloginfo('name') . '] ' . $motivos[$motivo];
    $cuerpo  = "Nombre: " . $nombre . "\n";
    $cuerpo .= "Correo: " . $correo . "\n";
    $cuerpo .= "Motivo: " . $motivos[$motivo] . "\n\n";
    $cuerpo .= $mensaje . "\n";
    $headers = array('Reply-To: ' . $nombre . ' <' . $correo . '>');

    $enviado = wp_mail(get_option('admin_email'), $asunto, $cuerpo, $headers);

    if ($enviado) {
        set_transient($clave, 1, MINUTE_IN_SECONDS);
        cf_redirigir_contacto('ok');
    }
    cf_redirigir_contacto('error');
}
add_action('admin_post_nopriv_cf_contacto', 'cf_procesar_contacto'); // visitantes
add_action('admin_post_cf_contacto', 'cf_procesar_contacto');        // usuarios con sesión
