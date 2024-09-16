<!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Universidad Nacional de San Martín - UNSM</title>
	<meta name="description" content="Sistema de Servicios - UNSM">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="/img/insignia.png">
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="/assets/login/css/bootstrap.min.css">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="/assets/login/css/fontawesome-all.min.css">
	<!-- Flaticon CSS -->
	<link rel="stylesheet" href="/assets/login/font/flaticon.css">
	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="/assets/login/css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<section class="fxt-template-animation fxt-template-layout4">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-12 fxt-bg-wrap">
					<div class="fxt-bg-img" data-bg-image="/img/bg4-f2.jpg">
						<div class="fxt-header">
							<div class="fxt-transformY-50 fxt-transition-delay-1">
								<a href="#" class="fxt-logo"><img src="/img/logo.png" alt="Logo"></a>
							</div>
							<div class="fxt-transformY-50 fxt-transition-delay-2">
								<h1>Sistema de Gestión de Servicios</h1>
							</div>
							<div class="fxt-transformY-50 fxt-transition-delay-3">
								<p>(Administrativos y Docentes)</p>
							</div>
							<div class="fxt-transformY-50 fxt-transition-delay-4">
								<p>Descargar boletas de pago, boletas de CAFAE, Consulta Reniec, etc.</p>
							</div>
							
						</div>
						<ul class="fxt-socials">
							
						</ul>
					</div>
				</div>
				<div class="col-md-6 col-12 fxt-bg-color">
					<div id="kt_login" class="fxt-content">
							<div class="mb-10">
								<div class="text-muted font-weight-bold">INGRESE SUS DATOS PARA INICIAR SESIÓN</div>
							</div>
						<div class="fxt-form">
							<?php 
                                  if (session()->get('Error')) {
                                    echo '<div class="alert alert-danger" role="alert">Usuario o contraseña incorrecta</div>';
                                    }
                                    
                            ?>
							<form class="form">
								<div class="form-group">
									<label for="username" class="input-label">Usuario</label>
									<input type="text" id="username" class="form-control" name="username" placeholder="" required="required">
								</div>
								<div class="form-group">
									<label for="password" class="input-label">Contraseña</label>
									<input id="password" type="password" class="form-control" name="password" placeholder="" required="required">
									<i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
								</div>
								<div class="form-group">
									<div class="fxt-checkbox-area">
										<div class="checkbox">
											<input id="checkbox1" type="checkbox">
											<label for="checkbox1">Recordar</label>
										</div>
										<!-- <a href="forgot-password-4.html" class="switcher-text">Forgot Password</a> -->
									</div>
								</div>
								<div class="form-group">
									<button type="submit" id="login_submit" class="fxt-btn-fill">Ingresar</button>
								</div>
							</form>
						</div>
						<div class="fxt-footer">
							<p>¿Tienes algún problema para acceder?<a href="https://wa.me/+51957298019" target="_blank" class="switcher-text2 inline-text">Contactar</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	

	
	
	
	<!-- jquery-->
	<script src="/assets/login/js/jquery-3.5.0.min.js"></script>
	<!-- Bootstrap js -->
	<script src="/assets/login/js/bootstrap.min.js"></script>
	<!-- Imagesloaded js -->
	<script src="/assets/login/js/imagesloaded.pkgd.min.js"></script>
	<!-- Validator js -->
	<script src="/assets/login/js/validator.min.js"></script>
	<!-- Custom Js -->
	<script src="/assets/login/js/main.js"></script>
	<script src="/assets/login/js/login.js"></script>

</body>

</html>