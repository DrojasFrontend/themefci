<?php 
$grupo_modal_formulario     = get_field('grupo_modal_formulario');
$titulo                     = !empty($grupo_modal_formulario['titulo']) ? esc_html($grupo_modal_formulario['titulo']) : '';
$descripcion                = !empty($grupo_modal_formulario['descripcion']) ? $grupo_modal_formulario['descripcion'] : '';
$imagen                     = !empty($grupo_modal_formulario['imagen']['ID']) ? $grupo_modal_formulario['imagen']['ID'] : '';
$cta                        = !empty($grupo_modal_formulario['cta']) ? $grupo_modal_formulario['cta'] : '';
$cta_url                    = !empty($cta['url']) ? esc_url($cta['url']) : '';
$cta_title                  = !empty($cta['title']) ? esc_html($cta['title']) : '';
$cta_target                 = !empty($cta['target']) ? esc_attr($cta['target']) : '';
?>
<section class="customImagenTextoBoton3 pt-84 px-24" data-seccion-inicial>
    <div class="customContainer px-0">
        <div class="row">
            <div class="col-12 col-lg-6 customImagenTextoBoton3__img">
                <?php echo generar_imagen_responsive($imagen, 'custom-size', SITE_NAME, 'd-block');?>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex flex-column justify-content-center h-100">
                    <?php if (!empty($titulo)) : ?>
                        <h2 class="customImagenTextoBoton3__titulo text-left font-fira-sans fs-2 mb-12"><?php echo $titulo; ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($descripcion)) : ?>
                        <p class="font-sans fs-p mb-30">
                            <?php echo $descripcion; ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($cta_url)) : ?>
                        <div class="pb-48">
                            <a href="<?php echo $cta_url; ?>" class="customButton customButton-blue" target="<?php echo $cta_target; ?>" title="<?php echo $cta_title; ?>"><?php echo $cta_title; ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>