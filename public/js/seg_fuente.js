
$(document).ready(function () {

    $(document).on("click",".view-fuente", function() {
        const id = $(this).data("id");
        console.log("ID de la fuente a visualizar:", id);

    $.ajax({
        url: "SegFuentes/listar_fuentes/" + id,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.Status === '200') {
                $('#formFuenteVisual input[name="codigo_fuente"]').val(data.Mensaje.codigo_fuente);
                $('#formFuenteVisual textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                $('#formFuenteVisual').modal('show');
            } else {
                alert(data.Mensaje);
            }
        },
        error: function() {
            alert("Error al obtener la fuente de financiamiento.");
        }
    });
});

// Función para cargar los datos de la fuente en el modal de edición
$(document).on("click",".edit-fuente", function() {
    const id = $(this).data("id");
    console.log("ID de la fuente a visualizar:", id);

    $.ajax({
        url: "SegFuentes/listar_fuentes/" + id,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.Status === '200') {
                $('#form_fuente_edit input[name="id_fuente"]').val(data.Mensaje.id_fuente);
                $('#form_fuente_edit input[name="codigo_fuente"]').val(data.Mensaje.codigo_fuente);
                $('#form_fuente_edit input[name="nombre_fuente"]').val(data.Mensaje.nombre_fuente);
                $('#form_fuente_edit textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                $('#formFuenteEdit').modal('show');
            } else {
                alert(data.Mensaje);
            }
        },
        error: function() {
            alert("Error al cargar los datos de la fuente para edición.");
        }
    });
});

$(document).on("click",".delete-fuente", function() {
    const id = $(this).data("id");
    console.log("ID de la fuente a visualizar:", id);

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
                url: "SegFuentes/eliminar/" + id, // Llamada al controlador
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
                    Swal.fire("Error", "Ocurrió un problema al intentar eliminar la fuente.", "error");
                }
            });
        } 
    });
});
});
