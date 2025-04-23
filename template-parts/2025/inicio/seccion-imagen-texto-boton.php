<?php 
$grupo_imagen_texto_cta = get_field('grupo_imagen_texto_cta');
$imagen_id              = !empty($grupo_imagen_texto_cta['imagen']['ID']) ? $grupo_imagen_texto_cta['imagen']['ID'] : '';
$titulo                 = !empty($grupo_imagen_texto_cta['titulo']) ? esc_html($grupo_imagen_texto_cta['titulo']) : '';
$descripcion            = !empty($grupo_imagen_texto_cta['descripcion']) ? $grupo_imagen_texto_cta['descripcion'] : '';
$cta                    = !empty($grupo_imagen_texto_cta['cta']) ? $grupo_imagen_texto_cta['cta'] : '';
$cta_url                = !empty($cta['url']) ? esc_url($cta['url']) : '';
$cta_title              = !empty($cta['title']) ? esc_html($cta['title']) : '';
$cta_target             = !empty($cta['target']) ? esc_attr($cta['target']) : '';
?>
<section class="customImagenTextoItems pt-lg-92 pt-48 px-24">
    <div class="customContainer px-0">
        <div class="row">
            <div class="col-12 col-lg-6 mt-lg-0">
                <div class="customImagenTextoItems-img position-relative h-lg-100 float-lg-end mb-lg-0 mb-lg-18 ">
                    <?php echo generar_imagen_responsive($imagen_id, 'custom-size', SITE_NAME, 'd-block img-fluid');?>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-lg-0 mt-0">
                <div class="d-flex flex-column justify-content-center h-100">
                    <div class="pt-24">
                        <?php if ($titulo) : ?>
                            <h2 class="font-fira-sans fs-2 mb-12 text-left mt-30"><?php echo $titulo; ?></h2>
                        <?php endif; ?>

                        <?php if ($descripcion) : ?>
                            <p class="font-sans fs-p mb-30 p-margin"><?php echo $descripcion; ?></p>
                        <?php endif; ?>

                        <?php if (!empty($cta_url)) : ?>
                            <a href="<?php echo $cta_url; ?>" class="customButton customButton-blue" target="<?php echo $cta_target; ?>" title="<?php echo $cta_title; ?>"><?php echo $cta_title; ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>