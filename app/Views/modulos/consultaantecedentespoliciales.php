<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Consulta Antecedentes Policiales</h5>
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
                <div class="alert-text"><h6>Módulo para consulta de datos de Antecedentes Policiales, usando la Plataforma de Interoperabilidad del Estado (PIDE).</h6></div>
            </div>
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="row justify-content-center mb-5 pb-3" id="cardConsulta">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <!--begin::Card-->
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Consultar Antecedentes Policiales</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form_100">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="col-12" >
                                            <label for="typeDoc" class="form-label">* Seleccionar Tipo de Documento:</label>
                                            <select id="typeDoc" class="form-control" name="typeDoc" />
                                            <option value="1">Carnet de Identificación Policial</option> 
                                            <option value="2">DNI</option> 
                                            <option value="3">Carnet de Extranjería</option> 
                                            <option value="4">Pasaporte</option>  
                                            </select>
                                        </div>
                                        <div class="col-12" >
                                            <label for="documentAntPol" >* Número de Documento:</label>
                                            <input type="text" name="documentAntPol" id="documentAntPol" class="form-control" value=""/>
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
                                        <button type="submit" class="btn btn-success font-weight-bold" id="submitButtonAntPol" name="submitButtonAntPol">Consultar</button>
                                    </div>
                                </div>
                                <div id="alertAntPol" ></div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
            <div class="row justify-content-center" style="display:none" id="consultAntePol">
                <div class="col-lg-12 col-md-6 col-sm-6">
                    <!--begin::Card-->
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Datos</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="formConsultaAntPol" method="post" action="<?= base_url('pdfreporte/reporte_antecedentespoliciales')?>" enctype="multipart/form-data">
                <!-- <form class="form" id="formConsulta"> -->
                            <div class="card-body">
                               <div class="container col-12">
                                   <div class="col-lg-12 col-md-12 mx-auto">
                                       <p style="text-align: center; font-size: 15px; font-weight: bold;" >SE REGISTRA LOS SIGUIENTES DATOS</p>
                                        <div class="row col-12">
                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Tipo de Documento:</label>
                                                    <input type="text" class="form-control form-control-solid" name="typeDocConsult1" disabled/>
                                                    <input name="typeDocConsult2" id="typeDocConsult2" type="hidden" value=""/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Documento:</label>
                                                    <input type="text" class="form-control form-control-solid" name="docConsult" disabled/>
                                                    <input name="doc" id="doc" type="hidden" value=""/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Código Persona:</label>
                                                    <input type="text" class="form-control form-control-solid" name="codPersona" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Apellido Parterno:</label>
                                                    <input type="text" class="form-control form-control-solid" name="apConsult" disabled/>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Apellido Materno:</label>
                                                    <input type="text" class="form-control form-control-solid" name="amConsult" disabled/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Nombre(s):</label>
                                                    <input type="text" class="form-control form-control-solid" name="nomConsult" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Nombre del Padre:</label>
                                                    <input type="text" class="form-control form-control-solid" name="nombrePadre" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Nombre de la Madre:</label>
                                                    <input type="text" class="form-control form-control-solid" name="nombreMadre" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Doble Identidad:</label>
                                                    <input type="text" class="form-control form-control-solid" name="dobIdentidad" disabled/>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Homonimia:</label>
                                                    <input type="text" class="form-control form-control-solid" name="homonimia" disabled/>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Lugar de Nacimiento:</label>
                                                    <input type="text" class="form-control form-control-solid" name="lugarNacimiento" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Fecha de Nacimiento:</label>
                                                    <input type="text" class="form-control form-control-solid" name="fechaNacimiento" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Sexo:</label>
                                                    <input type="text" class="form-control form-control-solid" name="sexo" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label>Talla:</label>
                                                    <input type="text" class="form-control form-control-solid" name="talla" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                   </div>
                               </div>
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-center">
                                    <div class="col-lg-5 col-md-12 mx-auto text-center">
                                        <a href="<?= base_url('/consultas/antecedentespoliciales')?>" class="btn btn-warning font-weight-bold mx-auto">Nueva Consulta</a>
                    <button type="submit" class="btn btn-success font-weight-bold mx-auto print_antecedentespoliciales" id="">Imprimir</button>
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