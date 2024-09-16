<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Consulta Boletas de Pago</h5>
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
    <div id="query_tesoreria" class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Notice-->
            <div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">
                <div class="alert-text"><h6>Módulo para consulta de boletas de pago del Sistema de Tesorería de la UNSM.</h6></div>
            </div>
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="row justify-content-center mb-5 pb-3" id="cardConsulta">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <!--begin::Card-->
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Consultar Boletas de Pago</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form_3">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="row">
                                        <div class="col-12" >
                                            <label for="dni_boletapago" >* Número de DNI:</label>
                                            <?php 
                                                if( session()->get( 'perfil' ) == 'ADMINISTRADOR' || session()->get( 'perfil' ) == 'SUPERADMIN' ){
                                                    echo '<input type="text" name="dni_boletapago" id="dni_boletapago" class="form-control" value=""/>';
                                                }
                                                else{
                                                    echo '<input type="text" name="dni_boletapago" id="dni_boletapago" class="form-control" value="'.session()->get( 'user_dni' ).'" disabled />';
                                                }
                                             ?>
                                        </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-6" >
                                            <label for="periodo_boletapago" class="form-label">* Ingrese Periodo(A&ntilde;o):</label>
                                            <input type="text" class="form-control" id="periodo_boletapago" name="periodo_boletapago" placeholder="Ejm. 2024">
                                        </div>
                                        <div class="col-6" >
                                            <label for="mes_boletapago" class="form-label">* Seleccionar mes:</label>
                                            <select id="mes_boletapago" class="form-control" name="mes" />
                                            <option value="todos" selected>Todos</option> 
                                            <option value="01">Enero</option> 
                                            <option value="02">Febrero</option> 
                                            <option value="03">Marzo</option> 
                                            <option value="04">Abril</option> 
                                            <option value="05">Mayo</option> 
                                            <option value="06">Junio</option> 
                                            <option value="07">Julio</option> 
                                            <option value="08">Agosto</option> 
                                            <option value="09">Septiembre</option> 
                                            <option value="10">Octubre</option> 
                                            <option value="11">Noviembre</option> 
                                            <option value="12">Diciembre</option> 
                                            </select>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center" id="sninper" style="display:none">
                                    <div class="spinner spinner-warning spinner-lg mr-15"></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-center">
                                    <div class="col-lg-2 col-md-2">
                                        <button type="submit" class="btn btn-success font-weight-bold" id="submitButtonBoletaPago" name="submitButtonBoletaPago">Consultar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
            <div class="card card-custom mb-5 pb-3" id="tableConsulta" style="display: none;" >
                <div class="card-header">
                    <button class="btn btn-light-danger font-weight-bold col-lg-1 my-5" id="salir_boletapago" >Atrás</button>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-hover" id="tableBoletaPago" style="margin-top: 13px !important">
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>