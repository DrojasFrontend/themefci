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
 * Agregar código JavaScript para manipular el consecutivo
 */
function fci_add_form_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Actualizar el contador después de enviar un formulario exitosamente
        document.addEventListener('wpcf7mailsent', function(event) {
            // Buscar el campo consecutivo en el mismo formulario que se envió
            var form = event.target;
            var consecutivoField = form.querySelector('input[name="consecutivo"]');
            
            if (consecutivoField) {
                var currentValue = parseInt(consecutivoField.value);
                if (!isNaN(currentValue)) {
                    // Incrementar el valor para el próximo uso
                    consecutivoField.value = currentValue + 1;
                }
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'fci_add_form_script'); 