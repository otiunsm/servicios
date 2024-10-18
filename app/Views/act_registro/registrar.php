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
                            <span class="d-block text-muted pt-2 font-size-sm">Tabla de Actividades</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#formAct"><i class="fas fa-user-plus"></i> Nuevo Registro</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-sm table-striped table-bordered dt-responsive nowrap" id="kt_datatable">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>N° CARTA</th>
                                <th>DETALLE ACTIVIDAD</th>
                                <th>FECHA REGISTRO</th>
                                <th>TIPO DOC</th>
                                <th>DEPENDENCIA</th>
                                <th>SOLICITANTE</th>
                                <th>TIPO ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Falta El proceso -->
                            <?php
                            if ($Act_Registrar) {
                                foreach ($Act_Registrar as $key => $registro) {
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
                                        <td>' . $registro['tipo_estado'] . '</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm" id="buttonEdit" itemButton="'.$registro['idregistro'].'"><i class="fa fa-user-edit text-success"></i></button>
                                                <button class="btn btn-sm" id="buttonDelete" itemButton="'.$registro['idregistro'].'"><i class="fas fa-user-times text-danger"></i></button>
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
<div class="modal fade" id="formAct" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Actividades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="ki ki-close" aria-hidden="true"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('/Act_Registrar/guardar') ?>" id="form_registro">
                <div class="modal-body">
                    <div class="row">
                        <!-- DNI Solicitante -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="solicitante">DNI <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="dni_solicitante"
                                    placeholder="Documento Nacional de Identidad" required />
                            </div>
                        </div>

                        <!-- NOMBRE -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="solicitante">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre_solicitante"
                                    placeholder="Nombre del solicitante" required />
                            </div>
                        </div>


                        <!-- EMAIL -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="solicitante">Email <span class="text-danger"></label>
                                <input type="text" class="form-control" name="email"
                                    placeholder="Correo del solicitante" />
                            </div>
                        </div>

                        <!-- Telefono -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="solicitante">Telefono <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telefono"
                                    placeholder="Telefono del solicitante" required />
                            </div>
                        </div>



                        <!-- CARGO -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="solicitante">Cargo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="cargo" placeholder="Cargo del solicitante"
                                    required />
                            </div>
                        </div>

                        <!-- Dependencia -->
                        <!-- <div class="col-lg-4">
                            <div class="form-group">
                                <label for="dependencia">Dependencia <span class="text-danger">*</span></label>
                                <select class="form-control" id="dependencia" name="perfil" required>
                                    <option selected disabled>Seleccione...</option> -->
                        <!-- Options here -->
                        <!-- </select>
                            </div>
                        </div> -->

                        <!-- Por SGD -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="sgd">Por SGD <span class="text-danger">*</span></label>
                                <select class="form-control" id="sgd" name="SGD" required>
                                    <option selected value="1">OTRO</option>
                                    <option value="2">SGD</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Conditional fields for SGD -->
                    <div class="row" id="hiddeninput" style="display: none;">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tipoDoc">Tipo Documento <span class="text-danger">*</span></label>
                                <select class="form-control" id="tipoDoc" name="tipoDoc" required>
                                    <option selected disabled>Proveido</option>
                                    <option value="">no</option>
                                    <!-- Options here -->
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="numero">Nro Doc <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="numero" name="numero"
                                    placeholder="Ingrese número de documento" required />
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="fecha">Fecha <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required />
                            </div>
                        </div>
                    </div>

                    <!-- Medio Solicitud -->
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="medioSolicitud">Tipo de Estado <span class="text-danger">*</span></label>
                                <select class="form-control" id="tipo_estado" name="tipo_estado" required>
                                    <option value="R" selected>RECIBIDO</option>
                                    <option value="P">PENDIENTE</option>
                                    <option value="C">COMPLETADO</option>
                                </select>
                            </div>
                        </div>



                        <!-- Tipo Asistencia -->

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tipoAsistencia">Tipo Asistencia <span class="text-danger">*</span></label>
                                <select class="form-control" id="tipoAsistencia" name="tipo_asistencia" required>
                                    <option selected disabled>Seleccione...</option>
                                    <option value="">Remota</option>
                                    <option value="">Presencial</option>

                                </select>
                            </div>
                        </div>



                        <!-- Detalle de Actividad -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="detalleActividad">Detalle de actividad <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="detalleActividad" name="detalle_actividad"
                                        placeholder="Describa la actividad" rows="3" required></textarea>
                                </div>
                            </div>
                            <!-- Obsercvacion -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="observacion">Observacion <span class="text-danger"></label>
                                    <input type="text" class="form-control" name="observacion" id="observacion"
                                        placeholder="Correo del solicitante" />
                                </div>
                            </div>
                            <!-- Fecha Registro -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="fechaRegistro">Fecha Registro <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="fechaRegistro" name="fec_registro"
                                        required />
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="submitButton2"
                            class="btn btn-success font-weight-bold">Guardar</button>
                        <button type="button" class="btn btn-light-danger font-weight-bold"
                            data-dismiss="modal">Cancelar</button>
                    </div>
            </form>
        </div>
    </div>
</div>


<!-- =================================================================================0
==============================FORMULARIO DE REGISTRO DE PERSONAS==================
================================================================================= -->

<div class="modal fade" id="formAct" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title text-center bg-success" id="exampleModalLabel">Formulario de Actividades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('/Act_Registrar/guardar') ?>" id="form_registro">
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
                                <input type="text" class="form-control" name="nombre_solicitante"
                                    placeholder="Ingrese el nombre" />
                            </div>
                        </div>

                        <!-- <div class="col-lg-4">
                            <div class="form-group">
                                <label>Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="apellidos" placeholder="Ingrese los apellidos" />
                            </div>
                        </div> -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Direccion<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="direccion" placeholder="Direccion" />
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Celular <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" name="telefono"
                                    placeholder="Ingrese número de celular" />
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email"
                                    placeholder="Ingrese un correo electrónico" />
                            </div>
                        </div>

                        <!-- <div class="col-lg-4">
                            <div class="form-group">
                                <label>Dependencia</label>
                                <input type="text" class="form-control" name="direccion" placeholder="Ingrese la dirección" />
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitButton2"
                            class="btn btn-success font-weight-bold">Guardar</button>
                        <button type="button" class="btn btn-light-danger font-weight-bold"
                            data-dismiss="modal">Cancelar</button>
                    </div>
            </form>
        </div>
    </div>
</div>


<script>
const sgdSelect = document.getElementById('sgd');
const hiddeninput = document.getElementById('hiddeninput');

// Función para manejar el cambio de selección
sgdSelect.addEventListener('change', function() {
    const selectedValue = this.value;
    if (selectedValue === '2') {
        hiddeninput.style.display = 'block'; // Mostrar si es 'SGD'
    } else if (selectedValue === '1') {
        hiddeninput.style.display = 'none'; // Ocultar si es 'OTRO'
    }
});

// Asegurarse de que el contenedor esté oculto inicialmente
hiddeninput.style.display = 'none';
</script>