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
                                <select name="id_fuente" id="id_fuente" class="form-control" required>
                                    <option value="">Seleccione una fuente</option>
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

                     <hr class="my-5">

                    <h4 class="mb-4">Gráficas comparativas por Centro de Costo</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="graficoEjecucion"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="graficoColumnaCentro"></canvas>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-6">
                            <canvas id="graficoRadarCentro"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="graficoApiladoClasificador"></canvas>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            fetch("<?= base_url('SegReporteEjecucion/graficosCentrosCosto') ?>")
                                .then(res => res.json())
                                .then(data => {
                                    const centros = data.map(d => d.centro);
                                    const pim = data.map(d => d.pim);
                                    const cert = data.map(d => d.certificacion);
                                    const ejecucion = data.map(d => d.ejecucion);

                                    new Chart(document.getElementById("graficoEjecucion"), {
                                        type: "bar",
                                        data: {
                                            labels: centros,
                                            datasets: [{
                                                label: "% Ejecución",
                                                data: ejecucion,
                                                backgroundColor: "#4caf50"
                                            }]
                                        },
                                        options: {
                                            plugins: {
                                                title: {
                                                    display: true,
                                                    text: "% de Ejecución por Centro de Costo"
                                                }
                                            }
                                        }
                                    });

                                    new Chart(document.getElementById("graficoColumnaCentro"), {
                                        type: "bar",
                                        data: {
                                            labels: centros,
                                            datasets: [
                                                {
                                                    label: "PIM",
                                                    data: pim,
                                                    backgroundColor: "#2196f3"
                                                },
                                                {
                                                    label: "Certificación",
                                                    data: cert,
                                                    backgroundColor: "#ff9800"
                                                }
                                            ]
                                        },
                                        options: {
                                            plugins: {
                                                title: {
                                                    display: true,
                                                    text: "PIM vs Certificación por Centro"
                                                }
                                            }
                                        }
                                    });

                                    new Chart(document.getElementById("graficoRadarCentro"), {
                                        type: "radar",
                                        data: {
                                            labels: centros,
                                            datasets: [
                                                {
                                                    label: "Certificación",
                                                    data: cert,
                                                    backgroundColor: "rgba(255,99,132,0.2)",
                                                    borderColor: "rgba(255,99,132,1)"
                                                }
                                            ]
                                        },
                                        options: {
                                            plugins: {
                                                title: {
                                                    display: true,
                                                    text: "Radar de Certificación entre Centros"
                                                }
                                            }
                                        }
                                    });

                                    new Chart(document.getElementById("graficoApiladoClasificador"), {
                                        type: "bar",
                                        data: {
                                            labels: centros,
                                            datasets: [
                                                {
                                                    label: "PIM",
                                                    data: pim,
                                                    backgroundColor: "#03a9f4"
                                                },
                                                {
                                                    label: "Certificación",
                                                    data: cert,
                                                    backgroundColor: "#8bc34a"
                                                }
                                            ]
                                        },
                                        options: {
                                            plugins: {
                                                title: {
                                                    display: true,
                                                    text: "Distribución Apilada por Centro"
                                                }
                                            },
                                            scales: {
                                                x: { stacked: true },
                                                y: { stacked: true }
                                            }
                                        }
                                    });
                                });
                        });
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
