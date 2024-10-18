<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Listado usuarios</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url()?>" class="text-muted">Inicio</a>
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
                        <h3 class="card-label">Listado
                            <span class="d-block text-muted pt-2 font-size-sm">Listado areas</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#formArea"><i class="fas fa-user-plus"></i> Nuevo Usuario</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
    <!--begin: Datatable-->
    <table class="table table-separate  table-checkable table-sm " id="kt_datatable">
        <thead>
            <tr>
                <th class="text-center ">ID</th>
                <th>Area</th>
                <th>Descripcion</th>
                <th>Tipo de Estado</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!empty($Areas)) {
                foreach ($Areas as $key => $area) {
                    echo '
                    <tr>
                        <td>'.$area['idarea'].'</td>
                        <td>'. $area['nombre_area'].'</td>
                        <td>'. $area['descripcion'].'</td>
                        <td>'. $area['tipo_estado'].'</td>
                        <td>';
                    // Cambiar estado de numerico a texto
                    if ($area['estado_area'] == 1) {
                        echo '<span class="badge badge-success">Activo</span>';
                    } else {
                        echo '<span class="badge badge-danger">Inactivo</span>';
                    }
                    echo '</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm buttonAreaEdit" itemButton="'.$area['idarea'].'"><i class="fa fa-user-edit text-success"></i></button>
                                <button class="btn btn-sm buttonDelete" itemButton="'.$area['idarea'].'"><i class="fas fa-user-times text-danger"></i></button>
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
<!-- Modal para Registro de Área -->
<div class="modal fade" id="formArea" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Registro de Área</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="/Areas/guardar" id="form_area">
            <input type="hidden" name="idarea" value="">
                <div class="modal-body">
                    <div class="row">
                        <!-- Campo para Nombre del Área -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nombre del Área <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre_area"
                                    placeholder="Ingrese el nombre del área" required />
                            </div>
                        </div>

                        <!-- Campo para Descripción del Área -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Descripción del Área <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="descripcion"
                                    placeholder="Ingrese la descripción" />
                            </div>
                        </div>


                          <!-- Medio Solicitud -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="medioSolicitud">Tipo de Estadod <span class="text-danger">*</span></label>
                                <select class="form-control" id="tipo_estado" name="tipo_estado" required>
                                    <option value="R"selected>RECIBIDO</option>
                                    <option value="P" >PENDIENTE</option>
                                    <option value="C">COMPLETADO</option>
                                </select>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitButton" class="btn btn-success font-weight-bold">Guardar</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold"
                        data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>