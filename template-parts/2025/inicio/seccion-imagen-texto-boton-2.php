<?php 
$grupo_imagen_texto_boton_2 = get_field('grupo_imagen_texto_boton_2');
$titulo                     = !empty($grupo_imagen_texto_boton_2['titulo']) ? esc_html($grupo_imagen_texto_boton_2['titulo']) : '';
$descripcion_1              = !empty($grupo_imagen_texto_boton_2['descripcion_1']) ? $grupo_imagen_texto_boton_2['descripcion_1'] : '';
$descripcion_2              = !empty($grupo_imagen_texto_boton_2['descripcion_2']) ? $grupo_imagen_texto_boton_2['descripcion_2'] : '';
$imagen                     = !empty($grupo_imagen_texto_boton_2['imagen']['ID']) ? $grupo_imagen_texto_boton_2['imagen']['ID'] : '';
$cta                        = !empty($grupo_imagen_texto_boton_2['cta']) ? $grupo_imagen_texto_boton_2['cta'] : '';
$cta_url                    = !empty($cta['url']) ? esc_url($cta['url']) : '';
$cta_title                  = !empty($cta['title']) ? esc_html($cta['title']) : '';
$cta_target                 = !empty($cta['target']) ? esc_attr($cta['target']) : '';

$contactos                  = !empty($grupo_imagen_texto_boton_2['contactos']) ? $grupo_imagen_texto_boton_2['contactos'] : [];
?>
<section class="customImagenTextoBoton2 pt-84 px-24 gradient-1">
    <div class="customContainer px-0">
        <div class="row">
            <div class="col-12 col-lg-6 customImagenTextoBoton2__img">
                <?php echo generar_imagen_responsive($imagen, 'custom-size', SITE_NAME, 'd-block');?>
            </div>
            <div class="col-12 col-lg-6">
                <?php if ($titulo) : ?>
                    <h2 class="customImagenTextoBoton2__titulo text-left font-fira-sans fs-2"><?php echo $titulo; ?></h2>
                <?php endif; ?>
                <?php if ($descripcion_1) : ?>
                    <p class="font-sans fs-p mb-30">
                        <?php echo $descripcion_1; ?>
                    </p>
                <?php endif; ?>
                <?php if ($cta_url) : ?>
                    <div class="pb-48">
                        <a href="<?php echo $cta_url; ?>" class="customButton customButton-blue" target="<?php echo $cta_target; ?>" title="<?php echo $cta_title; ?>"><?php echo $cta_title; ?></a>
                    </div>
                <?php endif; ?>
                <?php if ($descripcion_2) : ?>
                    <p class="font-sans fs-p mb-30">
                        <?php echo $descripcion_2; ?>
                    </p>
                <?php endif; ?>
                <?php if ($contactos) : ?>
                    <div class="customImagenTextoBoton2__ctas">
                        <?php foreach ($contactos as $contacto) : 
                            $icono      = !empty($contacto['icono']) ? $contacto['icono'] : '';
                            $nombre     = !empty($contacto['nombre']) ? esc_html($contacto['nombre']) : '';
                            $cta        = !empty($contacto['cta']) ? $contacto['cta'] : [];
                            $cta_url    = !empty($cta['url']) ? esc_url($cta['url']) : '';
                            $cta_title  = !empty($cta['title']) ? esc_html($cta['title']) : '';
                            $cta_target = !empty($cta['target']) ? esc_attr($cta['target']) : '';
                        ?>
                            <a class="d-flex flex-wrap gap-6 mb-18 customHoverLink" href="<?php echo $cta_url; ?>" class="font-sans fs-p" target="<?php echo $cta_target; ?>" title="<?php echo $cta_title; ?>">
                                <img src="<?php echo $icono; ?>" alt="<?php echo $nombre; ?>">
                                <span class="nombre fw-semibold color-080808"><?php echo $nombre; ?></span>
                                <span class="customHover"><?php echo $cta_title; ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
</section>