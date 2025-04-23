<?php
/**
 * Template Name: Template Laboratorio Clinico
 */
get_header();
?>

<main>
    <?php get_template_part('template-parts/breadcrumb/seccion', 'breadcrumb', array('class' => '') );?>
    <section class="customSecionLaboratorioClinico">
        <div class="customBuscadorTecla pt-48 gradient-1 mt-12">
            <div class="customContainer">
                <h2 class="font-fira-sans fs-1">Laboratorio Clinico</h2>
                <div class="row d-flex flex-lg-row flex-column-reverse">
                    <div class="col-12 col-lg-6">
                        <div class="d-flex flex-column justify-content-center h-100 pr-lg-100">
                            <p class="font-sans fs-p mb-12 fw-normal">Encuentra el exámen que estás buscando y descubre como prepararte.</p>
                            <div class="d-flex align-items-center mb-3">
                                <div class="position-relative flex-grow-1">
                                    <i class="position-absolute customIcono customIconoSearch"></i>
                                    <input type="text" id="buscar-laboratorio-clinico" placeholder="Escribe el nombre del examen">
                                </div>
                                <button id="boton-buscar" class="customButton customButton-blue font-sans">Buscar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-30">
                        <p class="font-sans fs-p mb-30">Encuentra la exámen que necesitas según la <strong>letra inicial</strong></p>
                        <div class="d-flex flex-wrap gap-12">
                        <?php
                        
                            $letras = range('A', 'Z');
                            foreach ($letras as $letra) {
                            echo '<button class="letra-btn font-sans fs-p fw-semibold color--002D72" data-letra="' . $letra . '">' . $letra . '</button> ';
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contenedor para resultados de búsqueda -->
        <div id="resultados-laboratorios" class="customContainer mt-48 mb-48"></div>
    </section>
    
</main>

<?php get_footer(); ?>