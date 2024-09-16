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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Gestionar Registros SIAF</h5>
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
                        <h3 class="card-label">Lista de Registros SIAF 
                        <span class="d-block text-muted pt-2 font-size-sm">Tabla de Registros SIAF</span></h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                <button type="button" class="btn btn-primary btn-sm" id="nuevoRegistroBtn" data-toggle="modal" data-target="#form1">
                          <i class="fas fa-user-plus"></i> Nuevo Registro
                        </button>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-sm" id="kt_datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Item</th>
                                <th>Comprobante de Pago</th>
                                <th>Expediente</th>
                                <th>Tipo Giro</th>
                                <th>Nombres</th>
                                <th>Partida Específica</th>
                                <th>Monto</th>
                                <th>Fecha de Pase</th>
                                <th>Orden de Compra</th>
                                <th>Orden de Servicio</th>
                                <th>Planilla Viáticos</th>
                                <th>Recibo por honorarios</th>
                                <th>Exp. SGD</th>
                                <th>Asunto SGD</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
					        if ($DataSiaf) {




					            foreach ($DataSiaf as $key => $data) {
					                echo '
					                <tr>
					                    <td class="text-center">'.($key+1).'</td>
					                    <td>'.$data['comprobante_pago'].'</td>
					                    <td>'.$data['expediente'].'</td>
					                    <td>'.$data['tipo_giro'].'</td>
					                    <td>'.$data['nombres'].'</td>
					                    <td>'.$data['partida_especifica'].'</td>
					                    <td>S/.'.$data['monto'].'</td>
					                    <td>'.strftime("%d-%m-%Y", strtotime($data['fecha_pase'])).'</td>
					                    <td>'.$data['orden_compra'].'</td>
					                    <td>'.$data['orden_servicio'].'</td>
					                    <td>'.$data['planilla_viatico'].'</td>
					                    <td>'.$data['recibo_honorarios'].'</td>
					                    <td>'.$data['exp_sgd'].'</td>
                                        <td>'.$data['asunto_sgd'].'</td>
					                    <td class="text-center">
					                        <div class="btn-group">
					                            <button class="btn btn-sm" id="buttonEdit" itemButton="'.$data['id'].'"><i class="fa fa-edit text-success"></i></button>
					                           
					                        </div>
					                    </td>
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
  <div class="spinner2"></div>
</div>

<!-- Modal-->
<div class="modal fade" id="form1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearModalInputs()">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="<?=base_url(); ?>/siaf/formData" id="form_siaf">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>N° Comprob. <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="comprobante_pago"  name="comprobante_pago" placeholder="Número de Comprobante" />
                            </div>
                            <input type="hidden" name="numero_comprobante" value="">
                        </div>                       

                        <div class="col-lg-2">
                          <div class="form-group">
                            <label>N° Exp. Siaf <span class="text-danger">*</span></label>
                            <div class="input-group"> <input type="text" class="form-control" id="expediente" name="expediente">
                              <div class="input-group-append"> <button type="button" class="btn btn-primary btn-sm" name="buscar_expediente" data-toggle="modal" data-target="#form2"><i class='fa fa-search'></i></button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Tipo de Giro <span class="text-danger">*</span></label>
                                <select class="form-control" id="tipoGiroSelect" name="tipo_giro">
                                    <option selected disabled>Seleccione...</option>
                                    <?php 
                                        if (isset($TipoGiro)) {
                                            foreach ($TipoGiro as $key => $tg) {
                                                echo '
                                                <option value="'.$tg['id'].'">'.$tg['tipo_giro'].'</option>
                                                ';
                                            }
                                        }
                                    ?>
                                </select>
  <!--                              <div class="form-group" id="otroInput">
                                    <input type="text" class="form-control" name="otro_valor" placeholder="Ingrese otro valor">
                                </div> -->

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nombres o Razón Social</label>
                                <input type="text" class="form-control" name="nombres" placeholder="Nombre o razón social"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Partida específica</label>
                                <input type="text" class="form-control" name="partida_especifica" placeholder="Partida especifica"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Monto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="monto" placeholder="Monto"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Fecha Pase <span class="text-danger">*</span></label>
                                <!-- <input type="date" class="form-control" name="fecha_pase" placeholder="Ingrese la fecha pase"/> -->
                                <?php $fecha_actual = date("Y-m-d"); ?>
                                <input type="date" class="form-control" name="fecha_pase" placeholder="Fecha pase" value="<?php echo $fecha_actual; ?>"/>

                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Orden de Compra</label>
                                <input type="text" class="form-control" name="orden_compra" placeholder="Orden de compra"/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Orden de Servicio <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="orden_servicio" placeholder="Orden de ervicio"/>
                            </div>
                        </div>
                       <div class="col-lg-3">
                            <div class="form-group">
                                <label>Planilla Viático<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="planilla_viatico" placeholder="Planilla viático"/>
                            </div>
                        </div>
                          <div class="col-lg-3">
                            <div class="form-group">
                                <label>Recibo por honorarios</label>
                                <input type="text" class="form-control" name="recibo_honorarios" placeholder="Recibo por honorarios"/>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>N° Exp. SGD</label>
                                 <input type="text" class="form-control" name="exp_sgd" placeholder="Exp. SGD"/>
                            </div>
                        </div>                        
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label>Asunto Exp. SGD</label>
                                 <input type="text" class="form-control" name="asunto_sgd" placeholder="Asunto SGD"/>
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


<!-- Modal-->
<div class="modal fade" id="form2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registros de Exp. N°</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
                
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-sm" id="#">
                        <thead>
                            <tr>
                                <th class="text-center">Item</th>
                                <th>Nombres o Razon Social</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Acción</th>
        
                            </tr>
                        </thead>
                        <tbody id="registros">

                        <tbody>
                    </table>
                    <!--end: Datatable-->
                </div>

        </div>
    </div>
</div>