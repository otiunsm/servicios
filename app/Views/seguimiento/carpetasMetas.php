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
                        <li class="breadcrumb-item">
                            <a href="<?= base_url("SegCarpetas/listarFuentes/{$idCarpetaPadreFuente}/{$id_categoria}/{$id_programa}") ?>" class="text-muted">
                                Fuentes de Financiamiento
                            </a>

                        </li>
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
                        <h3 class="card-label">Carpetas
                            <span class="d-block text-muted pt-2 font-size-sm">Metas</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formRegistroMeta">
                                <i class="fas fa-plus"></i> Crear Carpeta
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-5">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" id="buscador"
                                data-vista="meta"
                                data-url="<?= base_url('SegCarpetas/buscarCarpetas') ?>"
                                data-categoria="<?= $id_categoria ?>"
                                data-programa="<?= $id_programa ?>"
                                data-fuente="<?= $id_fuente ?>"
                                data-meta=""
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
                                            <i class="fas fa-file-excel fa-3x text-success"></i>
                                            <div class="icon-actions">
                                                <a href="javascript:void(0);" 
                                                class="text-warning btn-editar-carpeta"
                                                data-toggle="modal"
                                                data-target="#modalEditarMeta_<?= $carpeta['id_carpeta'] ?>"
                                                data-id="<?= $carpeta['id_carpeta'] ?>"
                                                data-nombre="<?= esc($carpeta['nombre_carpeta']) ?>"
                                                data-descripcion="<?= esc($carpeta['descripcion'] ?? '') ?>">
                                                <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0);" 
                                                class="text-danger btn-confirmar-eliminar-meta"
                                                data-id="<?= $carpeta['id_carpeta'] ?>">
                                                <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                                <h5 class="card-title mt-2"><?= esc($carpeta['nombre_carpeta']) ?></h5>
                                        </div>
                                        <div class="card-body">

                                            <p class="card-text">
                                                <strong>Programa:</strong> <?= esc($carpeta['nombre_programa']) ?><br>
                                                <strong>Fuente:</strong> <?= esc($carpeta['nombre_fuente']) ?><br>
                                                <strong>Meta:</strong> <?= esc($carpeta['nombre_meta']) ?>
                                            </p>
                                            <!-- Enlace para ver más detalles si es necesario -->
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group mr-2">
                                                    <a href="<?= base_url('SegCarpetas/ControlGastos/' . $carpeta['id_categoria'] . '/' . $carpeta['id_programa'] . '/' . $carpeta['id_fuente'] . '/' . $carpeta['id_meta']) ?>" class="btn btn-outline-primary" name="ingresar">
                                                        Ingresar
                                                    </a>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="<?= base_url('SegCarpetas/ResumenGastos/' . $carpeta['id_categoria'] . '/' . $carpeta['id_programa'] . '/' . $carpeta['id_fuente'] . '/' . $carpeta['id_meta']) ?>" class="btn btn-outline-success" name="resumen">
                                                        Resumen
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal para editar meta -->
                                <div class="modal fade" id="modalEditarMeta_<?= $carpeta['id_carpeta'] ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">

                                            <!-- Formulario de edición de meta -->
                                            <form method="post" action="<?= base_url('SegCarpetas/editarCarpetaMeta') ?>">
                                                <div class="modal-header">
                                                <h5 class="modal-title">Editar Meta</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                <input type="hidden" name="id_carpeta" value="<?= $carpeta['id_carpeta'] ?>">
                                                <div class="form-group">
                                                    <label for="nombre_carpeta">Nombre Meta</label>
                                                    <input type="text" class="form-control" id="nombre_carpeta" name="nombre_carpeta" value="<?= esc($carpeta['nombre_carpeta']) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="descripcion">Descripción</label>
                                                    <textarea class="form-control" id="descripcion" name="descripcion"><?= esc($carpeta['descripcion']) ?></textarea>
                                                </div>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                </div>
                                            </form>

                                            <!-- Separador visual -->
                                            <hr class="my-2">

                                            <!-- Formulario para agregar clasificadores -->
                                            <form class="form-agregar-clasificadores" method="post">
                                                <div class="px-4 pb-3">
                                                <h6 class="mb-3">Agregar Clasificadores a esta Meta</h6>
                                                <input type="hidden" name="id_categoria" value="<?= $id_categoria ?>">
                                                <input type="hidden" name="id_programa" value="<?= $id_programa ?>">
                                                <input type="hidden" name="id_fuente" value="<?= $id_fuente ?>">
                                                <input type="hidden" name="id_meta" value="<?= $carpeta['id_meta'] ?>">

                                                <div class="form-group">
                                                    <label for="clasificadores">Selecciona uno o varios clasificadores</label>
                                                    <select class="form-control selectpicker" id="clasificadores" name="clasificadores[]" multiple data-live-search="true" title="Seleccione clasificadores">
                                                    <?php foreach ($clasificadores as $clasificador): ?>
                                                        <?php
                                                        $yaAsignado = false;
                                                        foreach ($carpeta['detalle_clasificadores'] ?? [] as $dc) {
                                                            if ($dc['id_clasificador'] == $clasificador['id_clasificador']) {
                                                            $yaAsignado = true;
                                                            break;
                                                            }
                                                        }
                                                        ?>
                                                        <option value="<?= $clasificador['id_clasificador'] ?>" <?= $yaAsignado ? 'disabled' : '' ?>>
                                                        <?= $clasificador['nombre_clasificador'] ?> <?= $yaAsignado ? '(Ya asignado)' : '' ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                    <small class="form-text text-muted">Los clasificadores ya asignados están deshabilitados</small>
                                                </div>

                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-success">Guardar Nuevos Clasificadores</button>
                                                </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-center">No hay metas registradas.</p>
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

