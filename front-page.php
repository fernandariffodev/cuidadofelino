<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main">

    <section class="cf-hero">
        <div class="container">
            <h1 class="mb-3">Cuidado Felino</h1>
            <p class="lead mb-4">Guías prácticas para que tu gato viva sano, tranquilo y feliz: alimentación, salud y juego en un solo lugar.</p>
            <a class="btn btn-cf" href="#guias">Ver guías</a>
        </div>
    </section>

    <section class="container mt-5" id="guias">
        <h2 class="cf-section-title">Guías por tipo de cuidado</h2>
        <p class="text-muted mb-4">Elige el tema que más te interesa.</p>
    </section>

    <?php
    // Los términos se leen desde la base de datos: si se agrega uno nuevo, aparece solo.
    $tipos = get_terms(array(
        'taxonomy'   => 'tipo_cuidado',
        'hide_empty' => true,
        'orderby'    => 'term_id',
        'order'      => 'ASC',
    ));

    if (!is_wp_error($tipos) && !empty($tipos)) :
        foreach ($tipos as $tipo) :
            $termino_loop = $tipo->slug; ?>

            <section class="container mb-5">
                <h3 class="cf-term-title">
                    <span><?php echo esc_html($tipo->name); ?></span>
                    <?php
                    $enlace_termino = get_term_link($tipo);
                    if (!is_wp_error($enlace_termino)) : ?>
                        <a class="btn btn-outline-cf btn-sm" href="<?php echo esc_url($enlace_termino); ?>">Ver todas</a>
                    <?php endif; ?>
                </h3>
                <?php include get_template_directory() . '/assets/modulos/modulo-guias/custom-loop-guias-tipo.php'; ?>
            </section>

        <?php endforeach;
    else : ?>
        <section class="container mb-5">
            <p class="text-center">Aún no hay guías publicadas.</p>
        </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
