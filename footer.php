<?php defined('ABSPATH') || exit; ?>

<footer class="cf-footer mt-5 py-4">
    <div class="container text-center">
        <p class="mb-1"><?php echo esc_html(get_bloginfo('name')); ?></p>
        <p class="small mb-0">Desarrollado por Fernanda Riffo &middot; <?php echo esc_html(date_i18n('Y')); ?></p>
    </div>
</footer>

<button type="button" id="cf-subir" class="btn btn-cf cf-subir" aria-label="Volver arriba" hidden>&uarr;</button>

<?php wp_footer(); ?>
</body>
</html>
