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
                            <span class="d-block text-muted pt-2 font-size-sm">Programas Presupuestales</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline ml-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formRegistro">
                                <i class="fas fa-plus"></i> Crear Carpeta
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin::Row-->
                    <div class="d-flex justify-content-end mb-5">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" id="buscador"
                                data-vista="programa"
                                data-url="<?= base_url('SegCarpetas/buscarCarpetas') ?>"
                                data-categoria="<?= $id_categoria ?? '' ?>"
                                data-programa="<?= $id_programa ?? '' ?>"
                                data-fuente="<?= $id_fuente ?? '' ?>"
                                data-padre="<?= isset($idCarpetaPadre) ? $idCarpetaPadre : 'null' ?>"
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
                                            <h5 class="card-title mt-2"><?= esc($carpeta['nombre_carpeta']) ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><strong>Programa:</strong> <?= esc($carpeta['nombre_programa']) ?></p>
                                            <p class="card-text"><strong>Descripción:</strong> <?= esc($carpeta['descripcion'] ?? 'Sin descripción') ?></p>
                                            <a href="<?= base_url("SegCarpetas/listarFuentes/{$carpeta['id_categoria']}/{$carpeta['id_programa']}/{$carpeta['id_carpeta']}") ?>" class="btn btn-primary btn-block">
                                                <i class="fas fa-eye"></i> Ver Fuentes
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-center">No hay programas registrados.</p>
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

<!-- Modal para Crear Carpeta de Programa -->
<div class="modal fade" id="formRegistro" tabindex="-1" role="dialog" aria-labelledby="formRegistroLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formRegistroLabel">Crear Carpeta de Programa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?= base_url('SegCarpetas/crearPrograma') ?>">
                <div class="modal-body">
                    <!-- Campo para el nombre de la carpeta -->
                    <div class="form-group">
                        <label for="nombre_carpeta">Nombre de la Carpeta</label>
                        <input type="text" class="form-control" id="nombre_carpeta" name="nombre_carpeta" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>

                    <!-- Campo para seleccionar la categoría (opcional) -->
                    <div class="form-group">
                        <label for="id_categoria">Categoría</label>
                        <select class="selectpicker form-control" data-live-search="true" id="id_categoria" name="id_categoria" title="Seleccione una categoría" required>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id_categoria'] ?>"><?= esc($categoria['nombre_categoria']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Campo para seleccionar el programa (opcional) -->
                    <div class="form-group">
                        <label for="id_programa">Programa Presupuestal</label>
                        <select class="selectpicker form-control" data-live-search="true" id="id_programa" name="id_programa" title="Seleccione un programa" required>
                            <?php foreach ($programas as $programa): ?>
                                <option value="<?= $programa['id_programa'] ?>"><?= esc($programa['nombre_programa']) ?></option>
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
<!--end::Content-->
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
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const BASE_URL = "<?= rtrim(base_url(), '/') . '/' ?>";
</script>

