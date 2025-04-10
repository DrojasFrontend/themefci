<?php
/**
 * Template Name: Template Inicio
 */
get_header();
?>

<main>
  <?php get_template_part('template-parts/2025/inicio/seccion', 'slider'); ?>
  <?php get_template_part('template-parts/2025/inicio/seccion', 'tarjeta'); ?>
  <?php get_template_part('template-parts/2025/inicio/seccion', 'buscador'); ?>
  <?php get_template_part('template-parts/2025/inicio/seccion', 'sedes'); ?>
  <?php get_template_part('template-parts/2025/inicio/seccion', 'imagen-texto-items'); ?>
  <?php get_template_part('template-parts/2025/inicio/seccion', 'tarjetas-grandes'); ?>
  <?php get_template_part('template-parts/2025/inicio/seccion', 'slider-alianzas'); ?>
  <?php get_template_part('template-parts/2025/inicio/seccion', 'agenda'); ?>
  <?php get_template_part('template-parts/2025/inicio/seccion', 'banner'); ?>
</main>

<?php get_footer(); ?>