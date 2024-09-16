<?php
// $img = "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";

// $base = base64_decode($img);
// file_put_contents('unodepiera.png', $base); 
// echo '<img src="'.base_url().'/public/img/insignia.png" alt="">';
// echo '<img src="'.base_url().'/unodepiera.png" alt="">';
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Gestionar Perfiles</h5>
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
                        <h3 class="card-label">Lista de Perfiles
                        <span class="d-block text-muted pt-2 font-size-sm">Tabla de Perfiles</span></h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formPer"><i class="fas fa-user-plus"></i> Nuevo Perfil</button>
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
                                <th class="text-center">Item</th>
                                <th>Nombre Perfil</th>
                                <th>Permisos/Modulos</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            if ($Perfiles) {
                                foreach ($Perfiles as $key => $per) {
                                    $arrayMod = [];
                                    foreach ($Permisos as $key1 => $permiso) {
                                        if ($per['id_perfil'] == $permiso['idperfilpermiso'] && $permiso['idmodulopadre'] != null) {
                                            $mod = array_push($arrayMod, $permiso['nombremodulo']);
                                        }
                                    }
                                    echo '
                                    <tr>
                                        <td class="text-center">'.($key+1).'</td>
                                        <td>'.$per['nombreperfil'].'</td>
                                        <td>'.implode(',', $arrayMod).'</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn" id="buttonPerEdit" itemButton="'.$per['id_perfil'].'"><i class="fa fa-user-edit text-success"></i></button>
                                                <button class="btn" id="buttonDelete" itemButton="'.$per['id_perfil'].'"><i class="fas fa-user-times text-danger"></i></button>
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
<div class="modal fade" id="formPer" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="perfiles/formData" id="form_per">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
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
                                    <input type="checkbox" name="idmodulo_hijo[]" value="<?= $mop['id_modulo']?>"/>
                                    <span></span>
                                    <strong><?= $mop['nombremodulo'] ?></strong>
                                    </label>
                                    <?php foreach ($Modulos as $key1 => $submop): ?>
                                    <?php if ($mop['id_modulo'] == $submop['idmodulopadre']): ?>
                                        <label class="checkbox checkbox-outline">
                                        <input type="checkbox" name="idmodulo_hijo[]" value="<?= $submop['id_modulo']?>"/>
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
            <form method="POST" action="perfiles/formData" id="form_per_edit">
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