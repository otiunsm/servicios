<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Subheader -->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Gestionar Metas</h5>
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>" class="text-muted">Panel de Control</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Entry -->
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Lista de Metas
                        <span class="d-block text-muted pt-2 font-size-sm">Tabla de Metas</span></h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formMeta">
                            <i class="fas fa-plus"></i> Nueva Meta
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table text-center table-separate table-head-custom table-checkable" id="tablamet">
                        <thead>
                            <tr class="text-center">
                                <th>Código Meta</th>
                                <th>Código Actividad</th>
                                <th>Nombre de la Actividad</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar -->
<div class="modal fade" id="formMeta" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title">Formulario de Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('SegMetas/formData') ?>" id="form_meta">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="codigo_meta">Código de Meta<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="codigo_meta" placeholder="Ingresar código de la meta" required />
                    </div>
                    
                    <div class="form-group">
                        <label for="codigo_meta">Código de Actividad<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="codigo_actividad" placeholder="Ingresar código de la actividad" required />
                    </div>

                    <div class="form-group">
                        <label>Nombre de la Actividad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nombre_meta" placeholder="Ingresar nombre de la actividad" required />
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="5" placeholder="Ingresar descripción de la actividad"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success font-weight-bold">Guardar</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Visualizar -->
<div class="modal fade" id="formMetaVisual" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title">Visualización de Meta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Código Meta</label>
                    <input type="text" class="form-control" name="codigo_meta" readonly />
                </div>
                <div class="form-group">
                    <label>Código de Actividad</label>
                    <input type="text" class="form-control" name="codigo_actividad" readonly/>
                </div>
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre_meta" readonly />
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="5" readonly></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="formMetaEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title">Editar Meta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('SegMetas/formData') ?>" id="form_meta_edit">
                <div class="modal-body">
                    <input type="hidden" name="id_meta" />
                    <div class="form-group">
                        <label>Código</label>
                        <input type="text" class="form-control" name="codigo_meta" required />
                    </div>
                    <div class="form-group">
                        <label for="codigo_meta">Código de Actividad<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="codigo_actividad" required />
                    </div>
                    <div class="form-group">
                        <label>Nombre de Actividad<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nombre_meta" required />
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success font-weight-bold">Guardar</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


