<?php
if (get_theme_mod('secundary_logo')) {
    $logo_url = get_theme_mod('secundary_logo');
    $link_url = get_theme_mod('secundary_logo_url');
    if (!empty($link_url)) {
        echo '<a href="' . esc_url($link_url) . '">';
    }
    echo '<img src="' . esc_url($logo_url) . '" class="secundary-logo" alt="Logo Secundario">';
    if (!empty($link_url)) {
        echo '</a>';
    }
}
?>