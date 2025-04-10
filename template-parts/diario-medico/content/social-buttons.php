<?php
    $post_url = urlencode( get_permalink() );
    $post_title = urlencode( get_the_title() );
    $upload_dir = wp_upload_dir();
?>

<div class="social-share__buttons">
    <span class="heading--14 color--0C2448">Compartir en:</span>
    <div class="iconos-redes">
        <a href="mailto:?subject=<?php echo $post_title; ?>&body=<?php echo $post_url; ?>" class="icono red-mail">
            <img src="<?php echo esc_url( $upload_dir['url'] . '/mail.svg'); ?>" alt="Mail">
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url; ?>" target="_blank" class="icono red-fb">
            <img src="<?php echo esc_url( $upload_dir['url'] . '/facebook.svg'); ?>" alt="Facebook">
        </a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $post_url; ?>&title=<?php echo $post_title; ?>" target="_blank" class="icono red-in">
            <img src="<?php echo esc_url( $upload_dir['url'] . '/linkedin.svg'); ?>" alt="Linkedin">
        </a>
        <a href="https://wa.me/?text=<?php echo $post_title . '%20' . $post_url; ?>" target="_blank" class="icono red-wa">
            <img src="<?php echo esc_url( $upload_dir['url'] . '/whatsapp.svg'); ?>" alt="Whatsapp">
        </a>
    </div>
</div>