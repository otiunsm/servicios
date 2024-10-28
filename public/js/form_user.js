//select 2
/* $(document).ready(function() {
    $('.select_area').select2({
        theme: 'bootstrap',
        placeholder: 'Select an option',
        allowClear: true,
        width: '90%',
    });
}); */


$(document).on("click", "#buttonUserEdit", function () {
  const item_user = $(this).attr("itemButton");
  const url = "user/listar_user";
  const data = { item_user };

  $.get(
    url,
    data,
    function (response) {
      if (response.Status === "200") {
        const {
          id_usuario,
          dni,
          nombre,
          apellido,
          telefono,
          direccion,
          idperfil_usuario,
          correo,
          usuario,
        } = response.Mensaje;

        $('[name="id_item"]').val(id_usuario);
        $('[name="dni"]').val(dni);
        $('[name="nombre"]').val(nombre);
        $('[name="apellidos"]').val(apellido);
        $('[name="celular"]').val(telefono);
        $('[name="direccion"]').val(direccion);
        $('[name="perfil"]').val(idperfil_usuario);
        $('[name="correo"]').val(correo);
        $('[name="usuario"]').val(usuario);
        $("#formUser").modal("show");
        console.log("Correcto", response);
      } else {
        alertShow(response.Status, response.Mensaje);
      }
    },
    "json"
  );
});

$(document).on("click", "#buttonDelete", function () {
  const itemButton = $(this).attr("itemButton");
  AlertSw(itemButton);
});

$('[name="dni"]').focusout(function () {
  const dni = $('[name="dni"]').val();
  const url = "../apis/api_personal";
  const data = { dni };

  $.get(
    url,
    data,
    function (result) {
      const persona = JSON.parse(result);

      if (persona.message) {
        console.log(persona.message);
        return;
      }

      const { nombre, appaterno, apmaterno, nrodocumento } = persona[0];
      $('[name="nombre"]').val(nombre);
      $('[name="apellidos"]').val(`${appaterno} ${apmaterno}`);
      $('[name="usuario"]').val(nrodocumento);
    },
    "json"
  );
});
// consumo de aaappp
$(document).on("click", "#testp", function () {
  const dni = $('[name="dni"]').val();
  const url = "../apis/api_personal";
  const data = { dni };

  $.get(
    url,
    data,
    function (result) {
      console.log(result);
    },
    "json"
  );
});

$(document).on("click", "#buttonPerEdit", function () {
  $("#form_per_edit").trigger("reset");
  const id = $(this).attr("itemButton");
  const url = "perfiles/listar_perfil";
  const data = { id };

  $.post(
    url,
    data,
    function (respuesta) {
      console.log("respuesta:", respuesta);
      const { id_perfil, nombreperfil } = respuesta[0];

      $('#formPerEdit [name="id_item"]').val(id_perfil);
      $('#formPerEdit [name="nomPerfil"]').val(nombreperfil);

      respuesta[1].forEach(function (element) {
        $(`#formPerEdit .check-${element.idmodulo}`).prop("checked", true);
      });

      $("#formPerEdit").modal("show");
    },
    "json"
  );
});

// funcion listar tareas 
listarareas();
function listarareas() {
  $.ajax({
    url: "Areas/listarareas",
    method: "get",
    dataType: "json",
    success: function (response) {
     // console.log(response, "AREAR");
      $("#nombre_area")
        .empty()
        .append("<option selected disabled>Seleccione...</option>");
      $.each(response, function (index, area) {
        //console.log(area);
        if (area.nombre_area.trim()) {
          $("#nombre_area").append(
            new Option(area.nombre_area, area.id_area)
          );
        }
      });
    },
    error: function (xhr, status, error) {
      console.log("Error en la solicitud:", error);
    },
  });
}