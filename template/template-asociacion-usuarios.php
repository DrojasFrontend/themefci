<?php
/**
 * Template Name: Template Asociación Usuarios
 */
get_header();
$mostrar_banner_texto           = get_field('mostrar_banner_texto');
$mostrar_banner_texto_cta       = get_field('mostrar_banner_texto_cta');
$mostrar_titulo_items           = get_field('mostrar_titulo_items');
$mostrar_tabs                   = get_field('mostrar_tabs');
$mostrar_imagen_texto_boton_2   = get_field('mostrar_imagen_texto_boton_2');
$mostrar_descargas              = get_field('mostrar_descargas');
$mostrar_formulario_multistep   = get_field('mostrar_formulario_multistep');
?>

<main>
    <?php if ($mostrar_banner_texto) : ?>
        <?php get_template_part('template-parts/2025/inicio/seccion', 'banner-texto'); ?>
    <?php endif; ?>

    <?php if ($mostrar_banner_texto_cta) : ?>
        <?php get_template_part('template-parts/2025/inicio/seccion', 'imagen-texto-boton'); ?>
    <?php endif; ?>

    <?php if ($mostrar_titulo_items) : ?>
        <?php get_template_part('template-parts/2025/inicio/seccion', 'items'); ?>
    <?php endif; ?>

    <?php if ($mostrar_tabs) : ?>
        <?php get_template_part('template-parts/2025/inicio/seccion', 'tabs'); ?>
    <?php endif; ?>

    <?php if ($mostrar_imagen_texto_boton_2) : ?>
        <?php get_template_part('template-parts/2025/inicio/seccion', 'imagen-texto-boton-2'); ?>
    <?php endif; ?>

    <?php if ($mostrar_descargas) : ?>
        <?php get_template_part('template-parts/2025/inicio/seccion', 'items-descargas'); ?>
    <?php endif; ?>

    <?php get_template_part('template-parts/2025/inicio/modal/modal'); ?>

</main>

<?php get_footer(); ?>