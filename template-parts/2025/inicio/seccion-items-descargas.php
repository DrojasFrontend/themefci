<?php
$grupo_descargas    = get_field('grupo_descargas'); 
$titulo             = !empty($grupo_descargas['titulo']) ? $grupo_descargas['titulo'] : '';
$descripcion        = !empty($grupo_descargas['descripcion']) ? $grupo_descargas['descripcion'] : '';
$descargas          = !empty($grupo_descargas['descargas']) ? $grupo_descargas['descargas'] : [];
?>

<section class="customItemsDescargas pt-84 pb-84 px-24">
    <div class="customContainer px-0">
        <div class="row">
            <div class="col-12 col-lg-7 customItemsDescargas__descripcion">
                <div class="d-flex flex-column justify-content-center h-100">
                    <?php if (!empty($titulo)) : ?> 
                        <h2 class="customItemsDescargas__titulo text-left font-fira-sans fs-2 mb-12"><?php echo $titulo; ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($descripcion)) : ?>
                        <p class="text-left font-sans fs-p"><?php echo $descripcion; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <?php if (!empty($descargas)) : ?>
                    <div class="customItemsDescargas__descargas">
                        <?php foreach ($descargas as $descarga) : 
                            $link           = !empty($descarga['link']) ? $descarga['link'] : [];
                            $link_url       = !empty($link['url']) ? esc_url($link['url']) : '';
                            $link_titulo    = !empty($link['title']) ? esc_attr($link['title']) : '';
                            $link_target    = !empty($link['target']) ? esc_attr($link['target']) : '_self';
                        ?>
                            <a class="d-flex justify-content-between align-items-center font-sans fs-p fw-semibold customHoverLink" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_attr($link_titulo); ?>">
                                <span class="d-flex align-items-center gap-6">
                                    <img src="/wp-content/uploads/2025/04/descarga.svg" alt="">
                                    <span class="customHover"><?php echo esc_html($link_titulo); ?></span>
                                </span>
                                <img src="/wp-content/uploads/2025/04/right-arrow.svg" alt="">
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>