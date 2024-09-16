let max_year1 = new Date();
let month_now = max_year1.getMonth()+1;
max_year1 = max_year1.getFullYear().toString();
let min_year1 = '2010';
var KTLogin3 = function() {
    var t, i = function(i) {
        var o = "login-" + i + "-on";
        i = "kt_login_" + i + "_form";
        t.removeClass("login-forgot-on"), t.removeClass("login-signin-on"), t.removeClass("login-signup-on"), t.addClass(o), KTUtil.animateClass(KTUtil.getById(i), "animate__animated animate__backInUp")
    };
    return {
        init: function() {
            var o;
            t = $("#kt_login"), o = FormValidation.formValidation(KTUtil.getById("kt_form_3"), {
                    fields: {
                        dni_boletapago: {
                            validators: {
                                notEmpty: {
                                    message: 'El campo es requerido.'
                                },
                                stringLength:{
                                    max: '8',
                                    min: '8',
                                    message: 'Debe ingresar 8 dígitos.'
                                },
                                digits:{
                                    message: 'Solo puede ingresar dígitos.'
                                }
                            }
                        },
                        periodo_boletapago: {
                            validators:{
                                between:{
                                    max: max_year1,
                                    min: min_year1,
                                    message:'El año debe estar entre ' + min_year1 + ' y ' + max_year1 + '.' 
                                },
                                notEmpty: {
                                    message: 'El campo es requerido.'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        submitButton: new FormValidation.plugins.SubmitButton,
                        bootstrap: new FormValidation.plugins.Bootstrap
                    }
                }), $("#submitButtonBoletaPago").on("click", (function(t) {
                    let dni_boletapago = $('#dni_boletapago').val();
                    let periodo_boletapago = $( '#periodo_boletapago' ).val();
                    let month = $( 'mes_boletapago' ).val();
                    t.preventDefault(), o.validate().then((function(t) {
                        if ('Valid' == t) {                           
                            $('#sninper').show();
                            $.ajax({
                                type: "get",
                                url: '../apis/apis_boletapago',
                                data:{"dni_boletapago":dni_boletapago, "periodo_boletapago":periodo_boletapago},
                                dataType: "json",
                                success: function(response){
                                $('#sninper').hide();
                                if(!response.message && createTable1(response.results).length ){
                                    $( '#cardConsulta' ).hide();
                                    $( '#tableConsulta' ).show();
                                    $('#tableBoletaPago').DataTable( {
                                        responsive: !0,
                                        pagingType: "full_numbers",
                                        destroy:true,
                                        data: createTable1(response.results),
                                        columns: [
                                            { title: "N° Boleta" },
                                            { title: "Nombre Completo" },
                                            { title: "N° Documento" },
                                            { title: "Periodo" },
                                            { title: "Fecha de Emisión" },
                                            { title: "Pago" },
                                            { title: "Imprimir" }
                                        ]
                                    } );
                                }
                                else{
                                    alertShow( "No hay información disponible", "");
                                }
                                
                                    }
                                })
                        }else{
                            t.preventDefault()
                        }
                    }))
                }))
        }
    }
}();
jQuery(document).ready((function() {
    KTLogin3.init();
    $( '#tableConsulta' ).hide();
    $( '#salir_boletapago' ).on('click', function(event) {
        event.preventDefault();
        $( '#tableConsulta' ).hide();
        $( '#cardConsulta' ).show();
    });
    $( document ).on( "click touchstart", ".print_boletapago", function( e ){
        //let data_boletapago = $('#tableBoletaPago').DataTable().row( $( this ).parents( "tr" ) ).data();
         var current_row = $(this).parents('tr');//Get the current row
    if (current_row.hasClass('child')) {//Check if the current row is a child row
        current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
    }
    var data_boletapago = $('#tableBoletaPago').DataTable().row(current_row).data();//At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row
    
        window.open('../pdfreporte/reporte_boleta/'+data_boletapago[0]+'/'+data_boletapago[2]+'/'+data_boletapago[4]);
    } );
}));

function createTable1(data) {
  const content = [];
  const year = $('#periodo_boletapago').val();
  const month = $('#mes_boletapago').val();

  if (year) {
    for (let i = 0; i < data.length; i++) {
      const annio = data[i]["annio"];
     
      const mes = data[i]["periodo"].toString().slice(-2);
      
      const fecha = data[i]["fecha"].split("-");

      if (annio == year && (month === "todos" || (month === mes && `${mes}-${annio}` !== month_now + "-" + max_year1))) {
          
            const codplanillaperiodo = data[i]["codplanillaperiodo"];
            const nombreCompleto = `${data[i]["nombre"]} ${data[i]["appaterno"]} ${data[i]["apmaterno"]}`;
            const nrodocumento = data[i]["nrodocumento"];
            const periodo = getMonth(data[i]["periodo"].toString().substring(4));
            const formattedFecha = `${fecha[2]}-${fecha[1]}-${fecha[0]}`;
            const total = parseFloat(data[i]["totalnoimponible"]) + parseFloat(data[i]["totalimponible"]);
            const formattedTotal = `S/. ${total.toFixed(2)}`;
            const buttonHtml = `<center><button class="btn btn-sm print_boletapago"><i class="fa fa-print text-success"></i></button></center>`;
    
            const addData = [codplanillaperiodo, nombreCompleto, nrodocumento, periodo, formattedFecha, formattedTotal, buttonHtml];
            content.push(addData);
        
      }
    }
  }

  return content;
}

function getMonth(data_month) {
  const monthNames = {
    '01': 'Enero',
    '02': 'Febrero',
    '03': 'Marzo',
    '04': 'Abril',
    '05': 'Mayo',
    '06': 'Junio',
    '07': 'Julio',
    '08': 'Agosto',
    '09': 'Septiembre',
    '10': 'Octubre',
    '11': 'Noviembre',
    '12': 'Diciembre'
  };

  return monthNames[data_month] || 'Desconocido';
}

function alertShow(error, msg) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };
      
      toastr.error("Error: "+error, msg);
}
