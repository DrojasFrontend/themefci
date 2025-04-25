<?php
/**
 * Funciones especiales para manejar el contador en formularios Contact Form 7
 */

if (!defined('ABSPATH')) {
    exit; // Salir si se accede directamente
}

/**
 * Inicializar el contador si no existe
 */
function inicializar_contador_form() {
    if (get_option('fci_contador_correos') === false) {
        add_option('fci_contador_correos', 299);
    }
}
add_action('init', 'inicializar_contador_form');

/**
 * Incrementar el contador cuando se envía un formulario
 */
function fci_incrementar_contador($contact_form) {
    $contador = get_option('fci_contador_correos', 299);
    $contador++;
    update_option('fci_contador_correos', $contador);
    
    // Guardar el nuevo valor también en una variable transitoria para JavaScript
    set_transient('ultimo_contador_enviado', $contador, 60 * 60); // 1 hora
}
add_action('wpcf7_mail_sent', 'fci_incrementar_contador');

/**
 * Generar valores iniciales para el campo oculto consecutivo
 */
function fci_wpcf7_shortcode_handler($tag) {
    if ($tag['name'] !== 'consecutivo') {
        return $tag;
    }
    
    $contador = get_option('fci_contador_correos', 299);
    $tag['values'] = array($contador + 1);
    
    return $tag;
}
add_filter('wpcf7_form_tag', 'fci_wpcf7_shortcode_handler', 10, 1);

/**
 * Agregar código JavaScript para reflejar el consecutivo actual sin incrementarlo
 */
function fci_add_form_script() {
    $ultimo_contador = get_transient('ultimo_contador_enviado');
    $contador_actual = get_option('fci_contador_correos', 299);
    $siguiente_valor = $contador_actual + 1;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener el contador actual
        var contadorActual = <?php echo $siguiente_valor; ?>;
        
        // Actualizar el valor inicial del campo
        var camposConsecutivo = document.querySelectorAll('input[name="consecutivo"]');
        if (camposConsecutivo.length > 0) {
            camposConsecutivo.forEach(function(campo) {
                campo.value = contadorActual;
            });
        }
        
        // Actualizar el campo después de enviar un formulario
        document.addEventListener('wpcf7mailsent', function(event) {
            // Obtener nuevo valor después del envío
            contadorActual++;
            
            // Actualizar todos los campos consecutivos en la página
            var camposConsecutivo = document.querySelectorAll('input[name="consecutivo"]');
            if (camposConsecutivo.length > 0) {
                camposConsecutivo.forEach(function(campo) {
                    campo.value = contadorActual;
                });
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'fci_add_form_script'); 