<?php
?>
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Control Presupuestal</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>" class="text-muted">Panel de Control</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
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
                        <h3 class="card-label">Lista
                        <span class="d-block text-muted pt-2 font-size-sm">Tabla de Control Presupuestal</span></h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formRegistro">
                                <i class="fas fa-plus"></i> Registrar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                        <thead>
                            <tr class="text-center">
                                <th>Item</th>                                
                                <th>Categoria Presupuestal</th>
                                <th>Programa Presupuestal</th>
                                <th>Fuente de Financiamiento</th>
                                <th>Metas</th>
                                <th>Clasificador</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detalles as $index => $detalle): ?>
                                <tr class="text-center">
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($detalle['nombre_categoria']) ?></td>
                                    <td><?= esc($detalle['nombre_programa']) ?></td>                                
                                    <td><?= esc($detalle['nombre_fuente']) ?></td>
                                    <td><?= esc($detalle['nombre_meta']) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('ControlPresupuestal/ControlGastos/' .$detalle['id_categoria'].'/'. $detalle['id_programa'] . '/' . $detalle['id_fuente'] . '/' . $detalle['id_meta']) ?>" class="btn btn-outline-primary" name="ingresar">
                                                Ingresar
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="<?= base_url('ControlPresupuestal/ResumenGastos/' .$detalle['id_categoria'].'/'. $detalle['id_programa'] . '/' . $detalle['id_fuente'] . '/' . $detalle['id_meta']) ?>" class="btn btn-outline-success" name="resumen">
                                                Resumen
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn" onclick="eliminarControl()">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->

<!-- Modal Registrar-->
<div class="modal fade" id="formRegistro" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="kt_login2">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registro de Control Presupuestal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form method="POST" action="<?= base_url('ControlPresupuestal/formData') ?>" id="form_clasi">
                <div class="modal-body">
                    <!-- Categoria Presupuestal -->
                    <div class="form-group">
                        <label>Categoria Presupuestal <span class="text-danger">*</span></label>
                        <select class="selectpicker form-control" name="id_categoria" data-live-search="true" id="categoriaPresupuestal" title="Elige una categoria presupuestal...">
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= esc($categoria['id_categoria']) ?>"><?= esc($categoria['codigo_categoria']) ?> - <?= esc($categoria['nombre_categoria']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                
                    <!-- Programa Presupuestal -->
                    <div class="form-group">
                        <label>Programa Presupuestal <span class="text-danger">*</span></label>
                        <select class="selectpicker form-control" name="id_programa" data-live-search="true" id="programaPresupuestal" title="Elige un programa presupuestal...">
                            <?php foreach ($programas as $programa): ?>
                                <option value="<?= esc($programa['id_programa']) ?>"><?= esc($programa['codigo_programa']) ?> - <?= esc($programa['nombre_programa']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Fuente de Financiamiento -->
                    <div class="form-group">
                        <label>Fuente de Financiamiento <span class="text-danger">*</span></label>
                        <select class="selectpicker form-control" name="id_fuente" data-live-search="true" id="fuenteFinanciamiento" title="Elige una fuente de financiamiento...">
                            <?php foreach ($fuentes as $fuente): ?>
                                <option value="<?= esc($fuente['id_fuente']) ?>"><?= esc($fuente['codigo_fuente']) ?> - <?= esc($fuente['nombre_fuente']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Meta -->
                    <div class="form-group">
                        <label>Meta <span class="text-danger">*</span></label>
                        <select class="selectpicker form-control" name="id_meta" data-live-search="true" id="meta" title="Elige una meta...">
                            <?php foreach ($metas as $meta): ?>
                                <option value="<?= esc($meta['id_meta']) ?>"><?= esc($meta['codigo_meta']) ?> - <?= esc($meta['nombre_meta']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Clasificadores (Multiselect) -->
                    <div class="form-group">
                        <label>Clasificadores <span class="text-danger">*</span></label>
                        <select class="selectpicker form-control" name="clasificadores[]" data-live-search="true" multiple id="clasificadores" title="Elige los clasificadores...">
                            <?php foreach ($clasificadores as $clasificador): ?>
                                <option value="<?= esc($clasificador['id_clasificador']) ?>"><?= esc($clasificador['codigo_clasificador']) ?> - <?= esc($clasificador['nombre_clasificador']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Button to Add Entry -->
                    <div class="modal-footer">
                        <button type="button" id="agregar" class="btn btn-primary font-weight-bold">Agregar a la lista</button>
                    </div>

                    <!-- Table to Display Entries -->
                    <div class="table-responsive">
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                            <thead>
                                <tr class="text-center">
                                    <th>Item</th>
                                    <th>Categoria Presupuestal</th>
                                    <th>Programa Presupuestal</th>
                                    <th>Fuente de Financiamiento</th>
                                    <th>Meta</th>
                                    <th>Clasificadores</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Placeholder for dynamically added rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
            
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="submit" id="submitButton2" class="btn btn-success font-weight-bold">Guardar</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

</script>