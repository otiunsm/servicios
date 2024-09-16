let length_typeDoc = 0;
var KTLogin100 = function() {
    var t, i = function(i) {
        var o = "login-" + i + "-on";
        i = "kt_login_" + i + "_form";
        t.removeClass("login-forgot-on"), t.removeClass("login-signin-on"), t.removeClass("login-signup-on"), t.addClass(o), KTUtil.animateClass(KTUtil.getById(i), "animate__animated animate__backInUp")
    };
    return {
        init: function() {
            var o;
            t = $("#kt_login"), o = FormValidation.formValidation(KTUtil.getById("kt_form_100"), {
                    fields: {
                        typeDoc: {
                            validators: {
                             notEmpty: {
                              message: 'Requerido.'
                             }
                            }
                        },
                        documentAntPol: {
                            validators:{
                                notEmpty: {
                                    message: 'Campo requerido'
                                },
                                digits:{
                                    message: 'Ingrese solo dígitos'
                                },
                                callback:{
                                    callback: function(input){
                                        let value_typeDoc = $( '#typeDoc' ).val();
                                        if ( value_typeDoc != '3' ){
                                            length_typeDoc = '8';
                                            if( input.value.length != '8' ){
                                                return {
                                                    valid: false,
                                                    message: 'Ingrese 8 caracteres.'
                                                };
                                            }
                                            else{
                                                return { valid:true };
                                            }
                                            
                                        }
                                        else{
                                            if( input.value.length != '9' ){
                                                return {
                                                    valid: false,
                                                    message: 'Ingrese 9 caracteres.'
                                                };
                                            }
                                            else{
                                                return { valid:true };
                                            }
                                            
                                        }
                                    },
                                },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        submitButton: new FormValidation.plugins.SubmitButton,
                        bootstrap: new FormValidation.plugins.Bootstrap
                    }
                }), $("#submitButtonAntPol").on("click", (function(t) {
                    $( '#alertAntPol' ).empty();
                    let dni = $('#documentAntPol').val();
                    let typeDoc = $( '#typeDoc' ).val();
                    t.preventDefault(), o.validate().then((function(t) {
                        if ('Valid' == t) {                           
                            $('#sninper').show();
                            $.ajax({
                                type: "get",
                                url: '../apis/apis_antecedentes_policiales',
                                data:{typeDoc, dni },
                                dataType: "json",
                                success: function(response){
                                let data = response.consultarPersonaNroDocResponse.RespuestaPersona;
                                $('#sninper').hide();
                                if( !Array.isArray( data ) ){
                                    if( data.codigoMensaje != '00' ){
                                        if( data.codigoMensaje=='16' ){
                                            $( '#alertAntPol' ).append( '<div class="alert alert-warning col-lg-5 mx-auto text-center my-4" role="alert">El usuario no cuenta con antecedentes policiales</div>' );
                                        }
                                        else{
                                            alertShow( data.codigoMensaje != "" ? data.codigoMensaje:"Desconocido" , data.descripcionMensaje != ""?data.descripcionMensaje:'Error desconocido' );
                                        }
                                    }
                                    else{
                                        // DNI: 23003792 | 10765508
                                        $( '#cardConsulta' ).hide();
                                        $('#formConsultaAntPol [name="typeDocConsult1"]').val(data.tipoDocumento != null ? data.tipoDocumento : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="docConsult"]').val(data.nroDocumento);
                                        $('#formConsultaAntPol [name="apConsult"]').val(data.apellidoPaterno != null ? data.apellidoPaterno : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="amConsult"]').val(data.apellidoMaterno != null ? data.apellidoMaterno : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="nomConsult"]').val(data.nombres != null ? data.nombres : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="nombrePadre"]').val(data.nombrePadre != null ? data.nombrePadre : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="nombreMadre"]').val(data.nombreMadre != null ? data.nombreMadre : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="codPersona"]').val(data.codigoPersona != null ? data.codigoPersona : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="dobIdentidad"]').val(data.dobleIdentidad != null ? data.dobleIdentidad : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="homonimia"]').val(data.homonimia != null ? data.homonimia : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="lugarNacimiento"]').val(data.lugarNacimiento != null ? data.lugarNacimiento : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="fechaNacimiento"]').val(data.fechaNacimiento != null ? data.fechaNacimiento : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="sexo"]').val(data.sexo != null ? data.sexo : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="talla"]').val(data.talla != null ? data.talla : 'SIN REGISTRO');
                                        $('#typeDocConsult2').val( obtainVal() );
                                        $('#doc').val( $('#formConsultaAntPol [name="docConsult"]').val() );
                                        $( '#consultAntePol' ).show();
                                    }
                                }
                                else{
                                     if( data['0'].codigoMensaje != '00' ){
                                        if( data[ '0' ].codigoMensaje=='16' ){
                                            $( '#alertAntPol' ).append( '<div class="alert alert-warning col-lg-5 mx-auto text-center my-4" role="alert">El usuario no cuenta con antecedentes policiales</div>' );
                                        }
                                        else{
                                            alertShow( data[ '0' ].codigoMensaje != "" ? data[ '0' ].codigoMensaje:"Desconocido" , data[ '0' ].descripcionMensaje != ""?data[ '0' ].descripcionMensaje:'Error desconocido' );
                                        }
                                    }
                                    else{
                                        // DNI: 23003792 | 10765508
                                        $( '#cardConsulta' ).hide();
                                        $('#formConsultaAntPol [name="typeDocConsult1"]').val(data[ '0' ].tipoDocumento != null ? data[ '0' ].tipoDocumento : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="docConsult"]').val(data[ '0' ].nroDocumento);
                                        $('#formConsultaAntPol [name="apConsult"]').val(data[ '0' ].apellidoPaterno != null ? data[ '0' ].apellidoPaterno : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="amConsult"]').val(data[ '0' ].apellidoMaterno != null ? data[ '0' ].apellidoMaterno : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="nomConsult"]').val(data[ '0' ].nombres != null ? data[ '0' ].nombres : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="nombrePadre"]').val(data[ '0' ].nombrePadre != null ? data[ '0' ].nombrePadre : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="nombreMadre"]').val(data[ '0' ].nombreMadre != null ? data[ '0' ].nombreMadre : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="codPersona"]').val(data[ '0' ].codigoPersona != null ? data[ '0' ].codigoPersona : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="dobIdentidad"]').val(data[ '0' ].dobleIdentidad != null ? data[ '0' ].dobleIdentidad : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="homonimia"]').val(data[ '0' ].homonimia != null ? data[ '0' ].homonimia : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="lugarNacimiento"]').val(data[ '0' ].lugarNacimiento != null ? data[ '0' ].lugarNacimiento : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="fechaNacimiento"]').val(data[ '0' ].fechaNacimiento != null ? data[ '0' ].fechaNacimiento : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="sexo"]').val(data[ '0' ].sexo != null ? data[ '0' ].sexo : 'SIN REGISTRO');
                                        $('#formConsultaAntPol [name="talla"]').val(data[ '0' ].talla != null ? data[ '0' ].talla + " cm" : 'SIN REGISTRO');
                                        $('#typeDocConsult2').val( obtainVal() );
                                        $('#doc').val( $('#formConsultaAntPol [name="docConsult"]').val() );
                                        $( '#consultAntePol' ).show();

                                    }
                                }
                                // if(!response.message ){
                                //     $( '#cardConsulta' ).hide();
                                //     $( '#tableConsulta' ).show();
                                //     response.results = cleanData( response.results );
                                //     $('#tableTesoreria').DataTable( {
                                //         responsive: !0,
                                //         pagingType: "full_numbers",
                                //         destroy:true,
                                //         data: createTable(response.results),
                                //         columns: [
                                //             { title: "#" },
                                //             { title: "N° Boleta" },
                                //             { title: "Nombre Completo" },
                                //             { title: "N° Documento" },
                                //             { title: "Entidad de Recaudación" },
                                //             { title: "Fecha de Pago" },
                                //             { title: "Monto de Pago" },
                                //             { title: "Concepto" },
                                //             { title: "Imprimir" }
                                //         ]
                                //     } );
                                // }
                                // else{
                                //     console.log( response );
                                //     alertShow( "No hay información disponible", "");
                                // }
                                
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
function obtainVal(){
        let optionValue = $('#typeDoc option');
        for (let i = 0; i < optionValue.length ; i++) {
            if( optionValue[ i ].selected ){
                return optionValue[ i ].value;
            }
        }
    }
jQuery(document).ready((function() {
    KTLogin100.init();
    $( '#tableConsulta' ).hide();
    $( document ).on( "click", ".print_antecedentespoliciales", function( e ){
        e.preventDefault();
        let typeD = $('#typeDocConsult2').val();
        let D = $('#doc').val();
        window.open('../pdfreporte/reporte_antecedentespoliciales/'+typeD+'/'+D);  
    } );
}));
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