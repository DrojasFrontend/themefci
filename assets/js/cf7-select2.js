document.addEventListener('DOMContentLoaded', function() {
  jQuery(document).ready(function($) {
    var $selectEspecialista = $('select[name="especialista"]');
    
    $selectEspecialista.select2({
      placeholder: "Selecciona un especialista",
      allowClear: true
    }).on('select2:select', function(e) {
      var event = new Event('change', { bubbles: true });
      this.dispatchEvent(event);
    });
  });
});