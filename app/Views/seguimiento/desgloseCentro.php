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
                            <a href="<?= base_url("SegDesglose") ?>" class="text-muted">Desglose</a>
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
                        <h3 class="card-label">CONTROL DE GASTOS POR CENTRO DE COSTOS
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-5">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" id="buscadorDesglose"
                                class="form-control form-control-sm"
                                data-vista="centro"
                                data-url="<?= base_url('SegDesglose/buscarDesgloses') ?>"
                                data-categoria="<?= $id_categoria ?? ''?>"
                                data-programa="<?= $id_programa ?? ''?>"
                                data-fuente="<?= $id_fuente ?? ''?>"
                                data-meta="<?= $id_meta ?? ''?>"
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
                                    <div class="card folder-card">
                                        <div class="card-header folder-header">
                                            <i class="fas fa-file-excel fa-3x text-success"></i>
                                            <h5 class="card-title mt-2"><?= esc($desglose['nombre_centro'] ?? 'Sin centro asignado') ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <strong>Categoria:</strong> <?= $desglose['nombre_categoria'] ?> <br>
                                                <strong>Programa:</strong> <?= esc($desglose['nombre_programa']) ?><br>
                                                <strong>Fuente:</strong> <?= esc($desglose['nombre_fuente']) ?><br>
                                                <strong>Meta:</strong> <?= esc($desglose['nombre_meta']) ?><br>
                                            </p>
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group mr-2">
                                                    <a href="<?= base_url('SegDesglose/ControlGastos/' . $desglose['id_categoria'] . '/' . $desglose['id_programa'] . '/' . $desglose['id_fuente'] . '/' . $desglose['id_meta'] . '/' . $desglose['id_centro_costos'])  ?>"
                                                        class="btn btn-outline-primary" name="ingresar">
                                                        Ingresar
                                                    </a>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="<?= base_url('SegDesglose/ResumenGastos/' . $desglose['id_categoria'] . '/' . $desglose['id_programa'] . '/' . $desglose['id_fuente'] . '/' . $desglose['id_meta'] . '/' . $desglose['id_centro_costos']) ?>"
                                                        class="btn btn-outline-success" name="resumen">
                                                        Resumen
                                                    </a>
                                                </div>
                                            </div>
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