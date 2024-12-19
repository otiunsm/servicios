					<!--begin::Footer-->
					<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted font-weight-bold mr-2"><?php echo date("Y"); ?>©</span>
								<a href="https://unsm.edu.pe" target="_blank" class="text-dark-75 text-hover-primary">Universidad Nacional de San Martín - UNSM</a>
							</div>
							<!--end::Copyright-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
					</div>
					<!--end::Wrapper-->
					</div>
					<!--end::Page-->
					</div>
					<!--end::Main-->
					<!-- begin::User Panel-->
					<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
						<!--begin::Header-->
						<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
							<h3 class="font-weight-bold m-0"> <?= session('nombres') ?>
								<small class="text-muted font-size-sm ml-2"><?= session('perfil') ?></small>
							</h3>
							<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
								<i class="ki ki-close icon-xs text-muted"></i>
							</a>
						</div>
						<!--end::Header-->
						<!--begin::Content-->
						<div class="offcanvas-content pr-5 mr-n5">
							<!--begin::Header-->
							<div class="d-flex align-items-center mt-5 justify-content-center">
								<div class="d-flex">
									<div class="navi">
										<a href="<?= base_url('/perfiluser') ?>" class="btn btn-sm btn-light-success font-weight-bolder py-2 px-15">Perfil</a>
										<a href="<?= base_url('/login/logout') ?>" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Cerrar Sesión</a>
									</div>
								</div>
							</div>
							<!--end::Header-->
							<!--begin::Separator-->
							<div class="separator separator-dashed mt-8 mb-5"></div>
							<!--end::Separator-->
						</div>
						<!--end::Content-->
					</div>
					<!-- end::User Panel-->
					<!--begin::Scrolltop-->
					<div id="kt_scrolltop" class="scrolltop">
						<span class="svg-icon">
							<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Up-2.svg-->
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<polygon points="0 0 24 0 24 24 0 24" />
									<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
									<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
								</g>
							</svg>
							<!--end::Svg Icon-->
						</span>
					</div>
					<!--end::Scrolltop-->
					<!--begin::Global Config(global config for global JS scripts)-->
					<script>
						var KTAppSettings = {
							"breakpoints": {
								"sm": 576,
								"md": 768,
								"lg": 992,
								"xl": 1200,
								"xxl": 1400
							},
							"colors": {
								"theme": {
									"base": {
										"white": "#ffffff",
										"primary": "#3699FF",
										"secondary": "#E5EAEE",
										"success": "#1BC5BD",
										"info": "#8950FC",
										"warning": "#FFA800",
										"danger": "#F64E60",
										"light": "#E4E6EF",
										"dark": "#181C32"
									},
									"light": {
										"white": "#ffffff",
										"primary": "#E1F0FF",
										"secondary": "#EBEDF3",
										"success": "#C9F7F5",
										"info": "#EEE5FF",
										"warning": "#FFF4DE",
										"danger": "#FFE2E5",
										"light": "#F3F6F9",
										"dark": "#D6D6E0"
									},
									"inverse": {
										"white": "#ffffff",
										"primary": "#ffffff",
										"secondary": "#3F4254",
										"success": "#ffffff",
										"info": "#ffffff",
										"warning": "#ffffff",
										"danger": "#ffffff",
										"light": "#464E5F",
										"dark": "#ffffff"
									}
								},
								"gray": {
									"gray-100": "#F3F6F9",
									"gray-200": "#EBEDF3",
									"gray-300": "#E4E6EF",
									"gray-400": "#D1D3E0",
									"gray-500": "#B5B5C3",
									"gray-600": "#7E8299",
									"gray-700": "#5E6278",
									"gray-800": "#3F4254",
									"gray-900": "#181C32"
								}
							},
							"font-family": "Poppins"
						};
					</script>
					<!--end::Global Config-->
					<!--begin::Global Theme Bundle(used by all pages)-->

					<script src="<?= base_url() ?>/plugins/global/plugins.bundled1cf.js?v=7.1.6"></script>
					<script src="<?= base_url() ?>/plugins/custom/prismjs/prismjs.bundled1cf.js?v=7.1.6"></script>
					<script src="<?= base_url() ?>/js/scripts.bundled1cf.js?v=7.1.6"></script>
					<script src="<?= base_url() ?>/js/pages/toastr.js?v=7.1.6"></script>
					<script src="<?= base_url() ?>/plugins/custom/datatables/datatables.bundled1cf.js?v=7.1.6"></script>
					
					<?php if (!isset($serverDatable) || $serverDatable !== true): ?>
						<script src="<?= base_url() ?>/plugins/custom/datatables/paginationsd1cf.js?v=7.1.6"></script>
					<?php endif; ?>

					<script src="<?= base_url() ?>/js/pages/sweetalert2.js?v=7.1.6"></script>
					<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> <!--agregado cdn jquery para el selct-->

					

					<!--end::Global Theme Bundle-->

					<!-- Load Styles -->
					<?php foreach ($scripts as $script): ?>
						<script src="<?= base_url() ?>/<?= esc($script) ?>"></script>
					<?php endforeach ?>
					<!-- Fin Load Styles -->

					<script src="<?= base_url() ?>/js/table/htmld1cf.js?v=7.1.6"></script>

					<?php

					if (session()->get('estado_clave') == 0) {
						echo
						'<script>
    		$("#ModalClave").modal("show");
    	</script>';
					};

					if (session()->getFlashdata('AlertShow')) {
						$mensaje = session()->getFlashdata('AlertShow');
						echo
						'<script>
			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": false,
				"progressBar": true,
				"positionClass": "toast-top-center",
				"preventDuplicates": true,
				"onclick": null,
				"showDuration": "500",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			};
			
			toastr.' . $mensaje['Tipo'] . '("' . $mensaje['Mensaje'] . '")
		</script>';
					}

					if (session()->getFlashdata('AlertShowCode')) {
						$mensaje = session()->getFlashdata('AlertShowCode');
						foreach ($mensaje as $key => $value) {
							echo
							'<script>
				toastr.options = {
					"closeButton": false,
					"debug": false,
					"newestOnTop": false,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"preventDuplicates": true,
					"onclick": null,
					"showDuration": "500",
					"hideDuration": "1000",
					"timeOut": "5000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				};
				
				toastr.error("' . $value . '")
			</script>';
						}
					}
					?>
					</body>
					<!--end::Body-->
					<div id="kt_form_1"></div>
					<div id="kt_form_2"></div>
					<div id="kt_form_3"></div>
					<div id="kt_form_ruc"></div>
					<div id="kt_form_100"></div>

					</html>