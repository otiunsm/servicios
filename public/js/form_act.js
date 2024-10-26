// Cargar datos en el formulario de actividades al hacer clic en el botón de edición
$(document).on("click", "#buttonActEdit", function () {
    const item_actividad = $(this).attr("itemButton"); // Obtener el ID de la actividad
    const url = "Act_registro/listar_actividad"; // URL del controlador que maneja la solicitud
    const data = { item_actividad }; // ID de la actividad enviada al servidor

    $.get(url, data, function (response) {
        if (response.Status === "200") {
            const {
                idregistro,
                numero,
                fec_doc_sgd,
                nro_carta,
                detalle_actividad,
                fec_registro,
                fec_atencion,
                observacion,
                tipo_doc,
                id_dependencia,
                id_solicitante,
                id_medio_solicitud,
                id_tipo_asistencia,
                id_categoria_actividad,
                id_usuario,
                estado_r,
                otras_atenciones
            } = response.Mensaje;

            // Rellenar los campos del formulario con los datos recibidos
            $('[name="id_item"]').val(idregistro);
            $('[name="numero"]').val(numero);
            $('[name="fec_doc_sgd"]').val(fec_doc_sgd);
            $('[name="nro_carta"]').val(nro_carta);
            $('[name="detalle_actividad"]').val(detalle_actividad);
            $('[name="fec_registro"]').val(fec_registro);
            $('[name="fec_atencion"]').val(fec_atencion);
            $('[name="observacion"]').val(observacion);
            $('[name="tipo_doc"]').val(tipo_doc);
            $('#nombre_dep').val(id_dependencia); 
            $('#nombre_so').val(id_solicitante); 
            $('#nombre_solicitud').val(id_medio_solicitud); 
            $('#nombre').val(id_tipo_asistencia); 
            $('#nombre_c').val(id_categoria_actividad); 
            $('[name="id_usuario"]').val(id_usuario);
            $('[name="estado_r"]').val(estado_r);
            $('[name="otras_atenciones"]').val(otras_atenciones);

            // Mostrar el modal
            $("#formAct").modal("show");
            console.log("Datos cargados correctamente:", response);
        } else {
            alert("Error: " + response.Mensaje); // Mensaje de error
        }
    }, "json");
});


$(document).on("click", "#buttonDelete", function () {
    const itemButton = $(this).attr("itemButton");
    AlertSw(itemButton); 
});