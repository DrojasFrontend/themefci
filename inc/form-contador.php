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
 * Esta función usa transacciones para evitar problemas de concurrencia
 */
function fci_incrementar_contador($contact_form) {
    global $wpdb;
    
    // Comenzar transacción para evitar problemas de concurrencia
    $wpdb->query('START TRANSACTION');
    
    // Bloquear la fila para evitar que otros procesos la modifiquen simultáneamente
    $contador = get_option('fci_contador_correos', 299, false);
    
    // Incrementar el contador
    $contador++;
    
    // Actualizar el valor del contador
    update_option('fci_contador_correos', $contador);
    
    // Completar la transacción
    $wpdb->query('COMMIT');
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
 * Endpoint AJAX para obtener el siguiente valor del contador
 */
function fci_obtener_contador_ajax() {
    $contador = get_option('fci_contador_correos', 299);
    $siguiente = $contador + 1;
    
    wp_send_json_success(array('contador' => $siguiente));
    exit;
}
add_action('wp_ajax_obtener_contador', 'fci_obtener_contador_ajax');
add_action('wp_ajax_nopriv_obtener_contador', 'fci_obtener_contador_ajax');

/**
 * Agregar JS para sincronizar el contador antes del envío
 */
function fci_add_form_script() {
    $contador_actual = get_option('fci_contador_correos', 299);
    $siguiente_valor = $contador_actual + 1;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variable para almacenar el contador actual
        var contadorActual = <?php echo $siguiente_valor; ?>;
        
        // Función para actualizar todos los campos consecutivos
        function actualizarCamposConsecutivos(valor) {
            var camposConsecutivo = document.querySelectorAll('input[name="consecutivo"]');
            if (camposConsecutivo.length > 0) {
                camposConsecutivo.forEach(function(campo) {
                    campo.value = valor;
                });
            }
        }
        
        // Actualizar campos inicialmente
        actualizarCamposConsecutivos(contadorActual);
        
        // Función para obtener el contador actualizado del servidor
        function obtenerContadorActualizado() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        var respuesta = JSON.parse(xhr.responseText);
                        if (respuesta.success) {
                            contadorActual = respuesta.data.contador;
                            actualizarCamposConsecutivos(contadorActual);
                        }
                    } catch(e) {
                        console.error('Error al procesar la respuesta:', e);
                    }
                }
            };
            xhr.send('action=obtener_contador');
        }
        
        // Obtener contador actualizado cuando se enfoca en el formulario
        document.querySelectorAll('.wpcf7 form').forEach(function(form) {
            form.addEventListener('focusin', function() {
                obtenerContadorActualizado();
            });
        });
        
        // Actualizar justo antes de enviar el formulario
        document.addEventListener('wpcf7beforesubmit', function(event) {
            obtenerContadorActualizado();
        });
        
        // Verificar contador cada 30 segundos para formularios abiertos
        setInterval(obtenerContadorActualizado, 30000);
        
        // Actualizar después de envío exitoso
        document.addEventListener('wpcf7mailsent', function(event) {
            // Incrementamos localmente y actualizamos después de un breve retraso
            setTimeout(obtenerContadorActualizado, 1000);
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'fci_add_form_script'); 