<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main container my-5 text-center">
    <h1 class="cf-page-title">Página no encontrada</h1>
    <p class="lead">Parece que esta página se escondió como un gato.</p>
    <a class="btn btn-cf" href="<?php echo esc_url(home_url('/')); ?>">Volver al inicio</a>
</main>

<?php get_footer(); ?>
