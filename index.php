<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main container my-5">

    <?php if (is_home() && !is_front_page()) : ?>
        <h1 class="cf-page-title">Blog</h1>
    <?php endif; ?>

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
