// Editar Área
$(document).on('click', '.buttonEdit', function () {
    const item_registrar= $(this).attr('itemButton');
    const url = 'Act_registrar/listar_registro'/ + id; // Cambia la URL según tu API
    const data = { item_registrar };

    $.get(url, data, function (response) {
        if (response.Status === '200') {
            const { idregistro, numero, nro_carta, detalle_actividad, fec_registro, 
                fec_atencion, observacion, tipo_doc, id_dependencia, id_solicitante, idmedio_solicitud,id_tipo_asistencia, idcategoria_actividad} = response.Mensaje;

                 // Llenar el formulario con los datos recibidos
                 $('[name="nombre_area"]').val(nombre_area);
                 $('[name="idregistro"]').val(idregistro);
                 $('[name="numero"]').val(numero);
                 $('[name="nro_carta"]').val(nro_carta);
                 $('[name="detalle_actividad"]').val(detalle_actividad);
                 $('[name="fec_registro"]').val(fec_registro);
                 $('[name="fec_atencion"]').val(fec_atencion);
                 $('[name="observacion"]').val(observacion);
                 $('[name="tipo_doc"]').val(tipo_doc);
                 $('[name="id_dependencia"]').val(id_dependencia);
                 $('[name="id_solicitante"]').val(id_solicitante);
                 $('[name="idmedio_solicitud"]').val(idmedio_solicitud);
                 $('[name="id_tipo_asistencia"]').val(id_tipo_asistencia);
                 $('[name=idcategoria_actividad"]').val(idcategoria_actividad);
            $('#formArea').modal('show');  // Mostrar el modal de edición
            console.log('Correcto', response);
        } else {
            alertShow(response.Status, response.Mensaje);  // Mostrar alerta si hay error
        }
    }, 'json');
});


// Confirmar eliminación de Área
$(document).on('click', '.buttonDelete', function () {
    const itemButton = $(this).attr('itemButton');
    AlertSw(itemButton);  // Llamar a la función de alerta de confirmación
});



