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
					<h5 class="text-dark font-weight-bold my-1 mr-5">Bienvenido al Sistema de Gestión de Servicios</h5>
					<!--end::Page Title-->
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
			<h5 class="text-center">Estimado usuario, en este sistema podrá consultar y descargar boletas de pago, así como boletas de CAFAE. Se le recomienda descargar el manual para un mejor manejo del sistema. ¡Esperamos que esta plataforma sea de gran utilidad para usted!. </h5>
		    <div class="d-flex justify-content-center">
    		    <a href="<?= base_url('pdfreporte/pdf_manual')?>" class="btn btn-success">Descargar Manual</a>
		    </div>

		    <div class="d-flex justify-content-center">
    		    <img src="<?= base_url()?>/public/img/logo.svg" alt="">
		    </div>
		    
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>
<!--end::Content-->
<!-- Modal-->
<div class="modal fade" id="ModalClave" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="ModalClaveLabel">Cambiar Contraseña</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
			<form action="<?= base_url('/login/update_password')?>" method="post">
				<div class="modal-body">
					Estimado usuario, por motivos de seguridad se le recomienda cambiar su contraseña.
					<hr>
					<div class="form-group">
						<label>Nueva Contraseña <span class="text-danger">*</span></label>
						<input type="password" class="form-control" name="password_new" placeholder="Nueva Contraseña"/>
					</div>
					<div class="form-group">
						<label>Confirmar Contraseña <span class="text-danger">*</span></label>
						<input type="password" class="form-control" name="password_confirm" placeholder="Confirmar Contraseña"/>
					</div>
				</div>
				<div class="modal-footer">
					<!-- <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button> -->
					<button type="submit" class="btn btn-primary font-weight-bold btn-sm">Aceptar</button>
				</div>
			</form>
        </div>
    </div>
</div>