<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>

	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{{-- <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/logo-white.png') }}"> --}}
	<link rel="shortcut icon" href="{{ asset('images/settings/' . get_setting_value('faviconicon')) }}"
		style="object-fit: cover;" class="brand-image img-circle">

	<link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
	{{-- select2 --}}
	<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/custom-dashboard.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<style>
		.insights-box:not(.last) {
			border-right: 1px solid #b1babe;
		}

		thead tr th {
			border: none !important;
		}

		.is-invalid .select2-selection {
			border-color: #dc3545 !important;
		}

		[class*=sidebar-dark-] {
			background-color: #3c4252;
		}

		.invalid-feedback {
			font-size: 90%;
		}

		/* Start: Loader css */
		.loader-container {
			width: 100%;
			height: 100vh;
			background-color: rgba(17, 17, 17, 0.288);
			position: fixed;
			display: flex;
			align-items: center;
			justify-content: center;
			z-index: 9999;
			flex-flow: column wrap;
		}

		.loader {
			border-top-color: transparent;
			animation: loader 4s linear infinite;
		}

		.loader-text {
			font-weight: 700;
			color: white;
			font-size: 1.3rem;
		}

		.brand-link {
			height: 50px;
		}

		@keyframes loader {
			to {
				transform: rotate(360deg);
			}
		}
		input[type="file"] {
			height: auto !important;
		}
		
		td a.btn{
			padding : 0.375rem 0.350rem !important;
		}

		/* End: Loader css */
	</style>
	@yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		<!-- Preloader -->
		<div class="loader-container" style="display: none">
			<div class="loader">
				<img src="{{ asset('images/logo/loader.svg') }}" class="brand-image img-circle" />
			</div>
		</div>

		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
		</nav>

		@include('admin.layouts.sidebar')

		<div class="content-wrapper">
			@yield('content')
		</div>

		<footer class="main-footer">
			<strong>Copyright &copy; {{ date('Y') }} </strong> All rights reserved.
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->

		@role(Config::get('constants.users_roles.customer'))
			@if(!auth()->user()->phone && empty(session()->get('previousUsers')))
				{{--  Add phone number  --}}
				<div class="modal fade" id="addPhoneModal" tabindex="-1" role="dialog" aria-labelledby="addPhoneLabelModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="addPhoneLabelModal">To authenticate your account update your phone number to proceed.</h5>
							</div>
							<form id="addPhoneForm" method="POST" action="{{ route('user.add-number') }}">
								@csrf
								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<input type="hidden" name="token" value="{{ csrf_token() }}">
												<input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" required placeholder="Phone">
												@error('phone')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<button type="submit" class="btn btn-primary float-right">Add Number</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				{{--  Add phone number  --}}
			@endif
		@endrole
	</div>
	<!-- ./wrapper -->

	<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	{{-- select2 --}}
	<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
	<script src="{{ asset('js/adminlte.min.js') }}"></script>
	<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
	<script src="{{ asset('js/toastr.min.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script>
		/* Hide alert messge */
		if ($('.alert-success').is(":visible")) {
			setTimeout(function() {
				$('.alert-success').fadeOut()
			}, 3000);
		}
		// $("body").overlayScrollbars({ });
		$('.sidebar').overlayScrollbars({});

		$('.select2').select2({
			placeholder: 'Select options',
			allowClear: true
		});

		$(".select2").on("select2:close", function(e) {
			$(this).valid();
		});

		$("#addPhoneModal").modal('show');

		/* START: toast messages */
		toastr.options = {
			"closeButton": true,
			"progressBar": true
		}

		@if (Session::has('success'))
			toastr.success("{{ session('success') }}");
			@php
				Session::forget('success');
			@endphp
		@endif

		@if (Session::has('error'))
			toastr.error("{{ session('error') }}");
			@php
				Session::forget('error');
			@endphp
		@endif

		@if (Session::has('info'))
			toastr.info("{{ session('info') }}");
			@php
				Session::forget('info');
			@endphp
		@endif

		@if (Session::has('warning'))
			toastr.warning("{{ session('warning') }}");
			@php
				Session::forget('warning');
			@endphp
		@endif
		/* END: toast messages */

		/* Start: loader js */
		$(document).bind('ajaxStart', function() {
			$(".loader-container").show();
		}).bind('ajaxStop', function() {
			$(".loader-container").fadeOut(100);
		}).bind('ajaxSend', function(request, status, error) {
			// $(".loader-container").fadeOut(100);
			// toastr.error('Something went wrong.');
		});
		/* End: loader js */

		$(document).on("submit", "form:not(form.disabledSubmit)", function(event) {
			event.preventDefault();
			if ($(this).valid() == true) {
				$(this).find("[type=submit]").attr("disabled", true);
				this.submit();
			}
		});

		$("#addPhoneForm").validate({
			ignore: [],
			rules: {
				phone: {
					required: true,
					minlength: 8,
					maxlength: 15
				}
			},
			errorElement: 'span',
			errorClass: 'invalid-feedback',
			highlight: function(element, errorClass, validClass) {
				$(element).addClass('is-invalid');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).removeClass('is-invalid');
			},
			errorPlacement: function(error, element) {
				$(element).parent('.form-group').append(error[0]);
			}
		});
	</script>

	@yield('js')

</body>

</html>
