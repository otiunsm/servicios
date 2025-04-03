
// Función para cargar los datos del programa en el modal de visualización
$(document).ready(function () {
  
    
$(document).on("click",".view-programa", function() {
    const id = $(this).data("id");
    console.log("ID de la programa a visualizar:", id);
    $.ajax({
        url: "SegProgramas/listar_programas/" + id,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.Status === '200') {
                $('#formProgVisual input[name="codigo_programa"]').val(data.Mensaje.codigo_programa);
                $('#formProgVisual textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                $('#formProgVisual').modal('show');
            } else {
                alert(data.Mensaje);
            }
        },
        error: function() {
            alert("Error al obtener el programa presupuestal.");
        }
    });
});

// Función para cargar los datos del programa en el modal de edición
    $(document).on("click",".edit-programa", function() {
        const id = $(this).data("id");
        console.log("ID de la programa a editar:", id);
    $.ajax({
        url: "SegProgramas/listar_programas/" + id,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.Status === '200') {
                $('#form_prog_edit input[name="id_programa"]').val(data.Mensaje.id_programa);
                $('#form_prog_edit input[name="codigo_programa"]').val(data.Mensaje.codigo_programa);
                $('#form_prog_edit input[name="nombre_programa"]').val(data.Mensaje.nombre_programa);
                $('#form_prog_edit textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                $('#formProgEdit').modal('show'); 
            } else {
                alert(data.Mensaje);
            }
        },
        error: function() {
            alert("Error al cargar los datos del programa para edición.");
        }
    });
});


    $(document).on("click",".delete-programa", function() {
        const id = $(this).data("id");
        console.log("ID de la programa a eliminar:", id);
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
                url: "SegProgramas/eliminar/" + id, 
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

