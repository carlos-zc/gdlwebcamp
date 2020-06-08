$(function () {
  $('#registros').DataTable({
    "paging": true,
    "pageLength": 8,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
    "language": {
      paginate: {
        next: 'Siguiente',
        previous: 'Anterior',
        last: 'Último',
        first: 'Primero'
      },
      info: "Mostrando de _START_ a _END_ de _TOTAL_ resultados",
      infoFiltered: '(_MAX_ en total)',
      emptyTable: 'No hay registros',
      zeroRecords: 'No se encontraron coincidencias',
      infoEmpty: "0 registros encontrados",
      search: 'Buscar:'
    }
  });

  $('#crear_registro_admin').attr('disabled', true);

  $('#repetir_password').on('input', function() {
    var password_nuevo = $('#password').val();

    if($(this).val() == password_nuevo ) {
      $('#resultado_password').text('Correcto');
      $('#resultado_password').addClass('valid-feedback').removeClass('invalid-feedback');
      $('input#password').addClass('is-valid').removeClass('is-invalid');
      $('input#repetir_password').addClass('is-valid').removeClass('is-invalid');
      $('#crear_registro_admin').attr('disabled', false);
    } else {
      $('#resultado_password').text('No coinciden');
      $('#resultado_password').addClass('invalid-feedback').removeClass('valid-feedback');
      $('input#password').addClass('is-invalid').removeClass('is-valid');
      $('input#repetir_password').addClass('is-invalid').removeClass('is-valid');
    }
  });

  //Initialize Select2 Elements
  $('.seleccionar').select2({
    theme: 'bootstrap4'
  })

  //Date range picker
  $('#fecha').daterangepicker({
    singleDatePicker: true,
    "locale": {
      "format": "DD/MM/YYYY",
      "weekLabel": "S",
      "daysOfWeek": [
          "Dom",
          "Lun",
          "Martes",
          "Mie",
          "Jue",
          "Vie",
          "Sab"
      ],
      "monthNames": [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre"
      ],
      "firstDay": 1
  }

  });

  //Timepicker
  $('#timepicker').datetimepicker({
    format: 'LT'
  });

  // Font Awesome Icon Picker
  $('#icono').iconpicker();
  $("div.iconpicker-popover").removeClass('fade');

  // Input file plugin
  bsCustomFileInput.init();

  // LINE CHART 
    $.getJSON('servicio-registrados.php', function(data) {
      console.log(data);
      
      new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'grafica-registros',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: data,
        // The name of the data record attribute that contains x-values.
        xkey: 'fecha',
        // A list of names of data record attributes that contain y-values.
        ykeys: ['cantidad'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['Registrados'],
        pointSize: 5,
        resize: true
      });

    })

});