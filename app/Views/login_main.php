<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
		<meta charset="utf-8" />
		<title>Universidad Nacional de San Martín - UNSM</title>
		<meta name="description" content="Sistema de Servicios - UNSM" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="public/css/pages/login/classic/login-4d1cf.css?v=7.1.6" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="public/plugins/global/plugins.bundled1cf.css?v=7.1.6" rel="stylesheet" type="text/css" />
		<link href="public/plugins/custom/prismjs/prismjs.bundled1cf.css?v=7.1.6" rel="stylesheet" type="text/css" />
		<link href="public/css/style.bundled1cf.css?v=7.1.6" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="public/css/themes/layout/header/base/lightd1cf.css?v=7.1.6" rel="stylesheet" type="text/css" />
		<link href="public/css/themes/layout/header/menu/lightd1cf.css?v=7.1.6" rel="stylesheet" type="text/css" />
		<link href="public/css/themes/layout/brand/darkd1cf.css?v=7.1.6" rel="stylesheet" type="text/css" />
		<link href="public/css/themes/layout/aside/darkd1cf.css?v=7.1.6" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="public/img/insignia.png" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
		
		<style>
.whatsapp{position:fixed;width:60px;height:60px;bottom:40px;right:40px;background-color:#25d366;color:#fff;border-radius:50px;text-align:center;font-size:30px;z-index:100}.whatsapp-icon{margin-top:13px;color:#fff}
</style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('public/img/bg-3.jpg');">
					<div class="login-form text-center position-relative overflow-hidden">
						<!--begin::Login Header-->
						<div class="d-flex flex-center mb-5">
								<img src="public/img/logo.svg" width="350px" alt="" />
						</div>
						<!--end::Login Header-->
						<!--begin::Login Sign in form-->
						<div class="login-signin">
							<div class="mb-10">
								<h2>Sistema de Gestión de Servicios</h2>
								<div class="text-muted font-weight-bold">Ingrese sus datos para iniciar sesión en su cuenta:</div>
							</div>
							<?php 
                                    if (session()->get('Error')) {
                                    echo '<div class="alert alert-danger" role="alert">
											'.session()->getFlashdata('Error').'
										</div>';
                                    }
                            ?>
							<form class="form" id="kt_login_signin_form">
								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Usuario" name="username"/>
								</div>
								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Contraseña" name="password" />
								</div>
								<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
									<div class="checkbox-inline">
										<label class="checkbox m-0 text-muted">
										<input type="checkbox" name="remember" />
										<span></span>Recordar</label>
									</div>
									<!-- <a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary">Forget Password ?</a> -->
								</div>
								<button id="kt_login_signin_submit" class="btn btn-success font-weight-bold px-9 py-4 my-3 mx-4">Ingresar</button>
							</form>
						</div>
						<!--end::Login Sign in form-->
					</div>
				</div>
			</div>
			<!--end::Login-->
		</div>
		
			<a href="https://wa.me/+51957298019" class="whatsapp" target="_blank" data-toggle="tooltip" data-placement="left" title="WhatsApp para consultas"> <i class="fa fa-whatsapp whatsapp-icon"></i></a>
			
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="public/plugins/global/plugins.bundled1cf.js?v=7.1.6"></script>
		<script src="public/plugins/custom/prismjs/prismjs.bundled1cf.js?v=7.1.6"></script>
		<script src="public/js/scripts.bundled1cf.js?v=7.1.6"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="public/js/pages/custom/login/login-generald1cf.js?v=7.1.6"></script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>