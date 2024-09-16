"use strict";
var KTLogin = function() {
    var t, i = function(i) {
        var o = "login-" + i + "-on";
        i = "kt_login_" + i + "_form";
        t.removeClass("login-forgot-on"), t.removeClass("login-signin-on"), t.removeClass("login-signup-on"), t.addClass(o), KTUtil.animateClass(KTUtil.getById(i), "animate__animated animate__backInUp")
    };
    return {
        init: function() {
            var o;
            t = $("#kt_login"), o = FormValidation.formValidation(KTUtil.getById("kt_form_1"), {
                    fields: {
                        dni: {
                            validators: {
                             notEmpty: {
                              message: 'El campo es requerido.'
                             },
                             digits: {
                              message: 'Ingresar solo números.'
                             },
                             stringLength: {
                              min:8,
                              max:8,
                              message: 'Ingrese 8 digitos por favor.'
                             }
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        submitButton: new FormValidation.plugins.SubmitButton,
                        bootstrap: new FormValidation.plugins.Bootstrap
                    }
                }), $("#submitButton").on("click", (function(t) {
                    let dni_consult = $('[name="dni"]').val();
                    t.preventDefault(), o.validate().then((function(t) {
                        if ('Valid' == t) {                           
                            $('#sninper').show();
                            $.ajax({
                                type: "get",
                                url: '../apis/apis_reniec',
                                data:{dni_consult},
                                dataType: "json",
                                success: function(response){
                                console.log('response :', response);
                                    var data = response.result[0];
                                        if (data.coResultado == '0000') {
                                            $('#cardConsulta').hide();
                                            $('#formConsulta [name="codConsult"]').val(data.coResultado);
                                            $('#formConsulta [name="dniConsult"]').val(dni_consult);
                                            $('#formConsulta [name="apConsult"]').val(data.apPrimer);
                                            $('#formConsulta [name="amConsult"]').val(data.apSegundo);
                                            $('#formConsulta [name="nomConsult"]').val(data.prenombres);
                                            $('#formConsulta [name="estaConsult"]').val(data.estadoCivil);
                                            $('#formConsulta [name="ubiConsult"]').val(data.ubigeo);
                                            $('#formConsulta [name="dirConsult"]').val(data.direccion);
                                            $('#formConsulta [name="dni"]').val(dni_consult);
                                            $('#formConsulta #imgConsul').attr('src','data:image/png;base64,'+data.foto);
                                            $('#cardResult').show();
                                        }else{
                                            // alert(data.coResultado+' '+data.deResultado);
                                            $('#sninper').hide();
                                            alertShow(data.coResultado, data.deResultado);
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
    KTLogin.init()
}));

// 

"use strict";
var KTLoginRuc = function() {
    var t, i = function(i) {
        var o = "login-" + i + "-on";
        i = "kt_login_" + i + "_form";
        t.removeClass("login-forgot-on"), t.removeClass("login-signin-on"), t.removeClass("login-signup-on"), t.addClass(o), KTUtil.animateClass(KTUtil.getById(i), "animate__animated animate__backInUp")
    };
    return {
        init: function() {
            var o;
            t = $("#kt_login"), o = FormValidation.formValidation(KTUtil.getById("kt_form_ruc"), {
                    fields: {
                        ruc: {
                            validators: {
                             notEmpty: {
                              message: 'El campo es requerido.'
                             },
                             digits: {
                              message: 'Ingresar solo números.'
                             },
                             stringLength: {
                              min:11,
                              max:11,
                              message: 'Ingrese 11 digitos por favor.'
                             }
                            }
                        },
                        opcion:{
                            validators: {
                                notEmpty:{
                                    message: 'Seleccione una opción.'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        submitButton: new FormValidation.plugins.SubmitButton,
                        bootstrap: new FormValidation.plugins.Bootstrap
                    }
                }), $("#submitButtonRuc").on("click", (function(t) {
                    let ruc_consult = $('[name="ruc"]').val();
                    let opcion = $('[name="opcion"]').val();
                    t.preventDefault(), o.validate().then((function(t) {
                        if ('Valid' == t) {                           
                            $('#sninper').show();
                            $.ajax({
                                type: "get",
                                url: '../apis/apis_ruc',
                                data:{ruc_consult, opcion},
                                dataType: "json",
                                success: function(response){

                                    switch (opcion) {
                                        case 'DatosPrincipales':
                                            if (response.getDatosPrincipales[0].ddp_numruc) {
                                                let getDP = response.getDatosPrincipales[0];
                                                let esActivo = getDP.esActivo?'ACTIVO':'NO ACTIVO';
                                                let esHabido = getDP.esHabido?'HABIDO':'NO HABIDO';
                                                $('#cardResult [name="ruc_number"]').val(ruc_consult);
                                                $('#cardResult [name="opcion_print"]').val(opcion);
                                                $('#cardResult #title_ruc').html('Datos Principales del Contribuyente');
                                                $('#cardResult #collapseOne7').html(
                                                    `<div class="row">
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Número de RUC </label>
                                                            <input type="text" value="`+getDP.ddp_numruc+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Nombre o Razón Social</label>
                                                            <input type="text" value="`+getDP.ddp_nombre+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Descripción de tipo de persona</label>
                                                            <input type="text" value="`+getDP.desc_identi+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Código de actividad económica</label>
                                                            <input type="text" value="`+getDP.ddp_ciiu+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Descripción de actividad económica</label>
                                                            <input type="text" value="`+getDP.desc_ciiu+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Descripción de contribuyente</label>
                                                            <input type="text" value="`+getDP.desc_tpoemp+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Descripción de departamento</label>
                                                            <input type="text" value="`+getDP.desc_dep+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Descripción de provincia</label>
                                                            <input type="text" value="`+getDP.desc_prov+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Descripción de distrito</label>
                                                            <input type="text" value="`+getDP.desc_dist+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Descripción del estado del contribuyente</label>
                                                            <input type="text" value="`+getDP.desc_estado+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Fecha y hora de actualización</label>
                                                            <input type="text" value="`+getDP.ddp_fecact+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Fecha de alta</label>
                                                            <input type="text" value="`+getDP.ddp_fecalt+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Fecha de baja </label>
                                                            <input type="text" value="`+getDP.ddp_fecbaj+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Descripción de tipo de vía</label>
                                                            <input type="text" value="`+getDP.desc_tipvia+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Nombre de la vía</label>
                                                            <input type="text" value="`+getDP.ddp_nomvia+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Número</label>
                                                            <input type="text" value="`+getDP.ddp_numer1+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Referencia de ubicación</label>
                                                            <input type="text" value="`+getDP.ddp_refer1+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Condición del domicilio</label>
                                                            <input type="text" value="`+getDP.desc_flag22+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Descripción de la dependencia</label>
                                                            <input type="text" value="`+getDP.desc_numreg+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Interior</label>
                                                            <input type="text" value="`+getDP.ddp_inter1+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Nombre de la zona</label>
                                                            <input type="text" value="`+getDP.ddp_nomzon+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Descripción de tipo de zona</label>
                                                            <input type="text" value="`+getDP.desc_tipzon+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Libreta Tributaria</label>
                                                            <input type="text" value="`+getDP.ddp_lllttt+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Estado Activo</label>
                                                            <input type="text" value="`+esActivo+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Estado Habido</label>
                                                            <input type="text" value="`+esHabido+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </div>`
                                                );
                                                $('#sninper').hide();
                                                $('#cardConsulta').hide();
                                                $('#cardResult').show();
                                            }else{
                                                $('#sninper').hide();
                                                alertShow('404', 'El número de RUC es inválido');
                                            }
                                        break;

                                        case 'DatosSecundarios':
                                            let getDS = response.getDatosSecundarios[0];
                                            if (getDS.dds_numruc) {
                                                $('#cardResult [name="ruc_number"]').val(ruc_consult);
                                                $('#cardResult [name="opcion_print"]').val(opcion);
                                                $('#cardResult #title_ruc').html('Datos Secundarios del Contribuyente');
                                                $('#cardResult #collapseOne7').html(`
                                                <div class="row">
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Número de RUC</label>
                                                        <input type="text" value="`+getDS.dds_numruc+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Nombre comercial</label>
                                                        <input type="text" value="`+getDS.dds_nomcom+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Origen de la entidad</label>
                                                        <input type="text" value="`+getDS.desc_orient+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Nacionalidad</label>
                                                        <input type="text" value="`+getDS.dds_nacion+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Sexo</label>
                                                        <input type="text" value="`+getDS.desc_sexo+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Número de pasaporte</label>
                                                        <input type="text" value="`+getDS.dds_pasapo+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Carnet patronal</label>
                                                        <input type="text" value="`+getDS.dds_patron+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Número de teléfono</label>
                                                        <input type="text" value="`+getDS.dds_telef1+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Actividad Comercio E.</label>
                                                        <input type="text" value="`+getDS.desc_comext+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Tipo de contabilidad</label>
                                                        <input type="text" value="`+getDS.desc_contab+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Tipo de documento de identidad</label>
                                                        <input type="text" value="`+getDS.desc_docide+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Condición de domiciliado</label>
                                                        <input type="text" value="`+getDS.desc_domici+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Tipo de facturación</label>
                                                        <input type="text" value="`+getDS.desc_factur+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Inicio de actividades</label>
                                                        <input type="text" value="`+getDS.dds_inicio+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Licencia municipal</label>
                                                        <input type="text" value="`+getDS.dds_licenc+`" class="form-control" disabled="disabled"/>
                                                    </div>
                                                </div>
                                            </div>
                                                `);
                                                $('#sninper').hide();
                                                $('#cardConsulta').hide();
                                                $('#cardResult').show();
                                                
                                            } else {
                                                $('#sninper').hide();
                                                alertShow('404', 'El número de RUC es inválido');
                                            }
                                        break;

                                        case 'DatosT1144':
                                            let getDA = response.getDatosT1144[0];
                                            if (getDA.num_ruc) {
                                                $('#cardResult [name="ruc_number"]').val(ruc_consult);
                                                $('#cardResult [name="opcion_print"]').val(opcion);
                                                $('#cardResult #title_ruc').html('Datos Adicionales del Contribuyente');
                                                $('#cardResult #collapseOne7').html(`
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label>Código de actividad económica II</label>
                                                                <input type="text" value="`+getDA.cod_ciiu2+`" class="form-control" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label>Actividad económica II</label>
                                                                <input type="text" value="`+getDA.des_ciiu2+`" class="form-control" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label>Código de actividad económica III</label>
                                                                <input type="text" value="`+getDA.cod_ciiu3+`" class="form-control" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label>Actividad económica III</label>
                                                                <input type="text" value="`+getDA.des_ciiu3+`" class="form-control" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label>Correo electrónico</label>
                                                                <input type="text" value="`+getDA.cod_correo1+`" class="form-control" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label>Descripción de departamento</label>
                                                                <input type="text" value="`+getDA.des_depar1+`" class="form-control" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label>Condición legal a domicilio</label>
                                                                <input type="text" value="`+getDA.des_conleg+`" class="form-control" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label>Fecha de confirmación de correo</label>
                                                                <input type="text" value="`+getDA.fec_confir1+`" class="form-control" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                `);
    
                                                $('#sninper').hide();
                                                $('#cardConsulta').hide();
                                                $('#cardResult').show();
                                            } else {
                                                $('#sninper').hide();
                                                alertShow('404', 'El número de RUC es inválido o no hay datos dispobibles.');
                                            }
                                        break
                                        case 'DatosT362':
                                            let getDA_2 = response.getDatosT362[0];
                                            if (getDA_2.t362_numruc) {
                                                $('#cardResult [name="ruc_number"]').val(ruc_consult);
                                                $('#cardResult [name="opcion_print"]').val(opcion);
                                                $('#cardResult #title_ruc').html('Datos Complementarios del Contribuyente');
                                                $('#cardResult #collapseOne7').html(`
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Oficina RRPP</label>
                                                            <input type="text" value="`+getDA_2.desc_numreg+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Fecha de actualización</label>
                                                            <input type="text" value="`+getDA_2.t362_fecact+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Fecha Baja</label>
                                                            <input type="text" value="`+getDA_2.t362_fecbaj+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Número de índice</label>
                                                            <input type="text" value="`+getDA_2.t362_indice+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Nombre de la empresa</label>
                                                            <input type="text" value="`+getDA_2.t362_nombre+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Número de registro</label>
                                                            <input type="text" value="`+getDA_2.t362_numreg+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                `);

                                                $('#sninper').hide();
                                                $('#cardConsulta').hide();
                                                $('#cardResult').show();
                                            } else {
                                                $('#sninper').hide();
                                                alertShow('404', 'El número de RUC es inválido o no hay datos dispobibles.');
                                            }
                                        break
                                        case 'DomicilioLegal':
                                            let getDL = response.getDomicilioLegal[0];
                                            if (getDL.getDomicilioLegalReturn) {
                                                $('#cardResult [name="ruc_number"]').val(ruc_consult);
                                                $('#cardResult [name="opcion_print"]').val(opcion);
                                                $('#cardResult #title_ruc').html('Domicilio Legal');
                                                $('#cardResult #collapseOne7').html(`
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label>Domicilio legal</label>
                                                            <input type="text" value="`+getDL.getDomicilioLegalReturn+`" class="form-control" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                `);

                                                $('#sninper').hide();
                                                $('#cardConsulta').hide();
                                                $('#cardResult').show();
                                            } else {
                                                $('#sninper').hide();
                                                alertShow('404', 'El número de RUC es inválido o no hay datos dispobibles.');
                                            }
                                        break
                                        case 'RepLegales':
                                            let getRL = response.getRepLegales;
                                            if (getRL != null) {
                                                $('#cardResult [name="ruc_number"]').val(ruc_consult);
                                                $('#cardResult [name="opcion_print"]').val(opcion);
                                                $('#cardResult #title_ruc').html('Representantes Legales');
                                                getRL.forEach(element => {                                                    
                                                    $('#cardResult #collapseOne7').append(`
                                                        <div class="row">
                                                            <div class="col-lg-3 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Número de RUC Entidad</label>
                                                                    <input type="text" value="`+element.rso_numruc+`" class="form-control" disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Nombre del representante</label>
                                                                    <input type="text" value="`+element.rso_nombre+`" class="form-control" disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Cargo</label>
                                                                    <input type="text" value="`+element.rso_cargoo+`" class="form-control" disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Fecha ocupación del cargo</label>
                                                                    <input type="text" value="`+element.rso_vdesde+`" class="form-control" disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Tipo de documento</label>
                                                                    <input type="text" value="`+element.desc_docide+`" class="form-control" disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Número de documento</label>
                                                                    <input type="text" value="`+element.rso_nrodoc+`" class="form-control" disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Fecha y hora de actualización</label>
                                                                    <input type="text" value="`+element.rso_fecact+`" class="form-control" disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Fecha de nacimiento</label>
                                                                    <input type="text" value="`+element.rso_fecnac+`" class="form-control" disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    `);
                                                });

                                                $('#sninper').hide();
                                                $('#cardConsulta').hide();
                                                $('#cardResult').show();
                                            } else {
                                                $('#sninper').hide();
                                                alertShow('404', 'El número de RUC es inválido o no hay datos dispobibles.');
                                            }
                                        break
                                        default:
                                            $('#sninper').hide();
                                            alertShow('404', 'El número de RUC es inválido o no hay datos dispobibles.');
                                        break;
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
    KTLoginRuc.init()
}));

// 

function alertShow(typeerror, error, msg) {
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
      if( typeerror ){
        toastr.warning( msg );
      }
      else{
        toastr.error("Error: "+error, msg);
      }
}

function AlertSw(itemButton) {
    Swal.fire({
        title: "¿Desea eliminar este registro?",
        text: "Esta acción es irreversible",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            window.location = window.location+'/eliminar/'+itemButton;
        }
    });
}
