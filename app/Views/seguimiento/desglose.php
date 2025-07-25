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
                    <h5 class="text-dark font-weight-bold my-1 mr-2">
                        <i class="fas fa-folder"></i>
                    </h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Toolbar-->
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
                        <h3 class="card-label">CONTROL DE GASTOS
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formRegistroDesglose">
                                <i class="fas fa-plus"></i> Crear Desglose
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-5">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" id="buscadorDesglose"
                                class="form-control form-control-sm"
                                data-vista="general"
                                data-url="<?= base_url('SegDesglose/buscarDesgloses') ?>"
                                data-categoria=""
                                data-programa=""
                                data-fuente=""
                                data-meta=""
                                placeholder="Buscar desglose...">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="cardsContainer">
                        <?php if (!empty($desgloses)): ?>
                            <?php foreach ($desgloses as $desglose): ?>
                                <div class="col-md-3 mb-4">
                                    <div class="card folder-card" id="card_<?= $desglose['id_categoria'] ?>_<?= $desglose['id_programa'] ?>_<?= $desglose['id_fuente'] ?>_<?= $desglose['id_meta'] ?>_<?= $desglose['id_centro_costos'] ?>">

                                        <div class="card-header folder-header">
                                            <i class="fas fa-folder fa-3x text-warning"></i>
                                                    <div class="icon-actions">
<a href="#" class="text-warning btn-editar-carpeta" data-toggle="modal"
   data-target="#modalEditar_<?= $desglose['id_categoria'] ?>_<?= $desglose['id_programa'] ?>_<?= $desglose['id_fuente'] ?>_<?= $desglose['id_meta'] ?>_<?= $desglose['id_centro_costos'] ?>">
   <i class="fas fa-edit"></i>
</a>
<a href="javascript:void(0);" class="text-danger btn-confirmar-eliminar"
   onclick="eliminarDesglose('<?= $desglose['id_categoria'] ?>', '<?= $desglose['id_programa'] ?>', '<?= $desglose['id_fuente'] ?>', '<?= $desglose['id_meta'] ?>', '<?= $desglose['id_centro_costos'] ?>')">
   <i class="fas fa-trash-alt"></i>
</a>

        </div>
        
                                            <h5 class="card-title mt-2"><?= $desglose['nombre_desglose'] ?></h5>
                                        </div>
                                        <div class="card-body">
                                            

                                            

                                            <p class="card-text">
                                                <strong>Categoria:</strong> <?= $desglose['nombre_categoria'] ?> <br>
                                                <strong>Programa:</strong> <?= $desglose['nombre_programa'] ?> <br>
                                                <strong>Fuente:</strong> <?= $desglose['nombre_fuente'] ?> <br>
                                                <strong>Meta:</strong> <?= $desglose['nombre_meta'] ?>
                                            </p>
                                            <a href="<?= base_url("SegDesglose/listar/{$desglose['id_categoria']}/{$desglose['id_programa']}/{$desglose['id_fuente']}//{$desglose['id_meta']}") ?>" class="btn btn-primary btn-block">
                                                <i class="fas fa-eye"></i>Ver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade"
     id="modalEditar_<?= $desglose['id_categoria'] ?>_<?= $desglose['id_programa'] ?>_<?= $desglose['id_fuente'] ?>_<?= $desglose['id_meta'] ?>_<?= $desglose['id_centro_costos'] ?>"
     tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" action="<?= base_url('SegDesglose/editarDesglose') ?>">
        <div class="modal-header">
          <h5 class="modal-title">Editar Desglose</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_categoria" value="<?= $desglose['id_categoria'] ?>">
          <input type="hidden" name="id_programa" value="<?= $desglose['id_programa'] ?>">
          <input type="hidden" name="id_fuente" value="<?= $desglose['id_fuente'] ?>">
          <input type="hidden" name="id_meta" value="<?= $desglose['id_meta'] ?>">

          <div class="form-group">
            <label>Nombre del Desglose</label>
            <input type="text" class="form-control" name="nombre_desglose"
                   value="<?= esc($desglose['nombre_desglose']) ?>" required>
          </div>

          <div class="form-group">
            <label for="centros_editar">Centros de Costos</label>
            <select class="selectpicker form-control" name="idCentritos[]" multiple data-live-search="true">
              <?php foreach ($centrosCostos as $centro): ?>
                  <option value="<?= $centro['idCentro'] ?>"
    <?= in_array($centro['idCentro'], $desglose['centros_seleccionados']) ? 'selected' : '' ?>>
    <?= $centro['nombrecen'] ?>
