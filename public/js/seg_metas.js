
$(document).ready(function(){
// Función para cargar los datos de la meta en el modal de visualización
    $(document).on("click",".view-meta", function() {
        const id = $(this).data("id");
        console.log("ID de la meta a visualizar:", id);
    $.ajax({
        url: "SegMetas/listar_metas/" + id,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.Status === '200') {
                $('#formMetaVisual input[name="codigo_meta"]').val(data.Mensaje.codigo_meta);
                $('#formMetaVisual input[name="codigo_actividad"]').val(data.Mensaje.codigo_actividad);
                $('#formMetaVisual input[name="nombre_meta"]').val(data.Mensaje.nombre_meta);
                $('#formMetaVisual textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                $('#formMetaVisual').modal('show');
            } else {
                alert(data.Mensaje);
            }
        },
        error: function() {
            alert("Error al obtener la meta.");
        }
    });
});

// Función para cargar los datos de la meta en el modal de edición
    $(document).on("click",".edit-meta", function() {
        const id = $(this).data("id");
        console.log("ID de la meta a editar:", id);
    $.ajax({
        url: "SegMetas/listar_metas/" + id,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.Status === '200') {
                $('#form_meta_edit input[name="id_meta"]').val(data.Mensaje.id_meta);
                $('#form_meta_edit input[name="codigo_meta"]').val(data.Mensaje.codigo_meta);
                $('#form_meta_edit input[name="codigo_actividad"]').val(data.Mensaje.codigo_actividad);
                $('#form_meta_edit input[name="nombre_meta"]').val(data.Mensaje.nombre_meta);
                $('#form_meta_edit textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                $('#formMetaEdit').modal('show');
            } else {
                alert(data.Mensaje);
            }
        },
        error: function() {
            alert("Error al cargar los datos de la meta para edición.");
        }
    });
});

    $(document).on("click",".delete-meta", function() {
        const id = $(this).data("id");
        console.log("ID de la meta a editar:", id);
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
                url: "SegMetas/eliminar/" + id, 
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
                    Swal.fire("Error", "Ocurrió un problema al intentar eliminar la meta.", "error");
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Cancelado", "La eliminación fue cancelada.", "error");
        }
    });
});

});