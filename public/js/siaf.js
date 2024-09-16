
$('[name="buscar_expediente"]').click(function() {
  const expediente = $("#expediente").val();
  const url = '../siaf/datasiaf';
  const data = { expediente };
  $("#registros").empty();
  $('#loadingOverlay').show();

  $.ajax({
    type: 'GET',
    url: url,
    data: data,
    timeout: 8000,
    dataType: 'json',
    success: function(result) {
    console.log(result);
    if (result.length > 0) {
        let contenido = [];
        result.forEach(function(valor, indice, array) {
            let registros = '<tr>' +
                '<td>' + (indice + 1) + '</td>' +
                 '<td>'+ valor['nombre'] +'</td>' +
                '<td>'+ valor['monto'] +'</td>' +
                '<td>'+ convertirFecha(valor['fecha']) +'</td>' +
                '<td></td>' +
                '<td><input type="checkbox" onchange="seleccionar_registro(this)" class="row-checkbox"></td>' +  // Add checkbox with a clas
                "</tr>";
            contenido.push(registros);
          });

      $("#registros").append(contenido);
    } else {
      $('#form2').modal('hide');
      alert("Número de expediente no encontrado");
      limpiar_form('not_found');
    }
  },
    error: function(xhr, status, error) {
      $('#loadingOverlay').hide();
      console.error(xhr.responseText);
    },
    complete: function(){
      $('#loadingOverlay').hide();
    },
  });
});


  //  $('#form_siaf').submit(function(event) {
  //       event.preventDefault();
  //       var selected = $('select option:selected').val();
  //       alert(selected);
  //   });

function convertirFecha(fecha) {
  const date = new Date(fecha);
  const dia = date.getDate();
  const mes = date.getMonth() + 1;
  const anio = date.getFullYear();
  return `${dia}-${mes}-${anio}`;
}

function clearModalInputs() {
        $('[name="expediente"]').val('');
        $('[name="nombres"]').val('');
        $('[name="monto"]').val('');
}

function seleccionar_registro(checkbox) {
      if (checkbox.checked) {
        var row = checkbox.closest('tr');
        var values = [];
        row.querySelectorAll('td').forEach(function (td) {
            values.push(td.innerText);
        });

           setTimeout(function() {
            $('[name="nombres"]').val(values[1]);
            $('[name="monto"]').val(values[2]);
            $('#form2').modal('hide');
        }, 500);
     }
  }

function limpiar_form(valor){
   $('form :input').each(function() {
        if ($(this).attr('name') !== 'fecha_pase' && $(this).attr('name') !== 'comprobante_pago' || valor !== 'not_found') {
            $(this).val('');
        }
    });
}

  $('#nuevoRegistroBtn').on('click', function() {

    $.ajax({
      type: 'GET',
      url: '../siaf/getcomprobantecorrelativo',
      dataType: 'json',
      beforeSend: function(){
         
      },
      success: function(result) {
      $('#loadingOverlay').hide();
       $('[name="comprobante_pago"]').val(parseInt(result));
       $('[name="numero_comprobante"]').val(parseInt(result));

       // $('[name="comprobante_pago"]').attr("value", parseInt(result));
       // $('[name="numero_comprobante"]').attr("value", parseInt(result));
      // $('[name="comprobante_pago"]').prop("disabled", true);

     
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });

$(document).on('click', '#buttonEdit', function () {
    const id = $(this).attr('itemButton');
    const url = 'siaf/editar';
    const data = { id };

    $.get(url, data, function (response) {

        console.log(response.Status);

        if (response.Status === '200') {

            const { id, comprobante_pago, expediente, tipo_giro, nombres, partida_especifica, monto, fecha_pase, orden_compra, orden_servicio, planilla_viatico, recibo_honorarios, exp_sgd, asunto_sgd } = response.Mensaje;

             // $('[name="comprobante_pago"]').prop("disabled", true);
            
            $('[name="id"]').val(id);
            $('[name="comprobante_pago"]').val(comprobante_pago);
            $('[name="expediente"]').val(expediente);
            $('[name="tipo_giro"]').val(tipo_giro);
            $('[name="nombres"]').val(nombres);
            $('[name="partida_especifica"]').val(partida_especifica);
            $('[name="monto"]').val(monto);
            $('[name="fecha_pase"]').val(fecha_pase);
            $('[name="orden_compra"]').val(orden_compra);
            $('[name="orden_servicio"]').val(orden_servicio);
            $('[name="planilla_viatico"]').val(planilla_viatico);
            $('[name="recibo_honorarios"]').val(recibo_honorarios);
            $('[name="exp_sgd"]').val(exp_sgd);
            $('[name="asunto_sgd"]').val(asunto_sgd);
            $('#form1').modal('show');
        } else {
            console.log(response.Status, response.Mensaje);
        }
    }, 'json');
});


