<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Consulta DNI</h5>
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
            <!--begin::Notice-->
            <div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">
                <div class="alert-text"><h6>Módulo para consulta de datos de RENIEC, usando la Plataforma de Interoperabilidad del Estado (PIDE).</h6></div>
            </div>
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="row justify-content-center" id="cardConsulta">
                <div class="col-lg-8 col-md-8 col-sm-6">
                    <!--begin::Card-->
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Consultar Documento Nacional de Identidad (DNI)</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form_1">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-lg-6">
                                        <label>* Número de DNI:</label>
                                        <input type="text" name="dni" class="form-control" placeholder="" value=""/>
                                    </div>
                                </div>
                                <div class="row justify-content-center" id="sninper" style="display:none">
                                    <div class="spinner spinner-warning spinner-lg mr-15"></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <button type="submit" class="btn btn-success font-weight-bold" id="submitButton" name="submitButton">Consultar</button>
                                        <a href="<?= base_url()?>" class="btn btn-light-danger font-weight-bold">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>

            <!-- View  -->
            <div class="row justify-content-center" style="display:none" id="cardResult">
                <div class="col-lg-12 col-md-6 col-sm-6">
                    <!--begin::Card-->
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Datos Personales</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="formConsulta" method="post" action="<?= base_url('pdfreporte/reporte_dni')?>" target="_blank" enctype="multipart/form-data">
			    <!-- <form class="form" id="formConsulta"> -->
                            <div class="card-body">
                               <div class="row">
                                   <div class="col-lg-8 col-md-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Código:</label>
                                                    <input type="text" class="form-control form-control-solid" name="codConsult" disabled/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Documento Nacional de Identidad:</label>
                                                    <input type="text" class="form-control form-control-solid" name="dniConsult" disabled/>
						    <input name="dni" type="hidden" value=""/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Apellido Parterno:</label>
                                                    <input type="text" class="form-control form-control-solid" name="apConsult" disabled/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Apellido Materno:</label>
                                                    <input type="text" class="form-control form-control-solid" name="amConsult" disabled/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Nombre(s):</label>
                                                    <input type="text" class="form-control form-control-solid" name="nomConsult" disabled/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Estado Civil:</label>
                                                    <input type="text" class="form-control form-control-solid" name="estaConsult" disabled/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Ubigeo:</label>
                                                    <input type="text" class="form-control form-control-solid" name="ubiConsult" disabled/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Dirección:</label>
                                                    <input type="text" class="form-control form-control-solid" name="dirConsult" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                   </div>

                                   <div class="col-lg-4 col-md-12">
                                       <center>
                                           <img src="<?= base_url('public/img/insignia.png')?>" id="imgConsul" alt="" width="250px">
                                       </center>
                                   </div>
                               </div>
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-center">
                                    <div class="col-lg-3 col-md-12">
                                        <a href="<?= base_url('/consultas/dni')?>" class="btn btn-warning font-weight-bold">Nueva Consulta</a>
					<button type="submit" class="btn btn-success font-weight-bold" id="">Imprimir</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>

        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
