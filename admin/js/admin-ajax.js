$(document).ready(function(){
    $('#guardar-registro').on('submit', function(e) {
        e.preventDefault();
        $('button[type="submit"]').attr('disabled', true);
        setTimeout(function() {
            $('button[type="submit"]').attr('disabled', false);
        }, 1000);
        
        var datos = $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if(data.respuesta == 'exito') {
                    Swal.fire(
                        'Correcto',
                        'Se guardó correctamente',
                        'success'
                    )
                } else {
                    Swal.fire(
                        '¡Error!',
                        'Hubo un error',
                        'error'
                    )
                }
            }
        });
    });

    // Se ejecuta cuando hay un archivo
    $('#guardar-registro-archivo').on('submit', function(e) {
        e.preventDefault();
        $('button[type="submit"]').attr('disabled', true);
        setTimeout(function() {
            $('button[type="submit"]').attr('disabled', false);
        }, 1000);
        
        var datos = new FormData(this);

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            contentType: false,
            processData: false,
            async: true,
            cache: false,
            success: function(data) {
                console.log(data)
                if(data.respuesta == 'exito') {
                    Swal.fire(
                        'Correcto',
                        'Se guardó correctamente',
                        'success'
                    )
                    if(data.nueva_imagen) {
                        // Si acambio la imagen la muestra
                        $('#imagen-actual').attr('src', '../img/invitados/' + data.nueva_imagen);
                    }
                } else {
                    Swal.fire(
                        '¡Error!',
                        'Hubo un error',
                        'error'
                    )
                }
            }
        });
    });

    // Eliminar un registro
    $('.borrar-registro').on('click', function(e) {
        e.preventDefault();
        $('button[type="submit"]').attr('disabled', true);
        setTimeout(function() {
            $('button[type="submit"]').attr('disabled', false);
        }, 1000);

        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');

        Swal.fire({
            title: '¿Estas seguro?',
            text: "Un registro eliminado no se puede recuperar",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, borrar'
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    data: {
                        'id': id,
                        'registro': 'eliminar'
                    },
                    url: 'modelo-'+ tipo + '.php',
                    success: function(data) {
                        var resultado = JSON.parse(data);
                        console.log(resultado)
                        if(resultado.respuesta == 'exito'){
                            Swal.fire(
                                'Eliminado',
                                'El registro se ha eliminado',
                                'success'
                            );
                            $(`[data-id="${resultado.id_eliminado}"]`).parents('tr').remove();
                        } else {
                            Swal.fire(
                                'Error',
                                'No se pudo eliminar',
                                'error'
                            );
                        }
                    }
                });
            }
        });
        
    });

    
});