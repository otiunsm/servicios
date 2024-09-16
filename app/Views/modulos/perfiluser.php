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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Perfil Usuario</h5>
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
                        <h3 class="card-label">Perfil 
                        <span class="d-block text-muted pt-2 font-size-sm">Perfil de Usuario</span></h3>
                    </div>
                </div>
                <form method="POST" action="<?= base_url('/perfiluser/formdata')?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>DNI <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="<?= $DataPerfil['dni']?>" placeholder="Documento Nacional de Identidad" disabled/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre(s) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="nombre_user" value="<?= $DataPerfil['nombre']?>" placeholder="Ingrese el nombre"/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Apellidos <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="apellidos_user" value="<?= $DataPerfil['apellido']?>" placeholder="Ingrese los apellidos"/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Celular </label>
                                    <input type="text" class="form-control" name="celular_user" value="<?= $DataPerfil['telefono']?>" placeholder="Ingrese número de celular"/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" class="form-control" name="direccion_user" value="<?= $DataPerfil['direccion']?>" placeholder="Ingrese la dirección"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Perfil</label>
                                    <input type="text" class="form-control" value="<?= $DataPerfil['nombreperfil']?>" placeholder="Ingrese el perfil" disabled/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Correo Electrónico</label>
                                    <input type="email" class="form-control" name="correo_user" value="<?= $DataPerfil['correo']?>" placeholder="Ingrese un correo electrónico"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Usuario <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="usuario_user" value="<?= $DataPerfil['usuario']?>" placeholder="Ingrese un usuario"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Contraseña <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="clave_user" placeholder="Ingrese un clave"/>
                                    <p class="text-muted small">Mínimo 6 caracteres.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success font-weight-bold">Guardar</button>
                        <a href="javascript:history.back()" class="btn btn-light-danger font-weight-bold">Cancelar</a>
                    </div>
                </form>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->