$(document).ready(function () {
    // Evento para botón de visualización
    $(document).on('click', '#buttonProgVisual', function () {
        const id = $(this).data('id');
        $.ajax({
            url: base_url + "/programas_presupuestales/editar",
            method: "POST",
            data: { id_programa: id },
            dataType: "json",
            success: function (response) {
                if (response.Status === '200') {
                    $('#formProgVisual [name="codPrograma"]').val(response.Mensaje.codigo_programa);
                    $('#formProgVisual [name="nomPrograma"]').val(response.Mensaje.nombre);
                    $('#formProgVisual [name="desPrograma"]').val(response.Mensaje.descripcion);
                } else {
                    alert(response.Mensaje);
                }
            }
        });
    });

    // Evento para botón de eliminación
    $(document).on('click', '#buttonDelete', function () {
        const id = $(this).data('id');
        if (confirm("¿Estás seguro de eliminar este programa?")) {
            $.ajax({
                url: base_url + "/programas_presupuestales/delete",
                method: "POST",
                data: { id_programa: id },
                dataType: "json",
                success: function (response) {
                    alert(response.Mensaje);
                    if (response.Status === '200') {
                        location.reload();
                    }
                }
            });
        }
    });
});
