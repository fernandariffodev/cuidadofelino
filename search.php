<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main container my-5">

    <header class="mb-4">
        <h1 class="cf-page-title">
            Resultados para: <span class="text-cf"><?php echo esc_html(get_search_query()); ?></span>
        </h1>
        <?php if (have_posts()) : ?>
            <p class="text-muted">
                <?php
                global $wp_query;
                echo esc_html(sprintf(
                    _n('%d resultado encontrado.', '%d resultados encontrados.', (int) $wp_query->found_posts, 'cuidado-felino'),
                    (int) $wp_query->found_posts
                ));
                ?>
            </p>
        <?php endif; ?>
    </header>

    <?php if (have_posts()) : ?>
        <div class="row g-4">
            <?php while (have_posts()) : the_post(); ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <?php get_template_part('template-parts/card'); ?>
                </div>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <div class="alert alert-warning" role="alert">
            No encontramos resultados. Prueba con otra palabra, por ejemplo "agua", "juego" o "veterinario".
        </div>
        <div class="my-4 cf-narrow">
            <?php get_search_form(); ?>
        </div>
        <a class="btn btn-outline-cf" href="<?php echo esc_url(get_post_type_archive_link('guias')); ?>">Ver todas las guías</a>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
