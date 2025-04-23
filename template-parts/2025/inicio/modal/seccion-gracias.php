<?php 
$grupo_modal_formulario     = get_field('grupo_modal_formulario');
$seccion_imagen             = !empty($grupo_modal_formulario['seccion_imagen']['ID']) ? $grupo_modal_formulario['seccion_imagen']['ID'] : '';
$seccion_icono              = !empty($grupo_modal_formulario['seccion_icono']) ? $grupo_modal_formulario['seccion_icono'] : '';
$seccion_titulo             = !empty($grupo_modal_formulario['seccion_titulo']) ? esc_html($grupo_modal_formulario['seccion_titulo']) : '';
$seccion_descripcion        = !empty($grupo_modal_formulario['seccion_descripcion']) ? $grupo_modal_formulario['seccion_descripcion'] : '';
$seccion_cta                = !empty($grupo_modal_formulario['seccion_cta']) ? $grupo_modal_formulario['seccion_cta'] : [];
$seccion_cta_texto          = !empty($seccion_cta['title']) ? esc_html($seccion_cta['title']) : '';
$seccion_cta_url            = !empty($seccion_cta['url']) ? esc_url($seccion_cta['url']) : '';
$seccion_cta_target         = !empty($seccion_cta['target']) ? esc_attr($seccion_cta['target']) : '_self';

$seccion_tarjetas_titulo    = !empty($grupo_modal_formulario['seccion_tarjetas_titulo']) ? esc_html($grupo_modal_formulario['seccion_tarjetas_titulo']) : '';
$seccion_tarjetas           = !empty($grupo_modal_formulario['seccion_tarjetas']) ? $grupo_modal_formulario['seccion_tarjetas'] : [];
?>

<section class="pt-48 px-24 d-none" data-formulario-gracias>
    <div class="customContainer px-0">
        <div class="col-12 col-lg-9 m-auto">
            <div class="row">
                <div class="col-12 col-lg-6 px-0">
                    <div class="col-12 col-lg-11 h-100 px-0">
                        <div class="d-flex flex-column justify-content-center h-100 px-0">
                            <?php echo generar_imagen_responsive($seccion_imagen, 'custom-size', SITE_NAME, 'd-block');?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 px-0">
                    <img src="<?php echo $seccion_icono ?>" alt="check">
                    <?php if ($seccion_titulo) : ?>
                        <h2 class="font-fira-sans fs-2 mb-12 text-left"><?php echo $seccion_titulo; ?></h2>
                    <?php endif; ?>
                    <?php if ($seccion_descripcion) : ?>
                        <p class="font-sans fs-p mb-30"><?php echo $seccion_descripcion; ?></p>
                    <?php endif; ?>
                    <?php if ($seccion_cta_url) : ?>
                        <a href="<?php echo $seccion_cta_url; ?>" class="customButton customButton-blue" target="<?php echo $seccion_cta_target; ?>" title="<?php echo $seccion_cta_texto; ?>"><?php echo $seccion_cta_texto; ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="customTarjetasGrandes pt-84">
        <div class="customContainer px-0">
            <?php if ($seccion_tarjetas_titulo) : ?>
                <h2 class="font-fira-sans fs-2 mb-30 text-left"><?php echo $seccion_tarjetas_titulo; ?></h2>
            <?php endif; ?>
            <div class="swiper swiperTarjetasGrandes">
                <div class="swiper-wrapper">
                    <?php foreach ($seccion_tarjetas as $tarjeta) : 
                    $seccion_tarjeta_imagen         = !empty($tarjeta['seccion_tarjeta_imagen']['ID']) ? $tarjeta['seccion_tarjeta_imagen']['ID'] : '';
                    $seccion_tarjeta_imagen_mobile  = !empty($tarjeta['seccion_tarjeta_imagen_mobile']['ID']) ? $tarjeta['seccion_tarjeta_imagen_mobile']['ID'] : '';
                    $seccion_tarjeta_subtitulo      = !empty($tarjeta['seccion_tarjeta_subtitulo']) ? esc_html($tarjeta['seccion_tarjeta_subtitulo']) : '';
                    $seccion_tarjeta_titulo         = !empty($tarjeta['seccion_tarjeta_titulo']) ? esc_html($tarjeta['seccion_tarjeta_titulo']) : '';
                    ?>
                    <div class="swiper-slide">
                        <div class="position-relative customHoverLink clickeable">
                            <?php echo generar_imagen_responsive($seccion_tarjeta_imagen, 'custom-size', SITE_NAME, 'd-none d-lg-block w-100');?>
                            <?php echo generar_imagen_responsive($seccion_tarjeta_imagen_mobile, 'custom-size', SITE_NAME, 'd-lg-none w-100');?>
                            <div class="position-absolute top-0 left-0 w-100 h-100 d-flex flex-column justify-content-end p-24">
                                <?php if ($seccion_tarjeta_subtitulo) : ?>
                                    <p class="subtitulo color--fff mb-12"><?php echo $seccion_tarjeta_subtitulo; ?></p>
                                <?php endif; ?>
                                <?php if ($seccion_tarjeta_titulo) : ?> 
                                    <h3 class="font-fira-sans fs-4 color--fff mb-18">
                                        <?php echo $seccion_tarjeta_titulo; ?>
                                    </h3>
                                <?php endif; ?>
                                <a href="https://lacardio.org/lacardiokids/registro/" target="_blank" class="d-flex align-items-center font-sans fs-6 fw-semibold color--fff">
                                    <span class="customHover customHover-blanco color--fff">
                                        Visita nuestra comunidad
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M14.83 11.29L10.59 7.05001C10.497 6.95628 10.3864 6.88189 10.2646 6.83112C10.1427 6.78035 10.012 6.75421 9.88 6.75421C9.74799 6.75421 9.61729 6.78035 9.49543 6.83112C9.37357 6.88189 9.26297 6.95628 9.17 7.05001C8.98375 7.23737 8.87921 7.49082 8.87921 7.75501C8.87921 8.0192 8.98375 8.27265 9.17 8.46001L12.71 12L9.17 15.54C8.98375 15.7274 8.87921 15.9808 8.87921 16.245C8.87921 16.5092 8.98375 16.7626 9.17 16.95C9.26344 17.0427 9.37426 17.116 9.4961 17.1658C9.61794 17.2155 9.7484 17.2408 9.88 17.24C10.0116 17.2408 10.1421 17.2155 10.2639 17.1658C10.3857 17.116 10.4966 17.0427 10.59 16.95L14.83 12.71C14.9237 12.617 14.9981 12.5064 15.0489 12.3846C15.0997 12.2627 15.1258 12.132 15.1258 12C15.1258 11.868 15.0997 11.7373 15.0489 11.6154C14.9981 11.4936 14.9237 11.383 14.83 11.29Z" fill="currentColor"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="customSwiperPagination d-flex d-lg-none justify-content-center py-24 swiper-pagination-tarjeta"></div>
        </div>
    </div>
</section>