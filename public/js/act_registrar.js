// Editar Área
$(document).on("click", ".buttonEdit", function () {
  const item_registrar = $(this).attr("itemButton");
  const url = "Act_registrar/listar_registro" / +id; // Cambia la URL según tu API
  const data = { item_registrar };

  $.get(
    url,
    data,
    function (response) {
      if (response.Status === "200") {
        const {
          idregistro,
          numero,
          nro_carta,
          detalle_actividad,
          fec_registro,
          fec_atencion,
          observacion,
          tipo_doc,
          id_dependencia,
          id_solicitante,
          idmedio_solicitud,
          id_tipo_asistencia,
          idcategoria_actividad,
        } = response.Mensaje;

        // Llenar el formulario con los datos recibidos
        $('[name="nombre_area"]').val(nombre_area);
        $('[name="idregistro"]').val(idregistro);
        $('[name="numero"]').val(numero);
        $('[name="nro_carta"]').val(nro_carta);
        $('[name="detalle_actividad"]').val(detalle_actividad);
        $('[name="fec_registro"]').val(fec_registro);
        $('[name="fec_atencion"]').val(fec_atencion);
        $('[name="observacion"]').val(observacion);
        $('[name="tipo_doc"]').val(tipo_doc);
        $('[name="id_dependencia"]').val(id_dependencia);
        $('[name="id_solicitante"]').val(id_solicitante);
        $('[name="idmedio_solicitud"]').val(idmedio_solicitud);
        $('[name="id_tipo_asistencia"]').val(id_tipo_asistencia);
        $('[name=idcategoria_actividad"]').val(idcategoria_actividad);
        $("#formArea").modal("show"); // Mostrar el modal de edición
        console.log("Correcto", response);
      } else {
        alertShow(response.Status, response.Mensaje); // Mostrar alerta si hay error
      }
    },
    "json"
  );
});

// Eliminar
$(document).on("click", ".buttonDelete", function () {
  const itemButton = $(this).attr("itemButton");
  AlertSw(itemButton); // Llamar a la función de alerta de confirmación
});

cargarSolicitantes();
function cargarSolicitantes() {
  $.ajax({
    url: "Act_registro/buscarSoli",
    method: "get",
    dataType: "json",
    success: function (response) {
      $("#nombre_so")
        .empty()
        .append("<option selected disabled>Seleccione...</option>");
      if (response.status === "success") {
        $.each(response.data, function (index, solicitante) {
          $("#nombre_so").append(
            new Option(solicitante.nombre_so, solicitante.id_solicitante)
          );
        });
      } else {
        alert(response.message);
      }
    },
    error: function (xhr, status, error) {
      console.log("Error en la solicitud:", error);
    },
  });
}

//listar dependencias**************************************

listardependencias();
function listardependencias() {
  $.ajax({
    url: "Act_registro/listar_dependencias",
    method: "get",
    dataType: "json",
    success: function (response) {
      $("#nombre_dep")
        .empty()
        .append("<option selected disabled>Seleccione...</option>");
      if (response.status === "success") {
        $.each(response.data, function (index, dependencia) {
          $("#nombre_dep").append(
            new Option(dependencia.nombre_dep, dependencia.id_dependencia)
          );
        });
      } else {
        alert(response.message);
      }
    },
    error: function (xhr, status, error) {
      console.log("Error en la solicitud:", error);
    },
  });
}


//listar categorias**************************************
listarcategorias();

function listarcategorias() {
  $.ajax({
    url: "Act_registro/listarcategoiriaact",
    method: "get",
    dataType: "json",
    success: function (response) {
      $("#nombre_c")
        .empty()
        .append("<option selected disabled>Seleccione...</option>");
      $.each(response, function (index, categoria) {
        console.log(categoria);
        if (categoria.nombre_c.trim()) {
          $("#nombre_c").append(
            new Option(categoria.nombre_c, categoria.id_categoria_actividad)
          );
        }
      });
    },
    error: function (xhr, status, error) {
      console.log("Error en la solicitud:", error);
    },
  });
}
