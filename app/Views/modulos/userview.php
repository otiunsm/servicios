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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Gestionar Usuarios</h5>
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
                        <h3 class="card-label">Lista de Usuarios 
                        <span class="d-block text-muted pt-2 font-size-sm">Tabla de Usuarios</span></h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formUser"><i class="fas fa-user-plus"></i> Nuevo Usuario</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-sm" id="kt_datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Item</th>
                                <th>N° Documento</th>
                                <th>Area</th>
                                <th>Usuario</th>
                                <th>Nombre(s)</th>
                                <th>Apellidos</th>
                                <th>Perfil</th>
                                <th>Celular</th>          
                                <th>Dirección</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            if ($Usuarios) {
                                foreach ($Usuarios as $key => $user) {
                                    echo '
                                    <tr>
                                        <td class="text-center">'.($key+1).'</td>
                                        <td>'.$user['dni'].'</td>
                                        <td>'.$user['nombre_area'].'</td>
                                        <td>'.$user['usuario'].'</td>
                                        <td>'.$user['nombre'].'</td>
                                        <td>'.$user['apellido'].'</td>
                                        <td>'.$user['nombreperfil'].'</td>
                                        <td>'.$user['telefono'].'</td>
                                        <td>'.$user['direccion'].'</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm" id="buttonUserEdit" itemButton="'.$user['id_usuario'].'"><i class="fa fa-user-edit text-success"></i></button>
                                                <button class="btn btn-sm" id="buttonDelete" itemButton="'.$user['id_usuario'].'"><i class="fas fa-user-times text-danger"></i></button>
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
<div class="modal fade" id="formUser" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="user/formData" id="form_user">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="hidden" name="id_item">
                            <div class="form-group">
                                <label>DNI <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  name="dni" placeholder="Documento Nacional de Identidad"/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Nombre(s) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  name="nombre" placeholder="Ingrese el nombre"/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="apellidos" placeholder="Ingrese los apellidos"/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Celular </label>
                                <input type="text" class="form-control" name="celular" placeholder="Ingrese número de celular"/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" class="form-control" name="direccion" placeholder="Ingrese la dirección"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleSelect1">Perfil <span class="text-danger">*</span></label>
                                <select class="form-control" id="exampleSelect1" name="perfil">
                                    <option selected disabled>Seleccione...</option>
                                    <?php 
                                        if ($Perfiles) {
                                            foreach ($Perfiles as $key => $p) {
                                                echo '
                                                <option value="'.$p['id_perfil'].'">'.$p['nombreperfil'].'</option>
                                                ';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <input type="email" class="form-control" name="correo" placeholder="Ingrese un correo electrónico"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Usuario <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="usuario" placeholder="Ingrese un usuario"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="clave" placeholder="Ingrese un clave"/>
                                <p class="text-muted small">Mínimo 6 caracteres.</p>
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