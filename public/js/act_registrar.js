"use strict";
var ListadoDeDatosTabla = {
  init: function () {
    var table = $("#kt_datatable1").DataTable({
      ajax: {
        url: "Act_registro/listar", // URL de la ruta para obtener los datos
        type: "POST", // Tipo de petición (GET/POST)
        data: function (d) {
          d.fechainicio = $("#fechainicio").val();
          d.fechafin = $("#fechafin").val();
        },
        dataSrc: "", // Asumiendo que la respuesta es un array de objetos JSON
      },
      deferRender: true,
      responsive: true,
      pageLength: 25,
      pagingType: "full_numbers",
      destroy: true,
      dom: "Bfrtip",
      
      columns: [
        { data: "idregistro" }, // Columna ID
        { data: "nro_carta" }, 
        { data: "nombre_c" }, 
        { data: "detalle_actividad" }, 
        { data: "fec_registro" }, 
        { data: "tipo_solicitud" }, 
        { data: "nombre_dep" }, 
        { data: "nombre_so" }, 
        {
          data: "estado_r",
          render: function(data, type, row) {
              // Usar operadores ternarios para definir clase y texto
              const badgeClass = data === "1" ? "badge-warning" :
                                 data === "2" ? "badge-danger" :
                                 data === "3" ? "bg-primary" :
                                 "badge-dark";
      
              const badgeText = data === "1" ? "RECIBIDO" :
                                data === "2" ? "PENDIENTE" :
                                data === "3" ? "ATENDIDO" :
                                "Desconocido";
      
              // Devuelve el HTML del badge
              return `<span class="badge ${badgeClass}">${badgeText}</span>`;
          }
      },      
        {
          data: null, // Columna Acciones
          orderable: false,
          render: function (data, type, row) {
            return `
                        <div class="btn-group">
                            <button class="btn btn-sm" id="buttonActEdit" itemButton="${row.idregistro}'" >
                                <i class="fas fa-pencil-alt text-success"></i>
                            </button>
                            <button class="btn btn-sm" onclick="eliminarAct(${row.idregistro},${row.act_eliminar})"> 
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </div>
                        `;
          },
        },
      ],
      buttons: [
        {
          extend: "excelHtml5",
          title: "REPORTE DE ACTIVIDADES-OTI-UNSM",
          className: "btn btn-success",
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7],
          },
    
        },
        {
          extend: "pdfHtml5",
          title: "REPORTE DE ACTIVIDADES-OTI-UNSM",
          className: "btn btn-danger",
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7],
          },
        },
        {
          extend: "print",
          title: "REPORTE DE ACTIVIDADES-OTI-UNSM",
          className: "btn btn-black",
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7],
          },
        },
      ],
      language: {
        url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
      },
    });
    $("#filtrar").on("click", function () {
      table.ajax.reload(); 
    });
  },
};

// Inicializar la tabla en el document.ready
jQuery(document).ready(function () {
  ListadoDeDatosTabla.init();
});

$(document).on("click", "#buttonActEdit", function () {
  const item_registrar = $(this).attr("itemButton");
  const url = "Act_registro/listar_registro"; 
  const data = { item_registrar };
  $.get(
    url,
    data,
    function (response) {
      if (response.Status === "200") {
        const {
          idregistro,
          tipo_solicitud,
          numero,
          fec_doc_sgd,
          nro_carta,
          detalle_actividad,
          // fec_registro,
          fec_atencion,
          observacion,
          tipo_doc,
          id_dependencia,
          id_solicitante,
          tipo_asistencia,
          medio_solicitud,
          id_categoria_actividad,
          estado_r,
          otras_atenciones,
        } = response.Mensaje;

        $('[name="tipo_solicitud"]').val(tipo_solicitud);
        $('[name="idregistro"]').val(idregistro);
        $('[name="numero"]').val(numero);
        $('[name="fec_doc_sgd"]').val(fec_doc_sgd);
        $('[name="nro_carta"]').val(nro_carta);
        $('[name="detalle_actividad"]').val(detalle_actividad);
        $('[name="fec_atencion"]').val(fec_atencion);
        $('[name="tipo_doc"]').val(tipo_doc);
        $('[name="tipo_asistencia"]').val(tipo_asistencia);
        $('[name="medio_solicitud"]').val(medio_solicitud);
        $('[name="id_categoria_actividad"]').val(id_categoria_actividad);
        $('[name="estado_r"]').val(estado_r);
        $('[name="otras_atenciones"]').val(otras_atenciones);
        $('[name="observacion"]').val(observacion);
        $("#formAct").modal("show");
        cargarSolicitantes(function () {
          $('[name="id_solicitante"]').val(id_solicitante).trigger("change");
        });

        listardependencias(function () {
          $('[name="id_dependencia"]').val(id_dependencia).trigger("change");
        });

        $("#formAct").modal("show");
      } else {
        alertShow(response.Status, response.Mensaje); // Mostrar alerta si hay error
      }
    },
    "json"
  );
});

