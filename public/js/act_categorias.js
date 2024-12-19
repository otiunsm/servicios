// Categorías //
// Editar Categoría
$(document).on('click', '.buttonCateEdit', function () {
    const item_categoria = $(this).attr('itemButton');
    const url = 'Act_Categorias/listar_categoria'; // Cambia la URL según tu API
    const data = { item_categoria };
    
    $.get(url, data, function (response) {
        if (response.Status === '200') {
            const { idcategoria_actividad, nombre_c } = response.Mensaje;
            $('#idcategoria_actividad').val(idcategoria_actividad);
            $('#nombre_c').val(nombre_c);
            $('#formCate').modal('show'); // Mostrar el modal de edición
            console.log('Correcto', response);
        } else {
            AlertShowN(response.Status, response.Mensaje);  // Mostrar alerta si hay error
        }
    }, 'json');
});

// Cambiar el estado de la categoría
$(document).on('click', '.buttonToggleStateCate', function () {
    const itemButton = $(this).attr('itemButton');
    const estadoActual = $(this).find('i').hasClass('fa-toggle-on') ? 'Desactivar' : 'Activar';
    
    console.log(`Estado actual: ${estadoActual}`);  // Debugging
    
    showConfirmationAlert(estadoActual.toLowerCase(), itemButton, (item) => {
        console.log(`Confirmación de alerta para el ítem: ${item}`);  // Debugging
        $.ajax({
            url: `/Act_Categorias/toggleEstado/${item}`,
            method: 'POST',
            success: function (response) {
                if (response.Status === '200') {
                    Swal.fire(
                        'Éxito',
                        'El estado de la categoría ha sido cambiado correctamente.',
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

// Confirmar eliminación de Categoría
$(document).on('click', '.buttonDeleteCate', function () {
    const itemButton = $(this).attr('itemButton');
    AlertSw(itemButton);  // Llamar a la función de alerta de confirmación
});

//limpiar formulario//
function limpiarFormularioCate() {
    const campos = ['id_categoria_actividad','nombre_c'];
    campos.forEach(id => {
        const elemento = document.getElementById(id);
        if (elemento) {
            elemento.value = ''; // Limpia el valor del campo
        }
    });
    const boton = document.getElementById('submitButton');
    if (boton) {
        boton.textContent = 'Guardar'; // Cambia el texto del botón
    }
}

// Llama correctamente a los datos cuando se abre el modal de editar Categoría
function editarCate(id, nombre) {
    document.getElementById('idcategoria_actividad').value = id;  // Asigna el ID de la categoría al campo oculto
    document.getElementById('nombre_c').value = nombre;
    document.getElementById('submitButton').textContent = 'Actualizar';  // Cambia el texto del botón a "Actualizar"
    $('#formCate').modal('show');  // Abre el modal para editar
}
