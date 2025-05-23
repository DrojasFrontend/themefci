<?php
/**
 * Template Name: Plantilla Procedimientos
 * 
 * @package FCITheme
 * @subpackage Legger_Templates
 * @version 1.0
 * @author Legger
 * @link https://legger.com
 * 
 * This template is part of the custom development by Legger.
 * Template for the Revascularizacion page.
 */


// Asegúrate de que no se acceda directamente a este archivo
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}
get_header(); 

$mostrar_hero = get_field('mostrar_hero');
$mostrar_info = get_field('mostrar_info');
?>
  <!-- CONTENIDO -->
    <main>

      <?php if($mostrar_hero) : ?>
        <!-- Hero -->
        <?php get_template_part('template-parts/procedimientos/seccion', 'hero' );?>
        <!-- Fin Hero -->
      <?php endif; ?>

      <?php if($mostrar_info) : ?>
        <!-- Hero -->
        <?php get_template_part('template-parts/procedimientos/seccion', 'filtro' );?>
        <!-- Fin Hero -->
      <?php endif; ?>

      <?php get_template_part('template-parts/especialidades/seccion', 'flotante-contacto');?>

    </main>
  <!-- FIN CONTENIDO -->
<?php get_footer();