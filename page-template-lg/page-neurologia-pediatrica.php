<?php
/* 
Template Name: Plantilla Especialidad | Neurología Pediatrica
*/ 

get_header();

$mostrar_breadcrumb                   = get_field('mostrar_breadcrumb');
$mostrar_hero               = get_field('mostrar_hero');
$mostrar_texto_imagen_cta   = get_field('mostrar_texto_imagen_cta');
$mostrar_bloque_texto       = get_field('mostrar_bloque_texto');
$mostrar_texto_desc_banner  = get_field('mostrar_texto_desc_banner');
$mostrar_lista_numerada     = get_field('mostrar_lista_numerada');
$mostrar_items_iconos       = get_field('mostrar_items_iconos');
$mostrar_texto_imagen_cta_2 = get_field('mostrar_texto_imagen_cta_2');
$mostrar_texto_imagen_fondo = get_field('mostrar_texto_imagen_fondo');
$mostrar_targetas_grid      = get_field('mostrar_targetas_grid');
$mostrar_experto            = get_field('mostrar_experto');
$mostrar_ctas               = get_field('mostrar_ctas');
$mostrar_acordion           = get_field('mostrar_acordion');

?>
<!-- CONTENIDO -->
  <main class="paginaEtapaExpecialidades">
	  
	  <?php if($mostrar_breadcrumb) : ?>
    <!-- BreadCrumb -->
    <?php get_template_part('template-parts/breadcrumb/seccion', 'breadcrumb', array('class' => '') );?>
    <!-- Fin BreadCrumb -->
<?php endif; ?>
	  
    <?php if($mostrar_hero) : ?>
      <!-- Hero -->
        <?php get_template_part('template-parts/especialidades/seccion', 'hero' );?>
      <!-- Fin Hero -->
    <?php endif; ?>

    <?php if($mostrar_texto_imagen_cta) : ?>
      <!-- Texto Imagen CTA -->
        <?php get_template_part('template-parts/especialidades/seccion', 'texto-imagen-cta', array('class' => 'paginaNeurologiaPediatrica'));?>
      <!-- Fin Texto Imagen CTA -->
    <?php endif; ?>

    <?php if($mostrar_bloque_texto) : ?>
      <!-- Bloque Texto -->
      <?php get_template_part('template-parts/especialidades/seccion', 'bloque-texto', array('class' => '') );?>
      <!-- Fin Bloque Texto -->
    <?php endif; ?>

    <?php if($mostrar_texto_desc_banner) : ?>
      <!-- Texto Descripcion Banner -->
        <?php get_template_part('template-parts/especialidades/seccion', 'texto-desc-banner');?>
      <!-- Fin Texto Descripcion Banner -->
    <?php endif; ?>

    <?php if($mostrar_lista_numerada) : ?>
      <!-- Lista Numerada -->
        <?php get_template_part('template-parts/especialidades/seccion', 'lista-numerada', array('class' => 'paginaNeurologiaPediatrica'));?>
      <!-- Fin Lista Numerada -->
    <?php endif; ?>

    <?php if($mostrar_items_iconos) : ?>
      <!-- Items Iconos -->
        <?php get_template_part('template-parts/especialidades/seccion', 'items-iconos');?>
      <!-- Fin Items Iconos -->
    <?php endif; ?>

    <?php if($mostrar_texto_imagen_cta_2) : ?>
      <!-- Texto Imagen 2 -->
        <?php get_template_part('template-parts/especialidades/seccion', 'texto-imagen-cta-2' );?>
      <!-- Fin Texto Imagen 2 -->
    <?php endif; ?>

    <?php if($mostrar_texto_imagen_fondo) : ?>
      <!-- Texto Imagen Fondo -->
        <?php get_template_part('template-parts/especialidades/seccion', 'texto-imagen-fondo-cta');?>
      <!-- Fin Texto Imagen Fondo -->
    <?php endif; ?>

    <?php if($mostrar_targetas_grid) : ?>
      <!-- Targetas Grid -->
        <?php get_template_part('template-parts/especialidades/seccion', 'targetas-grid');?>
      <!-- Fin Targetas Grid -->
    <?php endif; ?>

    <?php if($mostrar_experto) : ?>
      <!-- Experto -->
        <?php get_template_part('template-parts/especialidades/seccion', 'expertos', array("class" => "marginTop"));?>
      <!-- Fin Experto -->
    <?php endif; ?>

    <?php if($mostrar_ctas) : ?>
      <!-- CTAS -->
        <?php get_template_part('template-parts/especialidades/seccion', 'ctas');?>
      <!-- Fin CTAS -->
    <?php endif; ?>

    <?php if($mostrar_acordion) : ?>
      <!-- Accordion -->
    <?php get_template_part('template-parts/especialidades/seccion', 'accordion');?>
    <!-- Fin Accordion -->
    <?php endif; ?>

    <?php get_template_part('template-parts/especialidades/seccion', 'flotante-contacto');?>
  </main>
<!-- CONTENIDO -->

<?php get_footer(); ?>




