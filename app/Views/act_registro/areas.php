    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!-- ///alertar /// -->
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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Listado de Areas</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul
                            class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
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
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Listado
                                <span class="d-block text-muted pt-2 font-size-sm">Listado áreas</span>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#formArea" onclick="limpiarFormulario()"><i class="fas fa-user-plus"></i>
                                Nueva Área</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-separate table-checkable table-sm " id="kt_datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Área</th>
                                    <th>Descripción</th>
                                    <th>Tipo de Estado</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($Areas)) {
                                    foreach ($Areas as $key => $area) { ?>
                                        <tr>
                                            <td><?= $area['id_area'] ?></td>
                                            <td><?= $area['nombre_area'] ?></td>
                                            <td><?= $area['descripcion'] ?></td>
                                            <td><?= $area['tipo_estado'] ?></td>
                                            <td>
                                                <?= $area['estado_a'] == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>' ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button class="btn btn-sm buttonAreaEdit"
                                                        onclick="editarArea(<?= $area['id_area'] ?>, '<?= $area['nombre_area'] ?>', '<?= $area['descripcion'] ?>', '<?= $area['tipo_estado'] ?>')"
                                                        title="Editar">
                                                        <i class="fas fa-edit text-success"></i>
                                                    </button>

                                                    <!-- Botón de cambio de estado solo con ícono -->
                                                    <button class="btn btn-sm buttonToggleState"
                                                        itemButton="<?= $area['id_area'] ?>"
                                                        title="<?= $area['estado_a'] == 1 ? 'Desactivar' : 'Activar' ?>">
                                                        <i class="<?= $area['estado_a'] == 1 ? 'fas fa-toggle-on' : 'fas fa-toggle-off' ?>"
                                                            style="font-size: 1.5rem;"></i>
                                                    </button>

                                                    <!-- Agregar un evento al botón de eliminar -->
                                                    <button class="btn btn-sm buttonDelete" itemButton="<?= $area['id_area'] ?>"
                                                        title="Eliminar" onclick="eliminarArea(this)">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>

                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Entry-->
    </div>

    <!-- Modal para Registro de Área -->
    <div class="modal fade" id="formArea" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="kt_login2">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulario de Registro de Área</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form method="POST" action="/Areas/guardar" id="form_area">
                    <!-- Campo oculto para el ID del área -->
                    <input type="hidden" name="idarea" id="idarea" value="">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nombre del Área <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nombre_area" id="nombre_area"
                                        placeholder="Ingrese el nombre del área" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Descripción del Área <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="descripcion" id="descripcion"
                                        placeholder="Ingrese la descripción" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tipo_estado">Tipo de Estado <span class="text-danger">*</span></label>
                                    <select class="form-control" id="tipo_estado" name="tipo_estado" required>
                                        <option value="R">RECIBIDO</option>
                                        <option value="P">PENDIENTE</option>
                                        <option value="C">COMPLETADO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitButton"
                            class="btn btn-primary font-weight-bold">Guardar</button>
                        <button type="button" class="btn btn-light-danger font-weight-bold"
                            data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>