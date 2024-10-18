$(document).on('click', '.buttonDepenEdit', function () {
    const item_dependencia = $(this).attr('itemButton');
    const url = 'Act_Dependencias/listar_dependencia'; // Cambia la URL según tu API para dependencias
    const data = { item_dependencia };

    $.get(url, data, function (response) {
        if (response.Status === '200') {
            const { id_dependencia, nombre_dep, descripcion } = response.Mensaje;

            // Asegúrate de llenar el campo oculto correcto
            $('[name="id_dependencia"]').val(id_dependencia);  // Cambio aquí
            $('[name="nombre_dep"]').val(nombre_dep);
            $('[name="descripcion"]').val(descripcion);
            
            // Abre el modal para editar
            $('#formDepen').modal('show');
        } else {
            alert('Error: Dependencia no encontrada');
        }
    });
});

function resetForm() {
    // Limpiar los campos del formulario
    $('[name="id_item"]').val('');  // Limpia el campo oculto del ID
    $('[name="nombre_dep"]').val(''); // Limpia el campo del nombre
    $('[name="descripcion"]').val(''); // Limpia el campo de descripción
}


// Confirmar eliminación de Dependencia
$(document).on('click', '.buttonDelete', function () {
    const itemButton = $(this).attr('itemButton');
    AlertSw(itemButton);  // Llamar a la función de alerta de confirmación
});
