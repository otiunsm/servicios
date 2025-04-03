$(document).ready(function () {
    // Función para cargar los datos del centro de costos en el modal de visualización
    $(document).on("click", ".view-centro-costo", function () {
        const id = $(this).data("id");
        console.log("ID del clasificador a visualizar:", id);
        $.ajax({
            url: "SegCentrocostos/listar_centro_costos/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data.Status === '200') {
                    $('#formCentroCostoVisual input[name="codigocen"]').val(data.Mensaje.codigocen);
                    $('#formCentroCostoVisual input[name="nombrecen"]').val(data.Mensaje.nombrecen);
                    $('#formCentroCostoVisual textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                    $('#formCentroCostoVisual').modal('show');
                } else {
                    alert(data.Mensaje);
                }
            },
            error: function () {
                alert("Error al obtener el centro de costos.");
            }
        });
    });

    // Función para cargar los datos del centro de costos en el modal de edición
    $(document).on("click", ".edit-centro-costo", function () {
        const id = $(this).data("id");
        console.log("ID del clasificador a visualizar:", id);
        $.ajax({
            url: "SegCentrocostos/listar_centro_costos/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data.Status === '200') {
                    $('#form_centro_costo_edit input[name="idCentro"]').val(data.Mensaje.idCentro);
                    $('#form_centro_costo_edit input[name="codigocen"]').val(data.Mensaje.codigocen);
                    $('#form_centro_costo_edit input[name="nombrecen"]').val(data.Mensaje.nombrecen);
                    $('#form_centro_costo_edit textarea[name="descripcion"]').val(data.Mensaje.descripcion);
                    $('#formCentroCostoEdit').modal('show');
                } else {
                    alert(data.Mensaje);
                }
            },
            error: function () {
                alert("Error al cargar los datos del centro de costos para edición.");
            }
        });
    });

    // Función para eliminar un centro de costos
    $(document).on("click", ".delete-centro-costo", function () {
        const id = $(this).data("id");
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
                    url: "SegCentrocostos/eliminar/" + id,
                    method: "POST",
                    dataType: "json",
                    success: function (data) {
                        if (data.Status === '200') {
                            Swal.fire("Eliminado", data.Mensaje, "success").then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Error", data.Mensaje, "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error", "Ocurrió un problema al intentar eliminar el centro de costos.", "error");
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire("Cancelado", "La eliminación fue cancelada.", "error");
            }
        });
    });
});