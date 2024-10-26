<!--begin::Content-->
<style>
    #hiddeninput {
        display: none;
        /* Ocultar el contenedor por defecto */
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
                    <table class="table table-separate table-head-custom table-checkable table-sm " id="kt_datatable">
                    <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>N° CARTA</th>
                                <th>DETALLE ACTIVIDAD</th>
                                <th>FECHA REGISTRO</th>
                                <th>TIPO DOC</th>
                                <th>DEPENDENCIA</th>
                                <th>SOLICITANTE</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Falta El proceso -->
                            <?php
                            if ($Act_registro) {
                                foreach ($Act_registro as $key => $registro) {
                                    $arrayMod = [];
                                    echo '
                                    <tr>
                                     
                                        <td>' . $registro['idregistro'] . '</td>
                                        <td>' . $registro['nro_carta'] . '</td>
                                        <td>' . $registro['detalle_actividad'] . '</td>
                                        <td>' . $registro['fec_registro'] . '</td>
                                        <td>' . $registro['tipo_doc'] . '</td>
                                        <td>' . $registro['nombre_dep'] . '</td>
                                        <td>' . $registro['nombre_so'] . '</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm" id="buttonUserEdit" itemButton="'.$registro['idregistro'].'"><i class="fas fa-edit text-success"></i></i></button>
                                                <button class="btn btn-sm" id="buttonDelete" itemButton="'.$registro['idregistro'].'"> <i class="fas fa-trash text-danger"></i></i></button>
                                            </div>
                                        </td>
                                    </tr>';
                                }
                            }
                            ?>

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
            <form method="POST" action="Act_registro/formData" id="form_registro">
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleSelect1">SOLICITANTE<span class="text-danger">*</span></label>
                                    <select class="form-control" id="nombre_so" name="nombre_so">
                                        <option selected disabled>Seleccione...</option>
                                    </select>
                                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formSoli">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button> -->
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex align-items-center">
                                <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#formCate">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    Agregar solicitante
                                </button>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="sgd">POR SGD<span class="text-danger">*</span></label>
                                    <select class="form-control" id="sgd" name="SGD">
                                        <option selected value="1">OTRO</option>
                                        <option value="2">SGD</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleSelect1">DEPENDENCIA<span class="text-danger">*</span></label>
                                    <select class="form-control" id="nombre_dep" name="nombre_dep">
                                        <option selected disabled>Seleccione...</option>
                                        <!-- falta -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>FECHA DE REGISTRO <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="fec_registro" name="fec_registro"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" id="hiddeninput" style="display: none;">
                        <div class="row">

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="tipoDoc">TIPO DOCUMENTO<span class="text-danger">*</span></label>
                                    <select class="form-control" id="tipoDoc" name="tipoDoc">
                                        <option value="1">PROVEIDO</option>
                                        <option value="2">NINGUNO</option>
                                    </select>
                                </div>
                            </div>

                            <!-- NRO DOC -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nroDoc">N° DOC/CARTA/OTROS<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nro_carta" name="nro_carta"  />

                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="nroDoc">FECHA DOC SGD<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="fec_doc_sgd" name="fec_doc_sgd" />

                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="exampleSelect1">TIPO ASISTENCIA<span class="text-danger">*</span></label>
                                    <select class="form-control" id="nombre" name="nombre">
                                        <option value="ani desk"> ANI DESK</option>
                                        <option value="presencial">PRESENCIAL</option>
                                        <option value="llamada">LLAMADA</option>
                                        <!-- falta -->
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6" id="tipo_asistencia_container">
                                <div class="form-group">
                                    <label for="tipo_asistencia">TIPO ASISTENCIA<span class="text-danger">*</span></label>
                                    <select class="form-control" id="nombre" name="nombre">
                                        <option value="ani desk"> ANI DESK</option>
                                        <option value="presencial">PRESENCIAL</option>
                                        <option value="llamada">LLAMADA</option>
                                        <!-- falta -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="medio_solicitud_container">
                                <div class="form-group">
                                    <label for="medioSolicitud">MEDIO DE SOLICITUD<span class="text-danger">*</span></label>
                                    <select class="form-control" id="nombre_solicitud" name="nombre_solicitud">
                                        <option value="ani desk">POR LLAMADA</option>
                                        <option value="presencial">POR PEDIDO DEL JEFE OTI</option>
                                        <option value="llamada">POR CORREO</option>
                                        <!-- falta -->
                                    </select>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="exampleSelect1">CATEGORIA ACTIVIDAD<span class="text-danger">*</span></label>
                                    <select class="form-control" id="nombre_c" name="nombre_c">
                                        <option selected disabled></option>
                                        <!-- falta -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>DETALLE DE ACTIVIDAD<span class="text-danger">*</span></label>
                                    <input type="textarea" class="form-control" id="detalle_actividad" name="detalle_actividad" placeholder="Detalle de actividad" />
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitButton2" class="btn btn-success font-weight-bold">Guardar</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =================================================================================0
==============================FORMULARIO DE REGISTRO DE PERSONAS==================
================================================================================= -->

<!-- <div class="modal fade" id="formAct" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title text-center bg-success" id="exampleModalLabel">Formulario de Actividades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="Act_registro/registrarActividad" id="form_registro">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="hidden" name="id_item">
                            <div class="form-group">
                                <label>DNI <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="dni_solicitante" placeholder="DNI" />
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success btn-flat" onclick="">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Nombre(s) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre_solicitante" placeholder="Ingrese el nombre" />
                            </div>
                        </div>

                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Direccion<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="direccion" placeholder="Direccion" />
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Celular <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" name="telefono" placeholder="Ingrese número de celular" />
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="Ingrese un correo electrónico" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitButton2" class="btn btn-success font-weight-bold">Guardar</button>
                        <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                    </div>
            </form>
        </div>
    </div>
</div> -->


<script>
    const sgdSelect = document.getElementById('sgd');
    const hiddeninput = document.getElementById('hiddeninput');
    //nuevo
    const tipoAsistencia = document.getElementById('tipo_asistencia_container');
    const medioSolicitud = document.getElementById('medio_solicitud_container');
    // Función para manejar el cambio de selección
    sgdSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        if (selectedValue === '2') {
            hiddeninput.style.display = 'block'; // Mostrar si es 'SGD'
            //nuevo agregado
            tipoAsistencia.style.display = 'none';
            medioSolicitud.style.display = 'none';
            /*********** */
        } else if (selectedValue === '1') {
            hiddeninput.style.display = 'none'; // Ocultar si es 'OTRO'
            //nuevo agregado
            tipoAsistencia.style.display = 'block';
            medioSolicitud.style.display = 'block';
            /*********** */

        }
    });

    // Asegurarse de que el contenedor esté oculto inicialmente
    hiddeninput.style.display = 'none';
    //nuevo agregado
    tipoAsistencia.style.display = 'none';
    medioSolicitud.style.display = 'none';
    /*********** */
</script>