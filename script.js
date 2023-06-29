$(document).ready(function() {
  // Cargar las opciones de región desde la base de datos
  $.ajax({
    url: 'cargar_regiones.php',
    type: 'GET',
    success: function(response) {
      $('#region').html(response);
    }
    
  });

  // Actualizar las opciones de comuna según la región seleccionada
  $('#region').on('change', function() {
    var regionId = $(this).val();
    $.ajax({
      url: 'cargar_comunas.php',
      type: 'POST',
      data: {regionId: regionId},
      success: function(response) {
        $('#comuna').html(response);
      }
    });
  });

  // Cargar las opciones de candidato desde la base de datos
  $.ajax({
    url: 'cargar_candidatos.php',
    type: 'GET',
    success: function(response) {
      $('#candidato').html(response);
    }
  });
});