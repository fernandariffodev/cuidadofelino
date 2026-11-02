<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main container my-5">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class('cf-article'); ?>>
            <h1 class="cf-page-title"><?php the_title(); ?></h1>
            <p class="text-muted small">Publicado el <?php echo esc_html(get_the_date()); ?></p>
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('class' => 'cf-featured')); ?>
            <?php endif; ?>
            <div class="cf-content"><?php the_content(); ?></div>
            <a class="btn btn-outline-cf mt-4" href="<?php echo esc_url(home_url('/')); ?>">&larr; Volver al inicio</a>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
