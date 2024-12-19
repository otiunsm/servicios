$(document).on("click", "#buttonSoliEdit", function () {
  const item_solicitante = $(this).attr("itemButton"); // Obtener el ID del solicitante
  const url = "Act_solicitante/listar_soli"; // URL del controlador que maneja la solicitud
  const data = { item_solicitante }; // El ID del solicitante que enviamos
  //fechainico fecha fin
  

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
          telefono_so,
          direccion_so,
          email_so,
          cargo_so,
        } = response.Mensaje;

        // Rellenar los campos del formulario con los datos del solicitante
        $('[name="id_solicitante"]').val(id_solicitante);
        $('[name="dni_so"]').val(dni_so);
        $('[name="nombre_so"]').val(nombre_so);
        $('[name="telefono_so"]').val(telefono_so);
        $('[name="direccion_so"]').val(direccion_so);
        $('[name="email_so"]').val(email_so);
        $('[name="cargo_so"]').val(cargo_so);
        $("#modalsolic").modal("show");
        console.log("Datos recibidos correctamente:", response);
      } else {
        alertShow(response.Status, response.Mensaje); // Mostrar alerta si no se encontró el solicitante
      }
    },
    "json"
  );
});

$('#modalsolic').on('show.bs.modal', function (e) {
  const button = $(e.relatedTarget); // Botón que dispara el modal
  if (button.hasClass('btn-primary')) {
    limpiar(); //Limpia 
  }
});
function limpiar() {
  $('[name="id_solicitante"]').val("");
  $('[name="dni_so"]').val("");
  $('[name="nombre_so"]').val("");
  $('[name="telefono_so"]').val("");
  $('[name="direccion_so"]').val("");
  $('[name="email_so"]').val("");
  $('[name="cargo_so"]').val("");
}
//boton eliminar
$(document).on("click", "#buttonDelete", function () {
  const itemButton = $(this).attr("itemButton");
  AlertSw(itemButton);
});

function agregarSolicitante() {
  $("#modalsolic").modal("show");
}

function GuardarEditar() {
  const url = "Act_solicitante/formData";
  var data = new FormData($("#form_solicitante")[0]);
  $.ajax({
    url: url,
    type: "POST",
    data: data,
    processData: false, // Impide que jQuery intente procesar los datos
    contentType: false, // Impide que jQuery establezca automáticamente el encabezado Content-Type
    success: function (response) {
      if (response.Status === "200") {
        console.log("Correcto", response);
        // alertShow(response.Status, response.Mensaje);
        $("#modalsolic").modal("hide"); // Ocultar el modal de edición
        location.reload();
      } else {
        console.log("Error", response);
        // alertShow(response.Status, response.Mensaje);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud:", error);
      console.log("Detalles del error:", xhr.responseText);
    },
  });
}
