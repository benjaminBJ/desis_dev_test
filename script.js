$(document).ready(function() {
  // Cargar las regiones en el select de regiones
  $.ajax({
    url: 'procesar_voto.php',
    type: 'POST',
    dataType: 'json',
    data: { action: 'obtenerRegiones' },
    success: function(data) {
      if (data && data.length > 0) {
        var options = '';
        for (var i = 0; i < data.length; i++) {
          options += '<option value="' + data[i].id + '">' + data[i].nombre + '</option>';
        }
        $('#region').append(options);
      }
    }
  });

  // Cargar las comunas en el select de comunas al seleccionar una región
  $('#region').on('change', function() {
    var regionId = $(this).val();
    $('#comuna').empty();

    $.ajax({
      url: 'procesar_voto.php',
      type: 'POST',
      dataType: 'json',
      data: { action: 'obtenerComunas', regionId: regionId },
      success: function(data) {
        if (data && data.length > 0) {
          var options = '';
          for (var i = 0; i < data.length; i++) {
            options += '<option value="' + data[i].id + '">' + data[i].nombre + '</option>';
          }
          $('#comuna').append(options);
        }
      }
    });
  });

  // Cargar los candidatos en el select de candidatos
  $.ajax({
    url: 'procesar_voto.php',
    type: 'POST',
    dataType: 'json',
    data: { action: 'obtenerCandidatos' },
    success: function(data) {
      if (data && data.length > 0) {
        var options = '';
        for (var i = 0; i < data.length; i++) {
          options += '<option value="' + data[i].id + '">' + data[i].nombre + '</option>';
        }
        $('#candidato').append(options);
      }
    }
  });

  // Enviar el formulario mediante AJAX al hacer clic en el botón "Votar"
  $('#formulario').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'text',
      data: form.serialize(),
      success: function(response) {
        $('#mensaje').text(response);
      }
    });
  });
});