</option>

              <?php endforeach; ?>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
                            <?php endforeach; ?>
                            
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-center">No hay desgloses registrados.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!--end::Row-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->

<!-- Modal para Crear Desglose -->
<div class="modal fade" id="formRegistroDesglose" tabindex="-1" role="dialog" aria-labelledby="formRegistroDesgloseLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formRegistroDesgloseLabel">Crear Desglose</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('SegDesglose/guardar') ?>">
                <div class="modal-body">
                    <!-- Campo para el nombre del desglose -->
                    <div class="form-group">
                        <label for="nombre_desglose">Nombre del Desglose</label>
                        <input type="text" class="form-control" id="nombre_desglose" name="nombre_desglose" required>
                    </div>

                    <div class="form-group">
                        <label for="id_categoria">Categoría</label>
                        <select class="selectpicker form-control" name="id_categoria" id="id_categoria" data-live-search="true" title="Seleccione una categoria presupuestal..." required>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id_categoria'] ?>"><?= $categoria['nombre_categoria'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_programa">Programa Presupuestal</label>
                        <select class="selectpicker form-control" name="id_programa" id="id_programa" data-live-search="true" disabled title="Seleccione un programa presupuestal..." required>
                        </select>
                    </div>

                    <!-- Selector de Fuente (se llena via AJAX) -->
                    <div class="form-group">
                        <label for="id_fuente">Fuente de Financiamiento</label>
                        <select class="selectpicker form-control" name="id_fuente" id="id_fuente" data-live-search="true" title="Seleccione una fuente de financiamiento..." required disabled>
                        </select>
                    </div>

                    <!-- Selector de Meta (se llena via AJAX) -->
                    <div class="form-group">
                        <label for="id_meta">Meta</label>
                        <select class="selectpicker form-control" name="id_meta" id="id_meta" data-live-search="true" title="Seleccione una meta..." required disabled>
                        </select>
                    </div>

                    <!-- Selector de Centros de Costos -->
                    <div class="form-group">
                        <label for="centro">Centros de costos</label>
                        <select class="selectpicker form-control" data-live-search="true" id="idCentro" name="idCentritos[]" title="Seleccione uno o varios centros de costos..." multiple required>
                            <?php foreach ($centrosCostos as $centro): ?>
                                <option value="<?= $centro['idCentro'] ?>"><?= $centro['nombrecen'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar (DENTRO del foreach) -->




<style>
    .folder-card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .folder-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .folder-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
        padding: 20px;
        text-align: center;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .folder-header .fa-folder {
        margin-bottom: 10px;
    }

    .folder-card .card-body {
        padding: 20px;
    }

    .folder-card .card-title {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 0;
    }

    .folder-card .card-text {
        font-size: 0.9rem;
        color: #555;
    }

    .folder-card .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        font-size: 0.9rem;
        padding: 8px 12px;
    }

    .folder-card .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
        
    }
    .icon-actions {
    position: absolute;
    top: 10px;
    right: 10px;
}

.icon-actions a {
    margin-left: 8px;
    font-size: 16px;
    text-decoration: none;
}
.icon-actions i.fa-edit {
    color:rgb(58, 53, 204); /* naranja */
}

.icon-actions i.fa-trash-alt {
    color: #d9534f; /* rojo */
}


</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const BASE_URL = "<?= rtrim(base_url(), '/') . '/' ?>";

    function eliminarDesglose(cat, prog, fuente, meta, centro) {
        Swal.fire({
            title: '¿Eliminar desglose?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(BASE_URL + "SegDesglose/eliminarDesglose", {
                    id_categoria: cat,
                    id_programa: prog,
                    id_fuente: fuente,
                    id_meta: meta,
                    id_centro_costos: centro
                }, function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Desglose eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // Ocultar la tarjeta sin recargar
                        const cardId = `card_${cat}_${prog}_${fuente}_${meta}_${centro}`;
                        $("#" + cardId).fadeOut(500, function () {
                            $(this).remove();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'No se pudo eliminar',
                            text: response.message || 'Este desglose tiene registros vinculados.'
                        });
                    }
                });
            }
        });
    }
</script>
