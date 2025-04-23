<?php
    $sitename   = get_bloginfo('name');
    $homeurl    = get_home_url();
    $logo_id    = get_theme_mod('custom_logo');
    $logo       = wp_get_attachment_image_src($logo_id, 'full');
?>
<div class="customModal d-none pb-84" data-modal-formulario>
    <div class="position-sticky top-0 w-100 bg-white">
        <div class="customContainer px-0">
            <div class="customModal__header bg-white d-flex justify-content-lg-between justify-content-center align-items-center w-100 px-24">
                <div class="d-flex align-items-center">
                    <!-- Logo -->
                    <a href="<?php echo esc_url($homeurl) ?>">
                        <?php if ($logo) { ?>
                            <img src="<?php echo esc_url($logo[0]) ?>" alt="Logo <?php echo esc_attr($sitename) ?>" width="127" height="46" />
                        <?php } ?>
                    </a>
                    <p class="font-sans fs-p color-080808">Inscripción a la Asociación de Usuarios</p>
                </div>
                <div class="d-none d-lg-block">
                    <button type="button" class="customModal__close customButton customButton-white " data-modal-formulario-salir>
                        Salir del formulario
                        <img src="http://lacardio.local/wp-content/uploads/2025/04/icono-salir.svg" alt="" title="icono salir">
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="customContainer px-0">
        <?php get_template_part('template-parts/2025/inicio/seccion', 'imagen-texto-boton-3'); ?>
        <?php get_template_part('template-parts/2025/inicio/formularios/formulario', 'asociacion-usuarios'); ?>
        <?php get_template_part('template-parts/2025/inicio/modal/seccion', 'gracias'); ?>
    </div>
</div>