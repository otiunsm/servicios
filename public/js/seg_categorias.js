
$(document).ready(function () {
    // Función para visualizar una categoría
    $(document).on("click", ".view-categoria", function () {
        const id = $(this).data("id"); // Obtiene el ID de la categoría
        console.log("ID de la categoría a visualizar:", id); // Depuración

        $.ajax({
            url: "SegCategoria/listar_categorias/" + id, // URL del endpoint
            method: "GET",
            dataType: "json",
            success: function (data) {
                console.log("Respuesta del servidor:", data); // Depuración

                if (data.Status === '200') {
                    // Llena el modal con los datos de la categoría
                    $('#formCatVisual input[name="codigo_categoria"]').val(data.Mensaje.codigo_categoria);
                    $('#formCatVisual textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                    $('#formCatVisual').modal('show'); // Muestra el modal
                } else {
                    alert(data.Mensaje); // Muestra el mensaje de error del servidor
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown); // Depuración
                alert("Error al obtener la categoría. Ver la consola para más detalles.");
            }
        });
    });

    // Función para editar una categoría
    $(document).on("click", ".edit-categoria", function () {
        const id = $(this).data("id"); // Obtiene el ID de la categoría
        console.log("ID de la categoría a editar:", id); // Depuración

        $.ajax({
            url: "SegCategoria/listar_categorias/" + id, // URL del endpoint
            method: "GET",
            dataType: "json",
            success: function (data) {
                console.log("Respuesta del servidor:", data); // Depuración

                if (data.Status === '200') {
                    // Llena el modal con los datos de la categoría
                    $('#formCatEdit input[name="id_categoria"]').val(data.Mensaje.id_categoria);
                    $('#formCatEdit input[name="codigo_categoria"]').val(data.Mensaje.codigo_categoria);
                    $('#formCatEdit input[name="nombre_categoria"]').val(data.Mensaje.nombre_categoria);
                    $('#formCatEdit textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                    $('#formCatEdit').modal('show'); // Muestra el modal
                } else {
                    alert(data.Mensaje); // Muestra el mensaje de error del servidor
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown); // Depuración
                alert("Error al obtener la categoría. Ver la consola para más detalles.");
            }
        });
    });

    // Función para eliminar una categoría
    $(document).on("click", ".delete-categoria", function () {
        const id = $(this).data("id"); // Obtiene el ID de la categoría
        //console.log("ID de la categoría a eliminar:", id); // Depuración

        Swal.fire({
            title:"¿Estás seguro de eliminar esta categoría?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true,
            showLoaderOnConfirm: true,
            
            }).then((result) => {
                if (result.isConfirmed) {

            $.ajax({
                url: "SegCategoria/eliminar/" + id, // URL del endpoint
                method: "POST",
                dataType: "json",
                success: function(data) {
                    if (data.Status === '200') {
                        Swal.fire("Eliminado", data.Mensaje, "success").then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire("Error", data.Mensaje, "error");
                    }
                },
                error: function() {
                    Swal.fire("Error", "Ocurrió un problema al intentar eliminar el programa.", "error");
                }
            });
        } 
    });
    });
});