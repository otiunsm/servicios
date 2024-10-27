<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- ///alertar /// -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if(session()->getFlashdata('AlertShowN')): ?>
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
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Listado de Categorias</h5>
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url()?>" class="text-muted">Inicio</a>
                        </li>
                    </ul>
                </div>
            </div>
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
                            <span class="d-block text-muted pt-2 font-size-sm">Listado Categorias</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formCate"
                            onclick="limpiarFormulario()"><i class="fas fa-user-plus"></i> Nueva Categoría</button>
                    </div>
                </div>

                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-checkable table-sm " id="kt_datatable">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>Categoria</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($Categorias)) {
        foreach ($Categorias as $key => $categoria) { ?>
                            <tr>
                                <td><?= $categoria['idcategoria_actividad'] ?></td>
                                <td><?= $categoria['nombre_c'] ?></td>
                                <td>
                                    <?= $categoria['estado_cate'] == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>' ?>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        <!-- Botón Editar con clase y atributos correctos -->
                                        <button class="btn btn-sm buttonCateEdit"
                                            itemButton="<?= $categoria['idcategoria_actividad'] ?>"
                                            onclick="editarCate(<?= $categoria['idcategoria_actividad'] ?>, '<?= $categoria['nombre_c'] ?>')"
                                            title="Editar">
                                            <i class="fas fa-edit text-success"></i>
                                        </button>

                                        <!-- Botón para cambiar el estado con clase y atributos correctos -->
                                        <button class="btn btn-sm buttonToggleStateCate"
                                            itemButton="<?= $categoria['idcategoria_actividad'] ?>"
                                            title="<?= $categoria['estado_cate'] == 1 ? 'Desactivar' : 'Activar' ?>">
                                            <i class="<?= $categoria['estado_cate'] == 1 ? 'fas fa-toggle-on' : 'fas fa-toggle-off' ?>"
                                                style="font-size: 1.5rem;"></i>
                                        </button>

                                        <!-- Botón Eliminar con clase y atributos correctos -->
                                        <button class="btn btn-sm buttonDeleteCate"
                                            itemButton="<?= $categoria['idcategoria_actividad'] ?>" title="Eliminar">
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
<!--end::Content-->

<!-- Modal para Registro de Categorias -->
<div class="modal fade" id="formCate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario Registro Categorias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="/Act_Categorias/guardar" id="form_cate">
                <input type="hidden" name="idcategoria_actividad" id="idcategoria_actividad" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre de la Categoría <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nombre_c" id="nombre_c"
                            placeholder="Ingrese el nombre de la categoría" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitButton" class="btn btn-primary font-weight-bold">Guardar</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold"
                        data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>