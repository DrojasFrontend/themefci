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
 * Bloqueo exclusivo para incrementar el contador
 * Evita problemas de concurrencia usando mutex atómico
 */
function fci_obtener_e_incrementar_contador() {
    global $wpdb;
    
    // Nombre único para nuestro bloqueo
    $lock_name = 'contador_consecutivo_lock';
    
    // Intentar adquirir un bloqueo con un timeout de 10 segundos
    $lock_result = $wpdb->query($wpdb->prepare(
        "SELECT GET_LOCK(%s, 10)",
        $lock_name
    ));
    
    if ($lock_result === false) {
        // Si no podemos obtener el bloqueo, retornamos un valor por defecto
        return get_option('fci_contador_correos', 299) + 1;
    }
    
    // Obtenemos el valor actual directamente de la base de datos
    $option_row = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT option_value FROM {$wpdb->options} WHERE option_name = %s LIMIT 1",
            'fci_contador_correos'
        )
    );
    
    $contador = isset($option_row->option_value) ? (int)$option_row->option_value : 299;
    
    // Incrementamos el contador
    $contador++;
    
    // Actualizamos directamente en la base de datos
    $wpdb->update(
        $wpdb->options,
        ['option_value' => $contador],
        ['option_name' => 'fci_contador_correos']
    );
    
    // Liberamos el bloqueo
    $wpdb->query($wpdb->prepare(
        "SELECT RELEASE_LOCK(%s)",
        $lock_name
    ));
    
    return $contador;
}

/**
 * Incrementar el contador cuando se envía un formulario
 */
function fci_incrementar_contador($contact_form) {
    // Obtenemos e incrementamos el contador de manera atómica
    $nuevo_contador = fci_obtener_e_incrementar_contador();
    
    // Guardamos el ID del formulario y el valor para depuración
    $log_entry = [
        'timestamp' => current_time('mysql'),
        'contador' => $nuevo_contador,
        'form_id' => $contact_form->id(),
        'session_id' => session_id() ?: 'undefined'
    ];
    
    // Almacenar registro de contadores para depuración
    $log_actual = get_option('fci_contador_log', []);
    $log_actual[] = $log_entry;
    
    // Mantener solo los últimos 50 registros
    if (count($log_actual) > 50) {
        $log_actual = array_slice($log_actual, -50);
    }
    
    update_option('fci_contador_log', $log_actual);
}
add_action('wpcf7_mail_sent', 'fci_incrementar_contador');

/**
 * Iniciar sesión para identificar las solicitudes
 */
function fci_iniciar_sesion() {
    if (!session_id()) {
        @session_start();
    }
}
add_action('init', 'fci_iniciar_sesion');

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
    // Simplemente leemos el valor actual sin incrementarlo
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
            // Agregamos un retraso para asegurarnos de que el contador se actualizó en el servidor
            setTimeout(obtenerContadorActualizado, 1000);
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'fci_add_form_script'); 