$("#formAct").on("show.bs.modal", function (e) {
  const button = $(e.relatedTarget); // Botón que dispara el modal
  if (button.hasClass("btn-primary")) {
    limpiar(); //Limpia
  }
});
//funcion limpiar formulario
function limpiar() {
  $("#idregistro").val("0").trigger("change");
  $("#tipo_solicitud").val("NINGUNO").trigger("change");
  $("#numero").val("");
  $("#fec_doc_sgd").val("");
  $("#nro_carta").val("");
  $("#detalle_actividad").val("");
  $("#fec_atencion").val("");
  $("#tipo_doc").val("-").trigger("change"); // Limpia select estático
  $("#id_dependencia")
    .empty()
    .append("<option selected disabled>SELECCIONE...</option>")
    .trigger("change");
  $("#id_solicitante")
    .empty()
    .append("<option selected disabled>SELECCIONE...</option>")
    .trigger("change");
  $("#tipo_asistencia").val("REMOTO").trigger("change");
  $("#medio_solicitud").val("-").trigger("change");
  $("#id_categoria_actividad")
    .empty()
    .append("<option selected disabled>SELECCIONE...</option>")
    .trigger("change");
  $("#estado_r").val("1").trigger("change");
  $("#otras_atenciones").val("");
  $("#observacion").val("");

  // Cargar opciones dinámicas nuevamente
  cargarSolicitantes();
  listardependencias();
  listarcategorias();
}

//funcion guadareditatr
function GuardarEditar() {
  const url = "Act_registro/formData";
  var data = new FormData($("#act_registrar")[0]);
  $.ajax({
    url: url,
    type: "POST",
    data: data,
    processData: false,
    contentType: false,
    success: function (response) {
      if (response.Status === "200") {
        console.log("Correcto", response);
        $("#formAct").modal("hide");
        limpiar();
        location.reload();
      } else {
        console.log("Error", response);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud:", error);
      console.log("Detalles del error:", xhr.responseText);
    },
  });
}

// Eliminar
$(document).on("click", "#buttonActDelete", function () {
  const itemButton = $(this).attr("itemButton");
  AlertSw(itemButton);
});

cargarSolicitantes();
function cargarSolicitantes(callback) {
  $.ajax({
    url: "Act_registro/buscarSoli",
    method: "get",
    dataType: "json",
    success: function (response) {
      $("#id_solicitante")
        .empty()
        .append("<option selected disabled>SELECCIONE...</option>");
      if (response.status === "success") {
        $.each(response.data, function (index, solicitante) {
          $("#id_solicitante").append(
            new Option(solicitante.nombre_so, solicitante.id_solicitante)
          );
        });
        if (callback) callback();
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
function listardependencias(callback) {
  $.ajax({
    url: "Act_registro/listar_dependencias",
    method: "get",
    dataType: "json",
    success: function (response) {
      $("#id_dependencia")
        .empty()
        .append("<option selected disabled>SELECCIONE...</option>");
      if (response.status === "success") {
        $.each(response.data, function (index, dependencia) {
          $("#id_dependencia").append(
            new Option(dependencia.nombre_dep, dependencia.id_dependencia)
          );
        });
        if (callback) callback();
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
      $("#id_categoria_actividad")
        .empty()
        .append("<option selected disabled>SELECCIONE...</option>");
      $.each(response, function (index, categoria) {
        //console.log(categoria);
        if (categoria.nombre_c.trim()) {
          $("#id_categoria_actividad").append(
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

//condiciones por sgd-------------------------------------------------------------
const sgdSelect = document.getElementById("tipo_solicitud");
const hiddeninput = document.getElementById("hiddeninput");
//nuevo
sgdSelect.addEventListener("change", function () {
  const selectedValue = this.value;
  if (selectedValue === "SGD") {
    hiddeninput.style.display = "block";
  } else if (selectedValue === "NINGUNO") {
    hiddeninput.style.display = "none";
  }
});

hiddeninput.style.display = "none";
//fin de condiciones por sgd-------------------------------------------
function eliminarAct(idregistro, numero) {
  const nuevoEstado = numero === 1 ? 0 : 1; // Determina el nuevo estado
  const accion = nuevoEstado === 1 ? "activar" : "desactivar"; // Acción basada en el estado

  // Muestra una alerta de confirmación
  Swal.fire({
    title: `¿Estás seguro de ${accion} este registro?`,
    text: `Esta acción ${
      nuevoEstado === 1 ? "activará" : "desactivará"
    } el registro.`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: `Sí, ${accion}`,
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Si el usuario confirma, realiza la solicitud AJAX
      $.ajax({
        url: "/Act_registro/cambiarEstado", // Ruta al controlador
        type: "POST",
        dataType: "json", // Esperamos respuesta en formato JSON
        data: {
          idregistro: idregistro, // ID del registro a cambiar
          nuevoEstado: nuevoEstado, // Estado alternado (1 o 0)
        },
        success: function (data) {
          if (data.Tipo === "success") {
            Swal.fire({
              icon: "success",
              title: `¡Éxito!`,
              text: `El registro se ${
                nuevoEstado === 1 ? "activó" : "desactivó"
              } correctamente.`,
              timer: 2000,
              showConfirmButton: false,
            }).then(() => {
              location.reload(); // Recargar la página después de cerrar la alerta
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: data.Mensaje,
            });
          }
        },
        error: function (xhr, status, error) {
          console.error("Error en la solicitud AJAX:", error);
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ocurrió un error al cambiar el estado.",
          });
        },
      });
    }
  });
}

//funcion para levantar un modal de solictacnte
function agregarSolicitante(){
  $("#modalsolic").modal("show");
}
