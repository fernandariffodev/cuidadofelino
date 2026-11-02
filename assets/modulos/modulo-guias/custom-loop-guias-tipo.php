<?php
defined('ABSPATH') || exit;

/*
 * Bucle personalizado: muestra las guías de UN término de la taxonomía "tipo_cuidado".
 * Recibe el slug del término en $termino_loop (lo define front-page.php).
 */
if (!isset($termino_loop) || !is_string($termino_loop) || $termino_loop === '') {
    $termino_loop = 'alimentacion';
}

$cf_consulta = new WP_Query(array(
    'post_type'      => 'guias',
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'posts_per_page' => -1,
    'no_found_rows'  => true, // no hay paginación: evita un COUNT innecesario
    'tax_query'      => array(
        array(
            'taxonomy' => 'tipo_cuidado',
            'field'    => 'slug',
            'terms'    => $termino_loop,
        ),
    ),
));

if ($cf_consulta->have_posts()) : ?>

    <div class="row g-4">
        <?php while ($cf_consulta->have_posts()) : $cf_consulta->the_post(); ?>
            <div class="col-12 col-md-6 col-lg-4">
                <?php get_template_part('template-parts/card'); ?>
            </div>
        <?php endwhile; ?>
    </div>

<?php else : ?>

    <p class="text-center">Aún no hay guías en esta categoría.</p>

<?php endif;

wp_reset_postdata();
