<!-- Vista: categoria_presupuestal.php -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Gestionar Categorías Presupuestales</h5>
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>" class="text-muted">Panel de Control</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Lista de Categorías Presupuestales
                            <span class="d-block text-muted pt-2 font-size-sm">Tabla de Categorías Presupuestales</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary btn-sm mr-4" data-toggle="modal" data-target="#formCat">
                            <i class="fas fa-plus"></i> Nueva Categoria
                        </button>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#formImportar">
                            <i class="fas fa-upload mr-1"></i> Importar Categorias
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <table class="text-center table table-separate table-head-custom table-checkable" id="tablacat">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Categoria Presupuestal</th>
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

<!-- Modal Agregar-->
<div class="modal fade" id="formCat" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Categoria Presupuestales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('SegCategoria/formData') ?>" id="form_cat">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Codigo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="codigo_categoria" placeholder="Ingresar codigo del categoria presupuestal" />
                            </div>
                            <div class="form-group">
                                <label>Nombre<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre_categoria" placeholder="Ingresar nombre del categoria presupuestal" />
                            </div>
                            <div class="form-group">
                                <label>Descripción<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="descripcion" rows="5" placeholder="Ingresar descripción del categoria presupuestal"></textarea>
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

<!-- Modal Visualizar-->
<div class="modal fade" id="formCatVisual" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 type="text" class="modal-title" name="nomCategoria">
                    Nombre de Categoría
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Codigo</label>
                            <input type="text" class="form-control" name="codigo_categoria" readonly />
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="5" readonly></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar-->
<div class="modal fade" id="formCatEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Categoria Presupuestal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('SegCategoria/formData') ?>" id="form_cat">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="id_categoria" />
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" class="form-control" name="codigo_categoria" placeholder="Ingresar codigo del categoria presupuestal" />
                            </div>
                            <div class="form-group">
                                <label>Nombre de Categoría Presupuestal<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre_categoria" placeholder="Ingresar nombre del categoria presupuestal" />
                            </div>
                            <div class="form-group">
                                <label>Descripción<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="descripcion" rows="5" placeholder="Ingresar descripción del categoria presupuestal"></textarea>
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


<div class="modal fade" id="formImportar" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Importar Categorias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('SegCategoria/importarExcel') ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Selecciona archivo Excel (.xlsx)</label>
                        <input type="file" name="archivo_excel" class="form-control-file mb-3 mt-" accept=".xlsx" required>
                        <small class="form-text text mt-1">
                            <a href="<?= base_url('plantillas/Plantilla.xlsx') ?>" download class="text-primary">
                                 Descargar plantilla
                            </a>
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success font-weight-bold">Cargar</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>