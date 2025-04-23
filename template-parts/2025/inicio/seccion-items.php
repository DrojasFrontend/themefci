<?php
$grupo_titulo_items = get_field('grupo_titulo_items');
$titulo = !empty($grupo_titulo_items['titulo']) ? $grupo_titulo_items['titulo'] : '';
$items = !empty($grupo_titulo_items['items']) ? $grupo_titulo_items['items'] : [];
?>
<section class="customItems pt-84 px-24">
    <div class="customContainer px-0">
        <?php if (!empty($titulo)) : ?>
            <h2 class="customItems__titulo font-fira-sans fs-2 mb-lg-60 mb-60"><?php echo $titulo; ?></h2>
        <?php endif; ?>
        <div class="customItems__grid">
            <?php foreach ($items as $item) : 
                $icono   = !empty($item['icono']) ? $item['icono'] : '';
                $detalle = !empty($item['detalle']) ? $item['detalle'] : '';
            ?>
            <div class="col">
                <li class="customLineaLiRojo">
                    <?php if (!empty($icono)) : ?>
                        <img class="pl-18" src="<?php echo $icono; ?>" alt="">
                    <?php endif; ?>
                    <?php if (!empty($detalle)) : ?>
                        <p class="font-sans fs-p pl-18"><?php echo $detalle; ?></p>
                    <?php endif; ?>
                </li>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>