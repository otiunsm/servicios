let max_year = new Date();
let month_now = max_year.getMonth() + 1;
max_year = max_year.getFullYear().toString();
let min_year = '2010';
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
                    dni_boletacafae: {
                        validators: {
                            notEmpty: {
                                message: 'El campo es requerido.'
                            },
                            stringLength: {
                                max: '8',
                                min: '8',
                                message: 'Debe ingresar 8 dígitos.'
                            },
                            digits: {
                                message: 'Solo puede ingresar dígitos.'
                            }
                        }
                    },
                    periodo_boletacafae: {
                        validators: {
                            between: {
                                max: max_year,
                                min: min_year,
                                message: 'El año debe estar entre ' + min_year + ' y ' + max_year + '.'
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
            }), $("#submitButtonBoletaCafae").on("click", (function(t) {
                let dni_boletacafae = $('#dni_boletacafae').val();
                let periodo_boletacafae = $('#periodo_boletacafae').val();
                let month = $('mes_boletacafae').val();
                t.preventDefault(), o.validate().then((function(t) {
                    if ('Valid' == t) {
                        $('#sninper').show();
                        $.ajax({
                            type: "get",
                            url: '../apis/apis_boletacafae',
                            data: {
                                "dni_boletacafae": dni_boletacafae,
                                "periodo_boletacafae": periodo_boletacafae
                            },
                            dataType: "json",
                            success: function(response) {
                                $('#sninper').hide();
                                if (!response.message && createTable1(response.results).length) {
                                    $('#cardConsulta').hide();
                                    $('#tableConsulta').show();
                                    $('#tableBoletaCafae').DataTable({
                                        responsive: !0,
                                        pagingType: "full_numbers",
                                        destroy: true,
                                        data: createTable1(response.results),
                                        columns: [{
                                                title: "N° Boleta"
                                            },
                                            {
                                                title: "Nombre Completo"
                                            },
                                            {
                                                title: "N° Documento"
                                            },
                                            {
                                                title: "Periodo"
                                            },
                                            {
                                                title: "Fecha de Emisión"
                                            },
                                            {
                                                title: "Pago"
                                            },
                                            {
                                                title: "Imprimir"
                                            }
                                        ]
                                    });
                                } else {
                                    alertShow("No hay información disponible", "");
                                }

                            }
                        })
                    } else {
                        t.preventDefault()
                    }
                }))

            }))
        }
    }
}();
jQuery(document).ready((function() {
    KTLogin3.init();
    $('#tableConsulta').hide();
    $('#salir_boletacafae').on('click', function(event) {
        event.preventDefault();
        $('#tableConsulta').hide();
        $('#cardConsulta').show();
    });
    $(document).on("click", ".print_boletacafae", function(e) {

        // let data_boletapago = $('#tableBoletaCafae').DataTable().row( $( this ).parents( "tr" ) ).data();
        var current_row = $(this).parents('tr'); //Get the current row
        if (current_row.hasClass('child')) { //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
        }
        var data_boletacafae = $('#tableBoletaCafae').DataTable().row(current_row).data(); //At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

        window.open('../pdfreporte/reporte_cafae/'+data_boletacafae[0]+'/'+data_boletacafae[2]+'/'+data_boletacafae[4]);
    });
}));

function createTable1(data) {
  const content = [];
  let year = $('#periodo_boletacafae').val();
  let month = $('#mes_boletacafae').val();
  // Verificar si se proporcionaron valores válidos para year y month
  if (!year || !month) {
    return content;
  }

  // Determinar si se seleccionaron todos los meses
  const isAllMonths = month === 'todos';

  // Iterar sobre los elementos de data
  for (const item of data) {
    // Extraer propiedades relevantes del item
    const { annio, mes, fecha, coddocumento, nombre, appaterno, apmaterno, nrodocumento, periodo, neto } = item;

    // Dividir la fecha en partes
    const fechaParts = fecha.split("-");

    // Crear una cadena en formato "mes-año"
    const mesAnioStr = `${mes}-${annio}`;

    // Verificar si es el mes y año máximo
    const isMaxYearMonth = mesAnioStr === `${month_now}-${max_year}`;

    // Saltar a la siguiente iteración si el año es el máximo y el mes es mayor o igual al actual
    if (annio === max_year && parseInt(mes) >= month_now) {
      continue;
    }

    // Si no se seleccionaron todos los meses, verificar si el mes y año coinciden
    if (!isAllMonths && mesAnioStr !== `${month}-${year}`) {
      continue;
    }

    // Saltar a la siguiente iteración si es el mes y año máximo
    if (isMaxYearMonth) {
      continue;
    }

    // Crear un array con los datos a agregar
    const addData = [
      coddocumento,
      `${nombre} ${appaterno} ${apmaterno}`,
      nrodocumento,
      getMonth(periodo.toString().substring(4)),
      `${fechaParts[2]}-${fechaParts[1]}-${fechaParts[0]}`,
      `S/. ${parseFloat(neto).toFixed(2)}`,
      `<center><button class="btn btn-sm print_boletacafae" ><i class="fa fa-print text-success"></i></button></center>`
    ];

    content.push(addData);
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

    toastr.error("Error: " + error, msg);
}