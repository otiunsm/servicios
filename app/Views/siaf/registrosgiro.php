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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Gestionar Gastos en fase Girado</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url()?>" class="text-muted">Panel de Control</a>
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
                        <h3 class="card-label">Lista de Gastos en fase Girado
                        <span class="d-block text-muted pt-2 font-size-sm">Tabla de Gastos en fase Girado</span></h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
     <!--            <button type="button" class="btn btn-primary btn-sm" id="nuevoRegistroBtn" data-toggle="modal" data-target="#form1">
                          <i class="fas fa-user-plus"></i> Nuevo Registro
                        </button> -->

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-sm" id="kt_datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Item</th>
                                <th>id_detalle_obligacion </th>
                                <th>Numero obligacion</th>
                                <th>Fecha compromiso </th>
                                <th>Fase</th>
                                <th>Fuente financiamiento </th>
                                <th>Monto obligado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
					        if ($DataSiaf) {
					            foreach ($DataSiaf as $key => $data) {
					                echo '
					                <tr>
					                    <td class="text-center">'.($key+1).'</td>
					                    <td>'.$data['ano_eje'].'</td>
                                        <td>'.$data['ano_eje'].'</td>
                                        <td>'.$data['ano_eje'].'</td>
                                        <td>'.$data['ano_eje'].'</td>
                                        <td>'.$data['ano_eje'].'</td>
                                        <td>'.$data['ano_eje'].'</td>
					                </tr>';
					            }
					        }
                        ?>
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

<div id="loadingOverlay">
  <div class="spinner"></div>
</div>

<!-- Modal-->
<div class="modal fade" id="form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?=base_url(); ?>/siaf/formData" id="form_siaf">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>N° Comprobante <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="comprobante_pago"  name="comprobante_pago" placeholder="Número de Comprobante"/>
                            </div>
                        </div>                       
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>N° Exp. <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="expediente"  name="expediente" placeholder="Número de expediente"/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Tipo de Giro <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tipo_giro" placeholder="Ingrese el tipo de Giro"/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Nombres </label>
                                <input type="text" class="form-control" name="nombres" placeholder="Ingrese el nombre o razón social"/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Partida específica</label>
                                <input type="text" class="form-control" name="partida_especifica" placeholder="Ingrese un partida_especifica"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Monto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="monto" placeholder="Ingrese el monto"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Fecha Pase <span class="text-danger">*</span></label>
                                <!-- <input type="date" class="form-control" name="fecha_pase" placeholder="Ingrese la fecha pase"/> -->
                                <?php $fecha_actual = date("Y-m-d"); ?>
                                <input type="date" class="form-control" name="fecha_pase" placeholder="Ingrese la fecha pase" value="<?php echo $fecha_actual; ?>"/>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Orden de Compra</label>
                                <input type="text" class="form-control" name="orden_compra" placeholder="Ingrese orden de compra"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Orden de Servicio <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="orden_servicio" placeholder="Ingrese orden de ervicio"/>
                            </div>
                        </div>
                       <div class="col-lg-4">
                            <div class="form-group">
                                <label>Planilla Viático<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="planilla_viatico" placeholder="Ingrese planilla viático"/>
                            </div>
                        </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                                <label>Recibo por honorarios</label>
                                <input type="text" class="form-control" name="recibo_honorarios" placeholder="Ingrese recibo por honorarios"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Observación</label>
                                <input type="text" class="form-control" name="observacion" placeholder="Ingrese observación"/>
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