<?php 
$grupo_banner_texto     = get_field('grupo_banner_texto');
$imagen_desktop         = !empty($grupo_banner_texto['imagen_desktop']['ID']) ? $grupo_banner_texto['imagen_desktop']['ID'] : '';
$imagen_mobile          = !empty($grupo_banner_texto['imagen_mobile']['ID']) ? $grupo_banner_texto['imagen_mobile']['ID'] : '';
$titulo                 = !empty($grupo_banner_texto['titulo']) ? esc_html($grupo_banner_texto['titulo']) : '';
$descripcion            = !empty($grupo_banner_texto['descripcion']) ? $grupo_banner_texto['descripcion'] : '';

?>
<section class="position-relative">
    <?php echo generar_imagen_responsive($imagen_desktop, 'custom-size', SITE_NAME, 'd-none d-lg-block');?>
    <?php echo generar_imagen_responsive($imagen_mobile, 'custom-size', SITE_NAME, 'd-lg-none w-100');?>
    <div class="font-fira-sans position-absolute top-0 left-0 w-100 h-100 d-flex align-items-lg-center align-items-end px-24 pb-48">
        <div class="customContainer px-0">
            <div class="col-12 col-lg-6 px-0">
                <?php if ($titulo) : ?>
                    <h1 class="fs-1 mb-12 color--fff"><?php echo $titulo; ?></h1>
                <?php endif; ?>

                <?php if ($descripcion) : ?>
                    <p class="fs-p color--fff mb-0 pe-lg-5"><?php echo $descripcion; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>