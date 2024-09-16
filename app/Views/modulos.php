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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Gestionar Modulos</h5>
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
                        <h3 class="card-label">Lista de Modulos
                        <span class="d-block text-muted pt-2 font-size-sm">Tabla de Modulos</span></h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form"><i class="fas fa-user-plus"></i> Nuevo Modulo</button>
                        </div>
                    </div>
                </div>
                <?php
                    // var_dump($Permisos);
                ?>

                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>Nombre Módulo</th>
                                <th>Url Módulo</th>
                                <th>Módulo Padre</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            if ($Modulos) {
                                foreach ($Modulos as $key => $modulo) {
                                    $arrayMod = [];
                                    echo '
                                    <tr>

                                        <td>'.$modulo['id_modulo'].'</td>
                                        <td>'.$modulo['nombremodulo'].'</td>
                                        <td>'.($modulo['urlmodulo'] === null ? '-' : $modulo['urlmodulo']) .'</td>
                                        <td>'.($modulo['nombremodulopadre'] === null ? '-' : $modulo['nombremodulopadre']).'</td>

                                        <td class="text-center">
                                            <div class="btn-group">
                                             
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

<!-- Modal-->
<div class="modal fade" id="form" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="Modulos/formData" id="form_per">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                        	<input type="hidden" name="id_modulo">
                            <div class="form-group">
                                <label>Nombre de Módulo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  name="nombremodulo" placeholder="Nombre Módulo"/>
                            </div>
                        </div>             
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Ruta de Módulo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  name="urlmodulo" placeholder="/ruta" value="/"/>
                            </div>
                        </div>              
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Módulo Padre <span class="text-danger">*</span></label>
                                <select class="form-control" name="idmodulopadre">
                                	    <option value="">Seleccione un módulo (opcional)</option>

			                        <?php foreach ($ModulosPadres as $modulopadre): ?>
			                            <option value="<?= htmlspecialchars($modulopadre['id_modulo']) ?>">
			                                <?= htmlspecialchars($modulopadre['nombremodulo']) ?>
			                            </option>
			                        <?php endforeach; ?>
			                    </select>
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
<div class="modal fade" id="formPerEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="Modulos/formData" id="form_per_edit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="id_item">
                            <div class="form-group">
                                <label>Nombre de Perfil <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  name="nomPerfil" placeholder="Documento Nacional de Identidad"/>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label>Modulos: <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-group row">
                            <?php foreach ($Modulos as $key => $mop): ?>
                            <?php if ($mop['idmodulopadre'] == null): ?>                       
                            <div class="col-lg-12 col-md-12 col-sm-12 p-3">
                                <div class="form-check checkbox-list">
                                    <label class="checkbox checkbox-outline">
                                    <input class="check-<?= $mop['id_modulo']?>" type="checkbox" name="idmodulo_hijo[]" value="<?= $mop['id_modulo']?>"/>
                                    <span></span>
                                    <strong><?= $mop['nombremodulo'] ?></strong>
                                    </label>
                                    <?php foreach ($Modulos as $key1 => $submop): ?>
                                    <?php if ($mop['id_modulo'] == $submop['idmodulopadre']): ?>
                                        <label class="checkbox checkbox-outline">
                                        <input class="check-<?= $submop['id_modulo']?>" type="checkbox" name="idmodulo_hijo[]" value="<?= $submop['id_modulo']?>"/>
                                        <span></span>
                                        <?= $submop['nombremodulo'] ?>
                                        </label>
                                    <?php endif ?>	
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <?php endif ?>
                            <?php endforeach ?>
                        </div>
                            <span class="form-text text-muted">Seleccione al menos 2 opciones</span>
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