<!-- Modal para Crear Meta -->
<div class="modal fade" id="formRegistroMeta" tabindex="-1" role="dialog" aria-labelledby="formRegistroMetaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formRegistroMetaLabel">Crear Meta y Asignar Clasificadores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('SegCarpetas/crearMeta/' . $idCarpetaPadre) ?>">
                <div class="modal-body">
                    <!-- Campos ocultos para id_categoria, id_programa, id_fuente -->
                    <input type="hidden" name="id_categoria" value="<?= $id_categoria ?>">
                    <input type="hidden" name="id_programa" value="<?= $id_programa ?>">
                    <input type="hidden" name="id_fuente" value="<?= $id_fuente ?>">

                    <!-- Campo para el nombre de la carpeta -->
                    <div class="form-group">
                        <label for="nombre_carpeta">Nombre de la Carpeta</label>
                        <input type="text" class="form-control" id="nombre_carpeta" name="nombre_carpeta" required>
                    </div>

                    <!-- Campo para seleccionar la meta -->
                    <div class="form-group">
                        <label for="id_meta">Meta</label>
                        <select class="selectpicker form-control" name="id_meta" id="id_meta" data-live-search="true" title="Seleccione una meta...">
                            <?php foreach ($metas as $meta): ?>
                                <option value="<?= esc($meta['id_meta']) ?>"><?= esc($meta['nombre_meta']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Campo para seleccionar los clasificadores -->
                    <div class="form-group">
                        <label for="clasificadores">Clasificadores</label>
                        <select class="selectpicker form-control" name="clasificadores[]" id="clasificadores" multiple data-live-search="true" title="Seleccione uno o varios clasificadores">
                            <?php foreach ($clasificadores as $clasificador): ?>
                                <option value="<?= esc($clasificador['id_clasificador']) ?>"><?= esc($clasificador['nombre_clasificador']) ?></option>
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
  document.querySelectorAll('.btn-confirmar-eliminar-meta').forEach(btn => {
    btn.addEventListener('click', function () {
      const id = this.getAttribute('data-id');

      Swal.fire({
        title: '¿Deseas eliminar esta meta?',
        text: 'Esta acción eliminará permanentemente la carpeta meta si no tiene clasificadores con PIA distinto de 0.',
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
          form.action = '<?= base_url('SegCarpetas/eliminarCarpetaMeta') ?>';

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
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-agregar-clasificadores').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch("<?= base_url('SegCarpetas/agregarClasificadoresAMeta') ?>", {
          method: "POST",
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire('Éxito', `${data.insertados} clasificadores agregados.`, 'success')
              .then(() => location.reload());
          } else {
            Swal.fire('Error', data.errores.join("\n"), 'error');
          }
        })
        .catch(err => {
          console.error(err);
          Swal.fire('Error', 'No se pudo guardar los clasificadores', 'error');
        });
      });
    });
  });
</script>
