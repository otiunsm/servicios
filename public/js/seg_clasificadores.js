
// Función para cargar los datos del clasificador en el modal de visualización
$(document).ready(function(){

    $(document).on("click",".view-clasificador", function() {
        const id = $(this).data("id");
        console.log("ID del clasificador a visualizar:", id);

    $.ajax({
        url: "SegClasificadores/listar_clasificadores/" + id,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.Status === '200') {
                $('#formClasificadorVisual input[name="codigo_clasificador"]').val(data.Mensaje.codigo_clasificador);
                $('#formClasificadorVisual input[name="nombre_clasificador"]').val(data.Mensaje.nombre_clasificador);
                $('#formClasificadorVisual textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                $('#formClasificadorVisual').modal('show');
            } else {
                alert(data.Mensaje);
            }
        },
        error: function() {
            alert("Error al obtener el clasificador.");
        }
    });
    });

// Función para cargar los datos del clasificador en el modal de edición
$(document).on("click",".edit-clasificador", function() {
    const id = $(this).data("id");
    console.log("ID del clasificador a editar:", id);
    $.ajax({
        url: "SegClasificadores/listar_clasificadores/" + id,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.Status === '200') {
                $('#form_clasificador_edit input[name="id_clasificador"]').val(data.Mensaje.id_clasificador);
                $('#form_clasificador_edit input[name="codigo_clasificador"]').val(data.Mensaje.codigo_clasificador);
                $('#form_clasificador_edit input[name="nombre_clasificador"]').val(data.Mensaje.nombre_clasificador);
                $('#form_clasificador_edit textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                $('#formClasificadorEdit').modal('show');
            } else {
                alert(data.Mensaje);
            }
        },
        error: function() {
            alert("Error al cargar los datos del clasificador para edición.");
        }
    });
});

$(document).on("click",".delete-clasificador", function() {
    const id = $(this).data("id");
    console.log("ID del clasificador a eliminar:", id);

    Swal.fire({
        title: "¿Estás seguro de eliminar este registro?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        reverseButtons: true,
        showLoaderOnConfirm: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "SegClasificadores/delete/" + id, 
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
                    Swal.fire("Error", "Ocurrió un problema al intentar eliminar el clasificador.", "error");
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Cancelado", "La eliminación fue cancelada.", "error");
        }
    });
});
});
