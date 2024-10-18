// Editar Área
$(document).on('click', '.buttonAreaEdit', function () {
    const item_area = $(this).attr('itemButton');
    const url = 'Areas/listar_area'; // Cambia la URL según tu API
    const data = { item_area };

    $.get(url, data, function (response) {
        if (response.Status === '200') {
            const { idarea, nombre_area, descripcion } = response.Mensaje;

            $('[name="idarea"]').val(idarea);  // Asegúrate de llenar el campo oculto del ID
            $('[name="nombre_area"]').val(nombre_area);
            $('[name="descripcion"]').val(descripcion);
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



