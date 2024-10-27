// Editar Área
$(document).on('click', '.buttonAreaEdit', function () {
    const item_area = $(this).attr('itemButton');
    const url = 'Areas/listar_area'; // Cambia la URL según tu API
    const data = { item_area };
    
    $.get(url, data, function (response) {
        if (response.Status === '200') {
            const { idarea, nombre_area, descripcion } = response.Mensaje;
            $('[name="id_item"]').val(idarea);
            $('[name="nombre_area"]').val(nombre_area);
            $('[name="descripcion"]').val(descripcion);
            $('#formArea').modal('show');  // Mostrar el modal de edición
            console.log('Correcto', response);
        } else {
            AlertShowN(response.Status, response.Mensaje);  // Mostrar alerta si hay error
        }
    }, 'json');
});


// Agregar alerta de éxito cuando se cambia el estado del área
$(document).on('click', '.buttonToggleState', function () {
    const itemButton = $(this).attr('itemButton');
    const estadoActual = $(this).find('i').hasClass('fa-toggle-on') ? 'Desactivar' : 'Activar';
        
    console.log(`Estado actual: ${estadoActual}`);  // Debugging
    
    showConfirmationAlert(estadoActual.toLowerCase(), itemButton, (item) => {
        console.log(`Confirmación de alerta para el ítem: ${item}`);  // Debugging
        $.ajax({
            url: `/Areas/toggleEstado/${item}`,
            method: 'POST',
            success: function (response) {
                if (response.Status === '200') {
                    Swal.fire(
                        'Éxito',
                        'El estado del área ha sido cambiado correctamente.',
                        'success'
                    ).then(() => {
                        location.reload(); // Recargar la página para ver el nuevo estado
                    });
                } else {
                    Swal.fire('Error', response.Mensaje, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'No se pudo cambiar el estado', 'error');
            }
        });
    });
});
// Confirmar eliminación de Área
$(document).on('click', '.buttonDelete', function () {
    const itemButton = $(this).attr('itemButton');
    AlertSw(itemButton);  // Llamar a la función de alerta de confirmación
});



function limpiarFormulario() {
    document.getElementById('idarea').value = '';  // Limpia el campo oculto para crear un nuevo registro
    document.getElementById('nombre_area').value = '';
    document.getElementById('descripcion').value = '';
    document.getElementById('tipo_estado').value = 'R'; // Resetea el campo "Tipo de Estado"
    document.getElementById('submitButton').textContent = 'Guardar';  // Cambia el botón a "Guardar"
}


//llama correctamente a los datos cuando se abre el modal de editaar
function editarArea(id, nombre, descripcion, tipoEstado) {
    document.getElementById('idarea').value = id;  // Asigna el ID del área al campo oculto
    document.getElementById('nombre_area').value = nombre;
    document.getElementById('descripcion').value = descripcion;
    document.getElementById('tipo_estado').value = tipoEstado;
    document.getElementById('submitButton').textContent = 'Actualizar';  // Cambia el texto del botón a "Actualizar"
    $('#formArea').modal('show');  // Abre el modal para editar
}

