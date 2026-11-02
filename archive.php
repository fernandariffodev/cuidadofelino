<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main container my-5">

    <header class="mb-4">
        <?php the_archive_title('<h1 class="cf-page-title">', '</h1>'); ?>
        <?php the_archive_description('<div class="text-muted">', '</div>'); ?>
    </header>

    <?php
    if (is_post_type_archive('guias') || is_tax('tipo_cuidado')) :
        $tipos = get_terms(array(
            'taxonomy'   => 'tipo_cuidado',
            'hide_empty' => false,
        ));
        if (!is_wp_error($tipos) && !empty($tipos)) : ?>
            <div class="cf-pills">
                <a class="btn btn-outline-cf btn-sm" href="<?php echo esc_url(get_post_type_archive_link('guias')); ?>">Todas</a>
                <?php foreach ($tipos as $tipo) : ?>
                    <a class="btn btn-outline-cf btn-sm" href="<?php echo esc_url(get_term_link($tipo)); ?>"><?php echo esc_html($tipo->name); ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif;
    endif; ?>

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
        <p class="text-center">Oops!, Lo sentimos, no hay contenido que mostrar</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
