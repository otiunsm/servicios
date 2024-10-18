$(document).on('click', '.buttonCateEdit', function () {
    const item_categoria = $(this).attr('itemButton');
    const url = 'Act_Categorias/listar_categoria'; // Cambia la URL según tu API para dependencias
    const data = { item_categoria };

    $.get(url, data, function (response) {
        if (response.Status === '200') {
            const { idcategoria_actividad, nombre_c } = response.Mensaje;

            $('[name="id_item"]').val(idcategoria_actividad);  // Asegúrate de tener un campo oculto para el id
            $('[name="nombre_c"]').val(nombre_c);
            $('#formCate').modal('show');  // Mostrar el modal de edición
            console.log('Correcto', response);
        } else {
            alertShow(response.Status, response.Mensaje);  // Mostrar alerta si hay error
        }
    }, 'json');
});
function resetForm() {
    // Limpiar los campos del formulario
    $('[name="id_item"]').val('');  // Limpia el campo oculto del ID
    $('[name="nombre_c"]').val(''); // Limpia el campo del nombre

}
//$('#formCate').on('show.bs.modal', function (e) {
  //  resetForm();  // Restablecer los campos al abrir el modal
//});
//$('#formCate').on('hidden.bs.modal', function (e) {
  //  resetForm();  // Restablecer los campos al cerrar el modal
//})



// Confirmar eliminación de Dependencia
$(document).on('click', '.buttonDelete', function () {
    const itemButton = $(this).attr('itemButton');
    AlertSw(itemButton);  // Llamar a la función de alerta de confirmación
});
