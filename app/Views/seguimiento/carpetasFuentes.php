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
                        <li class="breadcrumb-item">
                            <a href="<?= base_url("SegCarpetas") ?>" class="text-muted">Programa Presupuestal</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
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
                        <h3 class="card-label">Carpetas
                            <span class="d-block text-muted pt-2 font-size-sm">Fuentes de Financiamiento</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formRegistroFuente">
                                <i class="fas fa-plus"></i> Crear Carpeta
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Buscador reutilizable -->
                    <div class="d-flex justify-content-end mb-5">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" id="buscador"
                                data-vista="fuente"
                                data-url="<?= base_url('SegCarpetas/buscarCarpetas') ?>"
                                data-categoria="<?= $id_categoria ?>"
                                data-programa="<?= $id_programa ?>"
                                data-fuente=""
                                data-padre="<?= $idCarpetaPadre ?>"
                                class="form-control form-control-sm" placeholder="Buscar carpeta...">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="cardsContainer">
                        <?php if (!empty($carpetas)): ?>
                            <?php foreach ($carpetas as $carpeta): ?>
                                <div class="col-md-3 mb-4">
                                    <div class="card folder-card">
                                        <div class="card-header folder-header">
                                            <i class="fas fa-folder fa-3x text-warning"></i>
                                                 <!-- Íconos en la esquina superior derecha -->
        <div class="icon-actions">
       
            <a href="javascript:void(0);" class="text-warning btn-editar-carpeta" 
               data-id="<?= $carpeta['id_carpeta'] ?>" 
               data-nombre="<?= esc($carpeta['nombre_carpeta']) ?>" 
               data-toggle="modal" data-target="#modalEditarFuente_<?= $carpeta['id_carpeta'] ?>"
               data-descripcion="<?= esc($carpeta['descripcion'] ?? '') ?>">
               <i class="fas fa-edit"></i>
            </a>
  <a href="javascript:void(0);" class="text-danger btn-confirmar-eliminar-fuente" 
     data-id="<?= $carpeta['id_carpeta'] ?>">
     <i class="fas fa-trash-alt"></i>
  </a>
        </div>
                                            <h5 class="card-title mt-2"><?= esc($carpeta['nombre_carpeta']) ?></h5>
                                        </div>
                                        <div class="card-body">

                                            <p class="card-text"><strong>Programa:</strong> <?= esc($carpeta['nombre_programa']) ?></p>
                                            <p class="card-text"><strong>Fuente:</strong> <?= esc($carpeta['nombre_fuente']) ?></p>
                                            <p class="card-text"><strong>Descripción:</strong> <?= esc($carpeta['descripcion'] ?? 'Sin descripción') ?></p>
                                            <!-- Enlace para ver las metas de esta fuente -->
                                            <a href="<?= base_url("SegCarpetas/listarMetas/{$carpeta['id_carpeta']}/{$carpeta['id_categoria']}/{$carpeta['id_programa']}/{$carpeta['id_fuente']}") ?>" class="btn btn-primary btn-block">
                                                <i class="fas fa-eye"></i>Ver Metas
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modalEditarFuente_<?= $carpeta['id_carpeta'] ?>" tabindex="-1" role="dialog">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <form method="post" action="<?= base_url('SegCarpetas/editarCarpetaFuente') ?>">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Editar Fuente</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                        <input type="hidden" name="id_carpeta" value="<?= $carpeta['id_carpeta'] ?>">
                                        <div class="form-group">
                                            <label>Nombre de la carpeta</label>
                                            <input type="text" class="form-control" name="nombre_carpeta" value="<?= esc($carpeta['nombre_carpeta']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Descripción</label>
                                            <textarea class="form-control" name="descripcion"><?= esc($carpeta['descripcion']) ?></textarea>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-center">No hay fuentes registradas.</p>
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

<!-- Modal para Crear Fuente -->
<!-- Modal para Crear Fuente -->
<div class="modal fade" id="formRegistroFuente" tabindex="-1" role="dialog" aria-labelledby="formRegistroFuenteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formRegistroFuenteLabel">Crear Carpeta de Fuente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('SegCarpetas/crearFuente/' . $idCarpetaPadre) ?>">
                <div class="modal-body">
                    <!-- Campo para el nombre de la carpeta -->
                    <div class="form-group">
                        <label for="nombre_carpeta">Nombre de la Carpeta</label>
                        <input type="text" class="form-control" id="nombre_carpeta" name="nombre_carpeta" required>
                    </div>

                    <!-- Campo para la descripción -->
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>

                    <!-- Campo para seleccionar la fuente de financiamiento -->
                    <div class="form-group">
                        <label for="id_fuente">Fuente de Financiamiento</label>
                        <select class="selectpicker form-control" data-live-search="true" id="id_fuente" name="id_fuente" title="Seleccione una fuente" required>
                            <?php foreach ($fuentes as $fuente): ?>
                                <option value="<?= $fuente['id_fuente'] ?>"><?= esc($fuente['nombre_fuente']) ?></option>
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

<script>
    const BASE_URL = "<?= rtrim(base_url(), '/') . '/' ?>";



document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll('.btn-confirmar-eliminar-fuente').forEach(btn => {
    btn.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      Swal.fire({
        title: '¿Deseas eliminar esta fuente?',
        text: 'Esta acción eliminará permanentemente la carpeta fuente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
      }).then(result => {
        if (result.isConfirmed) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '<?= base_url('SegCarpetas/eliminarCarpetaFuente') ?>';
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'id_carpeta';
          input.value = id;
          form.appendChild(input);
          document.body.appendChild(form);
          form.submit();
        }
      });
    });
  });
});


</script>

