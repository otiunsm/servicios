<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Consulta RUC</h5>
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
                            <h3 class="card-title">Consultar El Registro Único de Contribuyentes (RUC) </h3>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form_ruc">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                <div class="col-6">
                                            <label class="form-label">* Seleccionar Accion:</label>
                                            <select class="form-control" name="opcion">
                                                <option value="DatosPrincipales">Datos Principales del Contribuyente</option>
                                                <option value="DatosSecundarios">Datos Secundarios del Contribuyente</option>
                                                <option value="DatosT1144">Datos Adicionales del Contribuyente</option>
                                                <option value="DatosT362">Datos Complementarios del Contribuyente</option>
                                                <option value="DomicilioLegal">Domicilio Legal</option>
                                                <option value="RepLegales">Representantes Legales</option>
                                            </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>* Número de RUC:</label>
                                        <input type="text" name="ruc" class="form-control" placeholder="" value=""/>
                                    </div>
                                </div>
                                <div class="row justify-content-center" id="sninper" style="display:none">
                                    <div class="spinner spinner-warning spinner-lg mr-15"></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <button type="submit" class="btn btn-success font-weight-bold" id="submitButtonRuc" name="submitButtonRuc">Consultar</button>
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

            <div class="row justify-content-center" id="cardResult" style="display:none">
                <div class="col-lg-12 col-md-8 col-sm-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap py-5">
                            <div class="card-title">
                                <h3 class="card-label">Resultado de Búsqueda RUC
                            </div>
                            <div class="card-toolbar">
                                    <div class="row">
                                        <a href="<?= base_url('consultas/ruc')?>" class="btn btn-warning btn-sm mr-1"><i class="fas fa-search"></i> Nueva Consulta</a>                                   
                                        <form action="<?= base_url('pdfreporte/reporte_ruc')?>" method="post" target="_blak" >
                                            <input type="hidden" name="ruc_number">
                                            <input type="hidden" name="opcion_print">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-print"></i> Imprimir</button>
                                        </form>
                                    </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="accordionExample7">
                                <div class="card">
                                    <div class="card-header" id="headingOne7">
                                        <div class="card-title" data-toggle="collapse" data-target="#collapseOne7">
                                            <span class="svg-icon svg-icon-primary">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Angle-double-right.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero" />
                                                        <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <div class="card-label pl-4" id="title_ruc">Datos Principales del Contribuyente</div>
                                        </div>
                                    </div>
                                    <div id="collapseOne7" class="collapse show" data-parent="#accordionExample7">

                                    </div>
                                </div>
                            </div>
                            <!--end::Accordion-->
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
            </div>
            
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>