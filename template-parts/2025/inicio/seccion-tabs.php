<?php 
$grupo_tabs = get_field('grupo_tabs');
$titulo     = !empty($grupo_tabs['titulo']) ? $grupo_tabs['titulo'] : [];
$tabs       = !empty($grupo_tabs['tabs']) ? $grupo_tabs['tabs'] : [];
?>
<section class="customTabs pt-84 pb-84">
    <div class="px-24">
        <div class="customContainer px-0">
            <?php if (!empty($titulo)) : ?>
                <h2 class="text-center font-fira-sans fs-2 pb-24"><?php echo $titulo; ?></h2>
            <?php endif; ?>
        </div>
    </div>
    <div class="customContainer px-0">
        <!-- Navegación de los Tabs -->
        <div class="customTabs__nav">
            <ul class="d-flex justify-content-center m-0" id="customTabs" role="tablist">
                <?php foreach ($tabs as $key => $tab) : ?>
                    <li class="m-0" role="presentation">
                        <button class="border-0 px-12 <?php echo $key === 0 ? 'active' : ''; ?>" id="btn-tab-<?php echo $key; ?>" data-bs-toggle="tab" data-bs-target="#content-tab-<?php echo $key; ?>" type="button" role="tab" aria-controls="content-tab-<?php echo $key; ?>" aria-selected="<?php echo $key === 0 ? 'true' : 'false'; ?>"><?php echo $tab['titulo']; ?></button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <!-- Contenido de los Tabs -->
    </div>
    <div class="pt-48 px-24">
        <div class="customContainer px-0">
            <div class="tab-content">
               <?php foreach ($tabs as $key => $tab) : 
                   $imagen      = !empty($tab['imagen']) ? $tab['imagen'] : [];
                   $titulo      = !empty($tab['titulo']) ? esc_html($tab['titulo']) : '';
                   $descripcion = !empty($tab['descripcion']) ? $tab['descripcion'] : '';
                   $imagen_id   = !empty($tab['imagen']['ID']) ? $tab['imagen']['ID'] : '';
               ?>
                    <div class="tab-pane fade <?php echo $key === 0 ? 'show active' : ''; ?>" id="content-tab-<?php echo $key; ?>" role="tabpanel" aria-labelledby="btn-tab-<?php echo $key; ?>">
                        <div class="row flex-lg-row flex-column-reverse">
                            <div class="col-12 col-lg-6">
                                <div class="d-flex flex-column justify-content-center h-100">
                                    <?php if (!empty($titulo)) : ?>
                                        <h3 class="font-fira-sans fs-3-medium pb-24"><?php echo $titulo; ?></h3>
                                    <?php endif; ?>
                                    <?php if (!empty($descripcion)) : ?>
                                        <p class="font-sans fs-p"><?php echo $descripcion; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 customTabs__img">
                                <?php if (!empty($imagen_id)) : ?>
                                    <?php echo generar_imagen_responsive($imagen_id, 'custom-size', SITE_NAME, 'd-block img-fluid');?>
                                <?php endif; ?>
                            </div>
                        </div>    
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>