<style>
    #hiddeninput {
        display: none;
        /* Ocultar el contenedor por defecto */
    }

    .letra tr td,
    .letra tr th {
        font-size: 9pt ! important;
    }
  
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Gestionar Actividades</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>" class="text-muted">Panel de Control</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Actividades
                            <!-- <span class="d-block text-muted pt-2 font-size-sm">Tabla de Actividades</span> -->
                        </h3>
                    </div>

                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formAct"><i class="fas fa-user-plus"></i> Nuevo Registro</button>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div class="row mb-3 ">
                        <div class="col-md-2 ">
                            
                            <label for="fechainicio" class="form-label">FECHA INICIO</label>
                            <input type="date" id="fechainicio" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2">
                            <label for="fechafin" class="form-label">FECHA FIN</label>
                            <input type="date" id="fechafin" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 align-self-end">
                            <button id="filtrar" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                        </div>
                    </div>

                    <table class="table table-separate table-head-custom table-checkable table-sm letra " id="kt_datatable1">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>N° CARTA</th>
                                <th>CATEGORIA</th>
                                <th>DETALLE ACTIVIDAD</th>
                                <th>F. REGISTRO</th>
                                <th>TIP SOLICITUD</th>
                                <th>DEPENDENCIA</th>
                                <th>SOLICITANTE</th>
                                <th>ESTADO ACTUAL</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->
<div class="modal fade" id="formAct" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header ">
                <h5 class="modal-title " id="exampleModalLabel">FORMULARIO DE ACTIVIDADES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" id="act_registrar">
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <input type="hidden" id="idregistro" name="idregistro">
                                    <label for="nombre_so">SOLICITANTE<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="id_solicitante" name="id_solicitante">
                                        </select>
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn-sm btn btn-primary" onclick="agregarSolicitante()">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="sgd">TIPO SOLICITUD<span class="text-danger">*</span></label>
                                    <select class="form-control" id="tipo_solicitud" name="tipo_solicitud">
                                        <option selected value="NINGUNO">NINGUNO</option>
                                        <option value="SGD">SGD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12" id="hiddeninput" style="display: none;">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="tipoDoc">TIPO DOC<span class="text-danger">*</span></label>
                                            <select class="form-control" id="tipo_doc" name="tipo_doc">
                                                <option selected value="-">SELECCIONE...</option>
                                                <option value="PROVEIDO">PROVEIDO</option>
                                                <option value="NINGUNO">NINGUNO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- NRO DOC -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="nroDoc">N° DOC/CARTA/OTROS<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nro_carta" name="nro_carta" />

                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="nroDoc">FECHA DOC SGD<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="fec_doc_sgd" name="fec_doc_sgd" />

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleSelect1">DEPENDENCIA<span class="text-danger">*</span></label>
                                    <select class="form-control selecdep" id="id_dependencia" name="id_dependencia">
                                        <option selected disabled>SELECCIONE...</option>
                                        <!-- falta -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>FECHA DE ATENCION <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="fec_atencion" name="fec_atencion" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tipo_asistencia">TIPO ASISTENCIA<span class="text-danger">*</span></label>
                                    <select class="form-control" id="tipo_asistencia" name="tipo_asistencia">
                                        <option value="REMOTO"> REMOTO</option>
                                        <option value="PRESENCIAL">PRESENCIAL</option>
                                        <option value="EN_OTI">EN LA OTI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="medio_solicitud">MEDIO DE SOLICITUD<span class="text-danger">*</span></label>
                                    <select class="form-control" id="medio_solicitud" name="medio_solicitud">
                                        <option selected value="-">SELECCIONE...</option>
                                        <option value="POR_LLAMADA">POR LLAMADA</option>
                                        <option value="POR_PEDIDO_JEFE_OTI">POR PEDIDO DEL JEFE OTI</option>
                                        <option value="POR_CORREO">POR CORREO</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleSelect1">CATEGORIA ACTIVIDAD<span class="text-danger">*</span></label>
                                    <select class="form-control" id="id_categoria_actividad" name="id_categoria_actividad">
                                        <option selected disabled>SELECCIONE...</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="estado_r">ESTADO ACTUAL<span class="text-danger">*</span></label>
                                    <select class="form-control" id="estado_r" name="estado_r">
                                        <option value="1">RECIBIDO</option>
                                        <option value="2">PENDIENTE</option>
                                        <option value="3">ATENDIDO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="validationTextarea" class="form-label">DETALLE DE ACTIVIDAD<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="detalle_actividad" name="detalle_actividad" placeholder="DETALLE DE ACTIVIDAD"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="validationTextarea" class="form-label">OTRAS ATENCIONES<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="otras_atenciones" name="otras_atenciones" placeholder="OTRAS ATENCIONES"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="validationTextarea" class="form-label">OBSERVACION<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="observacion" name="observacion" placeholder="Observaciones"></textarea>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success font-weight-bold" onclick="GuardarEditar()">Guardar</button>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal de registrar solicitante -->

<?php echo view('act_registro/ModalSoli'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap',
            placeholder: 'Select an option',
            allowClear: true,
            width: '80%',
        });
    });

    //select dependencias
    $(document).ready(function() {
        $('.selecdep').select2({
            theme: 'bootstrap',
            placeholder: 'Select an option',
            allowClear: true,
            width: '80%',
        });
    });
</script>
<script>

</script>