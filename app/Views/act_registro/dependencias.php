<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">


    <!-- alertas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (session()->getFlashdata('AlertShowN')): ?>
                let alerta = <?= json_encode(session()->getFlashdata('AlertShowN')) ?>;
                Swal.fire({
                    icon: alerta.Tipo,
                    title: alerta.Tipo === 'success' ? '¡Éxito!' : 'Error',
                    text: alerta.Mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: alerta.Tipo === 'success' ? '#28a745' : '#d33'
                });
            <?php endif; ?>
        });
    </script>



    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Listado Dependencias</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>" class="text-muted">Inicio</a>
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
                            <span class="d-block text-muted pt-2 font-size-sm">Listado Dependencias</span>
                        </h3>
                    </div>

                    <!--cambiar aqui-->
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#formDepen"><i class="fas fa-user-plus" onclick="resetForm()"></i> Nueva Dependencia</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate  table-checkable table-sm " id="kt_datatable">
                        <thead>
                            <tr>
                                <th class="text-center ">ID</th>
                                <th>Dependencia</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($Dependencias)) {
                                foreach ($Dependencias as $dependencia) {
                                    echo '
                <tr>
                    <td>' . $dependencia['id_dependencia'] . '</td>
                    <td>' . $dependencia['nombre_dep'] . '</td>
                    <td>' . $dependencia['descripcion'] . '</td>
                    <td>';
                                    echo $dependencia['estado_dep'] == 1
                                        ? '<span class="badge badge-success">Activo</span>'
                                        : '<span class="badge badge-danger">Inactivo</span>';
                                    echo '</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button class="btn btn-sm buttonDepenEdit" itemButton="' . $dependencia['id_dependencia'] . '"><i class="fa fa-edit text-success"></i></button>
                            <button class="btn btn-sm buttonDelete" itemButton="' . $dependencia['id_dependencia'] . '"><i class="fas fa-times text-danger"></i></button>
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
<!-- Modal para Registro de Dependencias -->
<div class="modal fade" id="formDepen" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario Registro Dependencias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('/Act_Dependencias/guardar') ?>" id="form_depen">
                <input type="hidden" name="id_dependencia" /> <!-- Campo oculto para el ID de la dependencia -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Campo para Nombre de dependencia -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nombre de la Dependencia <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre_dep"
                                    placeholder="Ingrese el nombre de la dependencia" required />
                            </div>
                        </div>

                        <!-- Campo para Descripción del dependencia -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Descripción de la dependencia<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="descripcion"
                                    placeholder="Ingrese la descripción" />
                            </div>
                        </div>


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