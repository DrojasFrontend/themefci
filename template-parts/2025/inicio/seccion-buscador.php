<?php
// Consulta páginas
$args = array(
    'post_type' => 'page',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
);
$paginas_query = new WP_Query($args);
$lista = array();

if ($paginas_query->have_posts()) {
  while ($paginas_query->have_posts()) {
    $paginas_query->the_post();
    $permalink = get_permalink();
    
    if (strpos($permalink, '/servicio/') !== false || 
      strpos($permalink, '/servicios/') !== false) {
      // Verificar que no sea exactamente '/servicio/' o '/servicios/'
      if ($permalink !== home_url('/servicio/') && $permalink !== home_url('/servicios/')) {
        $lista[] = array(
          "enlace" => get_the_title(),
          "link" => $permalink
        );
      }
    }
  }
}
wp_reset_postdata();

$servicios_parent = get_page_by_path('servicio');
$servicios_parent_id = ($servicios_parent) ? $servicios_parent->ID : 0;

if ($servicios_parent_id > 0) {
  $child_args = array(
    'post_type' => 'page',
    'posts_per_page' => -1,
    'post_parent' => $servicios_parent_id,
    'orderby' => 'title',
    'order' => 'ASC'
  );
  
  $child_query = new WP_Query($child_args);
  if ($child_query->have_posts()) {
    while ($child_query->have_posts()) {
      $child_query->the_post();
      $permalink = get_permalink();
      $title = get_the_title();
      $exists = false;
      
      foreach ($lista as $item) {
        if ($item['link'] === $permalink) {
          $exists = true;
          break;
        }
      }
      
      if (!$exists) {
        $lista[] = array(
          "enlace" => $title,
          "link" => $permalink
        );
      }
    }
  }
  wp_reset_postdata();
}
?>

<section class="customBuscadorTecla pb-84 px-24">
  <div class="customContainer px-0">
    <h2 class="font-fira-sans fs-2 mb-12 text-left">Especialidades LaCardio</h2>
    <div class="row">
      <div class="col-12 col-lg-6 mb-30">
        <p class="font-sans fs-p mb-30">Encuentra la especialidad que necesitas según la <strong>letra inicial</strong></p>
        <div class="d-flex flex-wrap gap-22">
          <?php
          
            $letras = range('A', 'Z');
            foreach ($letras as $letra) {
              echo '<button class="letra-btn font-sans fs-p fw-semibold color--002D72" data-letra="' . $letra . '">' . $letra . '</button> ';
            }
          ?>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <p class="font-sans fs-p mb-30">Si conoces el nombre, también puedes usar el buscador</p>
        <div class="d-flex align-items-center mb-3">
          <div class="position-relative flex-grow-1">
            <i class="position-absolute customIcono customIconoSearch"></i>
            <input type="text" id="buscar-especialidad" placeholder="Escribe el nombre de la especialidad">
          </div>
          <button id="boton-buscar" class="customButton customButton-blue font-sans">Buscar</button>
        </div>
        <div id="resultados-especialidades"></div>
      </div>
    </div>

  </div>
</section>

<script>
  jQuery(document).ready(function($) {
    
    var especialidades = <?php echo json_encode($lista); ?>;
    
    $('.letra-btn').click(function() {
      // Remover la clase 'active' de todos los botones
      $('.letra-btn').removeClass('active');
      // Agregar la clase 'active' al botón clicado
      $(this).addClass('active');
      var letraSeleccionada = $(this).data('letra');
      if (letraSeleccionada === 'todos') {
        mostrarResultados(especialidades);
      } else {
        filtrarPorLetra(letraSeleccionada);
      }
    });

    $('#buscar-especialidad').on('input', function() {
      var termino = $(this).val().toLowerCase();
      buscarEspecialidad(termino);
    });
    
    // Agregar funcionalidad al botón de búsqueda
    $('#boton-buscar').click(function() {
      var termino = $('#buscar-especialidad').val().toLowerCase();
      buscarEspecialidad(termino);
    });
    
    // Permitir búsqueda al presionar Enter
    $('#buscar-especialidad').keypress(function(e) {
      if (e.which === 13) { // Código para la tecla Enter
        var termino = $(this).val().toLowerCase();
        buscarEspecialidad(termino);
        e.preventDefault(); // Evitar envío de formulario
      }
    });

    function filtrarPorLetra(letra) {
      var resultados = especialidades.filter(function(esp) {
        return esp.enlace.charAt(0).toUpperCase() === letra;
      });
      mostrarResultados(resultados);
    }

    function buscarEspecialidad(termino) {
      if (termino === '') {
        $('#resultados-especialidades').html('');
      } else {
        var resultados = especialidades.filter(function(esp) {
          return esp.enlace.toLowerCase().includes(termino);
        });
        mostrarResultados(resultados);
      }
    }

    function mostrarResultados(resultados) {
      var html = '';
      if (resultados.length === 0) {
        html = '<p class="font-sans fs-p mt-3">No se encontraron especialidades.</p>';
      } else {
        html = '<ul class="list-unstyled mt-3">';
        resultados.forEach(function(esp) {
          html += '<li class="mb-2 font-sans fs-5"><a href="' + esp.link + '" class="font-sans color--002D72">' + esp.enlace + '</a></li>';
        });
        html += '</ul>';
      }
      $('#resultados-especialidades').html(html);
    }

    // Ocultar botones de letras sin especialidades
    $('.letra-btn').each(function() {
      var letra = $(this).data('letra');
      var tieneEspecialidades = especialidades.some(function(esp) {
        return esp.enlace.charAt(0).toUpperCase() === letra;
      });
      if (!tieneEspecialidades) {
        $(this).hide();
      }
    });
  });
</script>