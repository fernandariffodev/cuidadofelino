<?php
defined('ABSPATH') || exit;

get_header();

// Resultado del envío (lista blanca: solo estos valores se muestran).
$estado   = isset($_GET['cf_estado']) ? sanitize_key(wp_unslash($_GET['cf_estado'])) : '';
$avisos   = array(
    'ok'       => array('success', 'Gracias, recibimos tu mensaje. Te responderemos pronto.'),
    'error'    => array('danger',  'No pudimos enviar el mensaje. Inténtalo de nuevo más tarde.'),
    'invalido' => array('warning', 'Revisa los campos del formulario e inténtalo otra vez.'),
    'espera'   => array('warning', 'Ya enviaste un mensaje hace un momento. Espera un minuto para enviar otro.'),
);
?>

<main id="primary" class="site-main container my-5">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class('cf-article'); ?>>
            <h1 class="cf-page-title"><?php the_title(); ?></h1>
            <div class="cf-content mb-4"><?php the_content(); ?></div>

            <?php if (isset($avisos[$estado])) : ?>
                <div class="alert alert-<?php echo esc_attr($avisos[$estado][0]); ?>" role="alert">
                    <?php echo esc_html($avisos[$estado][1]); ?>
                </div>
            <?php endif; ?>

            <form class="cf-form needs-validation" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate>
                <input type="hidden" name="action" value="cf_contacto">
                <?php wp_nonce_field('cf_contacto', 'cf_contacto_nonce'); ?>

                <div class="d-none" aria-hidden="true">
                    <label for="cf-web">No completar este campo</label>
                    <input type="text" id="cf-web" name="cf_web" tabindex="-1" autocomplete="off">
                </div>

                <div class="mb-3">
                    <label for="cf-nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="cf-nombre" name="cf_nombre" maxlength="80" required>
                    <div class="invalid-feedback">Escribe tu nombre.</div>
                </div>

                <div class="mb-3">
                    <label for="cf-correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="cf-correo" name="cf_correo" maxlength="100" required>
                    <div class="invalid-feedback">Escribe un correo válido.</div>
                </div>

                <div class="mb-3">
                    <label for="cf-motivo" class="form-label">Motivo</label>
                    <select class="form-select" id="cf-motivo" name="cf_motivo" required>
                        <option value="" selected disabled>Selecciona una opción</option>
                        <?php foreach (cf_motivos_contacto() as $valor => $texto) : ?>
                            <option value="<?php echo esc_attr($valor); ?>"><?php echo esc_html($texto); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Elige un motivo.</div>
                </div>

                <div class="mb-3">
                    <label for="cf-mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="cf-mensaje" name="cf_mensaje" rows="5" minlength="10" maxlength="1000" data-cf-contador="cf-contador" required></textarea>
                    <div class="form-text text-end" id="cf-contador">0 / 1000</div>
                    <div class="invalid-feedback">Escribe un mensaje de al menos 10 caracteres.</div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="cf-acepta" name="cf_acepta" value="1" required>
                    <label class="form-check-label" for="cf-acepta">
                        Acepto que usen mis datos solo para responder este mensaje. No se guardan en el sitio.
                    </label>
                    <div class="invalid-feedback">Debes aceptar para enviar el formulario.</div>
                </div>

                <button type="submit" class="btn btn-cf">Enviar mensaje</button>
            </form>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
