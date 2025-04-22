<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Constancias Históricas</h5>
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
                    <h3 class="card-label"><img width="50" height="50" src="https://img.icons8.com/dotty/80/search-property.png" alt="search-property"/> Lista de Constancias</h3>
                </div>
                <div class="card-body">
                    <script>const base_url = "<?= base_url() ?>";</script>

                    <div class="form-row mb-4">
                        <div class="col-md-4">
                            <label>Nro de Expediente</label>
                            <input type="text" id="filtroExpediente" class="form-control" placeholder="Ej: 12345 - 67890">
                        </div>
                        <div class="col-md-4">
                            <label>Escuela Profesional</label>
                            <select id="filtroEscuela" class="form-control">
                                <option value="">-- Todas las Escuelas --</option>
                                <?php
$inactivas = ['0403', '0605', '0610', '0802'];
foreach ($escuelas as $escuela):
    if (!in_array($escuela['CodigoEscuela'], $inactivas)):
?>
    <option value="<?= $escuela['CodigoEscuela'] ?>"><?= $escuela['DescripcionEscuela'] ?></option>
<?php
    endif;
endforeach;
?>

                            </select>
                        </div>
                    </div>

                    <div id="loading-indicator" style="display: none; text-align: center; margin-bottom: 10px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Buscando...</span>
                        </div>
                        <div class="mt-2 font-weight-bold text-primary">Buscando constancias...</div>
                    </div>

                    <table class="table table-separate table-head-custom table-checkable main-table" id="tablaconst">
                        <thead>
                            <tr class="text-center">
                                <th>Nro de Expediente</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Tipo de Constancia</th>
                                <th>Escuela Profesional</th>
                                <th>Fecha de Trámite</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
