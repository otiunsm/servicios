<!-- app/Views/seguimiento/reporte_ejecucion.php -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Subheader -->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Reporte de Ejecución Presupuestal</h5>
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
                        <h3 class="card-label">Exportar Reporte
                        <span class="d-block text-muted pt-2 font-size-sm">Seleccione una fuente de financiamiento</span></h3>
                    </div>
                </div>

                <div class="card-body">
                    <form action="<?= base_url('SegReporteEjecucionController/exportarExcel') ?>" method="get">
                        <div class="form-group row">
                            <label for="id_fuente" class="col-form-label col-md-3 text-right">Fuente de Financiamiento:</label>
                            <div class="col-md-6">
                            <select class="selectpicker form-control" name="id_fuente" id="id_fuente" data-live-search="true" title="Seleccione una fuente..." required>
                                <option value="todos">-- Todas las fuentes --</option>
                                <?php foreach ($fuentes as $fuente): ?>
                                    <option value="<?= $fuente['id_fuente'] ?>">
                                        <?= esc($fuente['nombre_fuente']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Descargar Excel
                                </button>
                            </div>
                        </div>
                    </form>

                    
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
    
</div>
