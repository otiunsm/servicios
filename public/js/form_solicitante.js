$(document).on("click", "#buttonSoliEdit", function () {
  const item_solicitante = $(this).attr("itemButton"); // Obtener el ID del solicitante
  const url = "Act_solicitante/listar_soli"; // URL del controlador que maneja la solicitud
  const data = { item_solicitante }; // El ID del solicitante que enviamos

  $.get(
    url,
    data,
    function (response) {
      if (response.Status === "200") {
        // Si el solicitante fue encontrado
        const {
          id_solicitante,
          dni_so,
          nombre_so,
          apellidos_so,
          telefono_so,
          direccion_so,
          email_so,
          cargo_so,
        } = response.Mensaje;

        // Rellenar los campos del formulario con los datos del solicitante
        $('[name="id_item"]').val(id_solicitante);
        $('[name="dni_so"]').val(dni_so);
        $('[name="nombre_so"]').val(nombre_so);
        $('[name="apellidos_so"]').val(apellidos_so);
        $('[name="telefono_so"]').val(telefono_so);
        $('[name="direccion_so"]').val(direccion_so);
        $('[name="email_so"]').val(email_so);
        $('[name="cargo_so"]').val(cargo_so);

        // Mostrar el modal o el formulario de edición
        $("#formSoli").modal("show");
        console.log("Datos recibidos correctamente:", response);
      } else {
        alertShow(response.Status, response.Mensaje); // Mostrar alerta si no se encontró el solicitante
      }
    },
    "json"
  );
});
//boton eliminar
$(document).on('click', '#buttonDelete', function () {
    const itemButton = $(this).attr('itemButton');
    AlertSw(itemButton);
});