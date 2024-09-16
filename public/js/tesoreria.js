let max_year = new Date();
max_year = max_year.getFullYear().toString();
let min_year = '2001';
var KTLogin1 = function() {
    var t, i = function(i) {
        var o = "login-" + i + "-on";
        i = "kt_login_" + i + "_form";
        t.removeClass("login-forgot-on"), t.removeClass("login-signin-on"), t.removeClass("login-signup-on"), t.addClass(o), KTUtil.animateClass(KTUtil.getById(i), "animate__animated animate__backInUp")
    };
    return {
        init: function() {
            var o;
            t = $("#kt_login"), o = FormValidation.formValidation(KTUtil.getById("kt_form_2"), {
                    fields: {
                        dni_name: {
                            validators: {
                             notEmpty: {
                              message: 'El campo es requerido.'
                             }
                            }
                        },
                        periodo_tesoreria: {
                            validators:{
                                between:{
                                    max: max_year,
                                    min: min_year,
                                    message:'El año debe estar entre ' + min_year + ' y ' + max_year + '.' 
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        submitButton: new FormValidation.plugins.SubmitButton,
                        bootstrap: new FormValidation.plugins.Bootstrap
                    }
                }), $("#submitButtonTesoreria").on("click", (function(t) {
                    let dni_consult = $('[name="dni_name"]').val();
                    let year = $( 'periodo_tesoreria' ).val();
                    let month = $( 'mes_tesoreria' ).val();
                    t.preventDefault(), o.validate().then((function(t) {
                        if ('Valid' == t) {                           
                            $('#sninper').show();
                            $.ajax({
                                type: "get",
                                url: '../apis/apis_tesoreria',
                                data:{dni_consult},
                                dataType: "json",
                                success: function(response){
                                $('#sninper').hide();
                                if(!response.message && createTable(response.results).length ){
                                    $( '#cardConsulta' ).hide();
                                    $( '#tableConsulta' ).show();
                                    response.results = cleanData( response.results );
                                    $('#tableTesoreria').DataTable( {
                                        responsive: !0,
                                        pagingType: "full_numbers",
                                        destroy:true,
                                        data: createTable(response.results),
                                        columns: [
                                            { title: "#" },
                                            { title: "N° Boleta" },
                                            { title: "Nombre Completo" },
                                            { title: "N° Documento" },
                                            { title: "Entidad de Recaudación" },
                                            { title: "Fecha de Pago" },
                                            { title: "Monto de Pago" },
                                            { title: "Concepto" },
                                            { title: "Imprimir" }
                                        ]
                                    } );
                                }
                                else{
                                    console.log( response );
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
    KTLogin1.init();
    $( '#tableConsulta' ).hide();
    $( '#salir_tesoreria' ).on('click', function(event) {
        event.preventDefault();
        $( '#tableConsulta' ).hide();
        $( '#cardConsulta' ).show();
    });
    $( document ).on( "click", ".print_tesoreria", function( e ){
        let dni = $(this).attr('itemid');
        let noopera = $(this).attr('itemButton');
        let nombre = $(this).attr('itemNombre');
        if(dni == "No registrado"){
            var dni_nombre = nombre;
        }else{
            var dni_nombre = dni;
        }
        window.open('../pdfreporte/reporte_tesoreria/'+dni_nombre+'/'+noopera);
    } );
}));

function createTable( data ){
    let content = [];
    let a = 0;
    let year = $( '#periodo_tesoreria' ).val();
    let month = $( '#mes_tesoreria' ).val();
    if( year ){
        if( month != 'todos' ){
            for (let i = 0; i < data.length; i++ ){
                let fecha = data[ i ][ "fecha" ].split("-");
                if( fecha[ '0' ] == year && fecha[ '1' ] == month ){
                    a = a + 1;
                    data[ i ][ "nombrecliente" ] = data[ i ][ "nombrecliente" ] == null ? "No registrado" : data[ i ][ "nombrecliente" ];
                    data[ i ][ "nrodoccliente" ] = data[ i ][ "nrodoccliente" ] == "" ? "No registrado" : data[ i ][ "nrodoccliente" ];
                    data[ i ][ "concepto" ] = data[ i ][ "concepto" ] == null ? "No registrado" : data[ i ][ "concepto" ];
                    let addData = [ a, data[ i ][ "seriecomprobante" ]+"-"+data[ i ][ "numerocomprobante" ], data[ i ][ "nombrecliente" ], data[ i ][ "nrodoccliente" ], data[ i ][ "entidadrecauda" ], fecha[ '2' ]+'-'+fecha[ '1' ]+'-'+fecha[ '0' ], data[ i ][ "monto" ], data[ i ][ "concepto" ], '<center><button class="btn btn-sm print_tesoreria" itemid="'+data[i]["nrodoccliente"]+'" itemButton="'+data[i]["nrooperacion"]+'" itemNombre="'+data[i]['nombrecliente']+'"><i class="fa fa-print text-success"></i></button></center>' ];
                    content.push( addData );
                }
            }  
        }
        else{
            for (let i = 0; i < data.length; i++ ){
                let fecha = data[ i ][ "fecha" ].split("-");
                if( fecha[ '0' ] == year ){
                    a = a + 1;
                    data[ i ][ "nombrecliente" ] = data[ i ][ "nombrecliente" ] == null ? "No registrado" : data[ i ][ "nombrecliente" ];
                    data[ i ][ "nrodoccliente" ] = data[ i ][ "nrodoccliente" ] == "" ? "No registrado" : data[ i ][ "nrodoccliente" ];
                    data[ i ][ "concepto" ] = data[ i ][ "concepto" ] == null ? "No registrado" : data[ i ][ "concepto" ];
                    let addData = [ a, data[ i ][ "seriecomprobante" ]+"-"+data[ i ][ "numerocomprobante" ], data[ i ][ "nombrecliente" ], data[ i ][ "nrodoccliente" ], data[ i ][ "entidadrecauda" ], fecha[ '2' ]+'-'+fecha[ '1' ]+'-'+fecha[ '0' ], data[ i ][ "monto" ], data[ i ][ "concepto" ], '<center><button class="btn btn-sm print_tesoreria" itemid="'+data[i]["nrodoccliente"]+'" itemButton="'+data[i]["nrooperacion"]+'" itemNombre="'+data[i]['nombrecliente']+'"><i class="fa fa-print text-success"></i></button></center>' ];
                    content.push( addData );
                }
            }
        }
    }
    else{
        if( month != 'todos' ){
            for (let i = 0; i < data.length; i++ ){
                let fecha = data[ i ][ "fecha" ].split("-");
                if( fecha[ '1' ] == month ){
                    a = a + 1;
                    data[ i ][ "nombrecliente" ] = data[ i ][ "nombrecliente" ] == null ? "No registrado" : data[ i ][ "nombrecliente" ];
                    data[ i ][ "nrodoccliente" ] = data[ i ][ "nrodoccliente" ] == "" ? "No registrado" : data[ i ][ "nrodoccliente" ];
                    data[ i ][ "concepto" ] = data[ i ][ "concepto" ] == null ? "No registrado" : data[ i ][ "concepto" ];
                    let addData = [ a, data[ i ][ "seriecomprobante" ]+"-"+data[ i ][ "numerocomprobante" ], data[ i ][ "nombrecliente" ], data[ i ][ "nrodoccliente" ], data[ i ][ "entidadrecauda" ], fecha[ '2' ]+'-'+fecha[ '1' ]+'-'+fecha[ '0' ], data[ i ][ "monto" ], data[ i ][ "concepto" ], '<center><button class="btn btn-sm print_tesoreria" itemid="'+data[i]["nrodoccliente"]+'" itemButton="'+data[i]["nrooperacion"]+'" itemNombre="'+data[i]['nombrecliente']+'"><i class="fa fa-print text-success"></i></button></center>' ];
                    content.push( addData );
                }
            }  
        }
        else
        {
            for (let i = 0; i < data.length; i++ ){
                a = i + 1;
                let fecha = data[ i ][ "fecha" ].split("-");
                data[ i ][ "nombrecliente" ] = data[ i ][ "nombrecliente" ] == null ? "No registrado" : data[ i ][ "nombrecliente" ];
                data[ i ][ "nrodoccliente" ] = data[ i ][ "nrodoccliente" ] == "" ? "No registrado" : data[ i ][ "nrodoccliente" ];
                data[ i ][ "concepto" ] = data[ i ][ "concepto" ] == null ? "No registrado" : data[ i ][ "concepto" ];
                let addData = [ a, data[ i ][ "seriecomprobante" ]+"-"+data[ i ][ "numerocomprobante" ], data[ i ][ "nombrecliente" ], data[ i ][ "nrodoccliente" ], data[ i ][ "entidadrecauda" ], fecha[ '2' ]+'-'+fecha[ '1' ]+'-'+fecha[ '0' ], data[ i ][ "monto" ], data[ i ][ "concepto" ], '<center><button class="btn btn-sm print_tesoreria" itemid="'+data[i]["nrodoccliente"]+'" itemButton="'+data[i]["nrooperacion"]+'" itemNombre="'+data[i]['nombrecliente']+'"><i class="fa fa-print text-success"></i></button></center>' ];
                content.push( addData );
        }
        }
    }
    return content;
}
function cleanData( data ){
    let flagData = 0;
    while( true ){
        let newData = data.filter( function(e){
        return e.nrooperacion == data[ "0" ][ "nrooperacion" ];
        } );
        let valInitial = newData[ "0" ];
        let dataConcepto = "-" + valInitial[ "concepto" ] + "." ;
        for( let z = 1; z < newData.length; z++ ){
            dataConcepto = dataConcepto + "<br>-" + newData[ z ][ "concepto" ] + "." ;
        }
        valInitial[ "concepto" ] = dataConcepto;
        data = removeDataRepeat( data, valInitial );
        data.push( valInitial );
        if( !data[ flagData + 1 ] ){
            console.log( data );
            console.log( flagData );
            break;
        }
        else{
            flagData++;
        }
    }
    return data;
}

function removeDataRepeat( arr, item ){
    return arr.filter( function(e){
        return e.nrooperacion != item[ "nrooperacion" ];
    } );
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