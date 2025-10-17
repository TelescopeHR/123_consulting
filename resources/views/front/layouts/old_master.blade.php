<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>@yield('title')</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />

	@if (Session::has('download.in.the.next.request'))
		<meta http-equiv="refresh"
			content="5;url={{ route('download.policy', session()->get('download.in.the.next.request')) }}">
	@endif

	<meta name="description" content="@yield('meta_description')">
	<meta name="keywords" content="@yield('meta_keyword')">

	<link rel="canonical" href="{{ url()->current() }}">

	<meta property="og:locale" content="en_US">
	<meta property="og:type" content="article">
	<meta property="og:title" content="@yield('title')">
	<meta property="og:description" content="@yield('meta_description')">
	<meta property="og:url" content="@yield('meta_image', asset('front/images/thumbnail-logo.png'))">
	<meta property="og:site_name" content="123 Consulting Solutions">

	<meta property="og:image" content="@yield('meta_image', asset('front/images/thumbnail-logo.png'))">
	<meta property="og:image:width" content="2560">
	<meta property="og:image:height" content="1708">
	<meta property="og:image:type" content="image/jpeg">

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:label1" content="Est. reading time">
	<meta name="twitter:data1" content="1 minute">

	<!--Favicon-->
	<link rel="icon" href="{{ asset('images/settings/' . get_setting_value('faviconicon')) }}" sizes="32x32" />
	<link rel="icon" href="{{ asset('images/settings/' . get_setting_value('faviconicon')) }}" sizes="192x192" />
	<link rel="apple-touch-icon" href="{{ asset('images/settings/' . get_setting_value('faviconicon')) }}" />
	<meta name="msapplication-TileImage" content="{{ asset('images/settings/' . get_setting_value('faviconicon')) }}" />

	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('front/css/custom.css') }}" />
	<link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/fontawesome.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/brands.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/solid.css') }}">
	<link rel="stylesheet" href="{{ asset('star-ratings/star-rating-svg.css') }}">

	@yield('css')

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-166957706-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'UA-166957706-1');
	</script>
</head>

<body class="@error('offer_email') body-popup @enderror">
	@include('front.layouts.header')

	@yield('content')

	@include('front.layouts.footer')

	<div class="modal fade fbt-courses-modal" id="fbtCoursesModal" tabindex="-1" role="dialog"
		aria-labelledby="fbtCoursesModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Frequently bought together</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-0"></div>
				<div class="modal-footer">
					<a class="bttn bttn-secondary d-flex align-items-center" href="{{ route('cart') }}" title="Go to Cart">
						<i class="icon-cart me-2"></i>
						<span class="bttn-text">Go to Cart</span>
					</a>
				</div>
			</div>
		</div>
	</div>
	{{-- Frequently bought together model --}}

	<!--Scripts-->
	<!-- Bootstrap 5 js Link -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
	</script>
	<!-- jQuery -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

	<!-- Slick slider js -->
	<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<script src="{{ asset('assets/js/main.js') }}"></script>

	<script type="text/javascript" src="{{ asset('star-ratings/jquery.star-rating-svg.js') }}"></script>

	<script src="{{ asset('plugins/jquery/jquery-ui.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('star-ratings/jquery.star-rating-svg.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script>
		$('.offer_phone').mask('+1 (000)-000-0000');

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

		@if (Session::has('status'))
			toastr.success("{{ session('status') }}");
			@php
				Session::forget('status');
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

		set_ratings_star();

		function set_ratings_star() {
			$(".course-ratings-box").starRating({
				initialRating: 0,
				strokeWidth: 0,
				minRating: 0.5,
				starSize: 20,
				ratedColor: 'orange',
				activeColor: 'orange',
				readOnly: true,
				disableAfterRate: true,
			});

			$.each($(".course-ratings-box"), function(indexOfElement, formElement) {
				$(this).starRating('setRating', parseFloat($(this).data('average-ratings')), false);
			});
		}

		$(document).on("click", "a.btn-add-cart", function(event) {
			event.preventDefault();
			let url = $(this).attr("href");

			$.ajax({
				url: url,
				method: 'get',
				dataType: 'json',
				data: {},
				success: function(response) {
					if (response.status) {
						toastr.success(response.message);
						$("#fbtCoursesModal").find(".modal-body").html(response.data);

						if ($("#fbtCoursesModal").is(":visible") == false) {
							if (response.modelShow) {
								$("#fbtCoursesModal").modal("show");
							}
						} else {
							if (response.modelShow == false) {
								$("#fbtCoursesModal").modal("hide");
							}
						}

						$(".cart-item-count").html(`(${response.cart_count})`);

						if ($("a.category.active").length) {
							getCourseList();
						}

						if ($(".metabox-addtocart").length) {
							$(".metabox-addtocart").html(
								`<a href="{{ route('cart') }}" class="bttn bttn-secondary" title="Go to Cart">Go to Cart</a>`
							)
						}
					} else {
						toastr.error(response.message);
					}
				}
			});
		});

		const getCouponForm = $("#get-coupon-form").validate({
			ignore: [],
			rules: {
				offer_phone: {
					required: true,
					minlength: 17
				},
				offer_email: {
					required: true,
					email: true
				}
			},
			messages: {
				offer_phone: {
					required: "Please enter your phone number",
					minlength: "Please enter a valid phone number"
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
				$(error[0]).insertAfter(element);
			},
			submitHandler: function(form, event) {
				event.preventDefault();
				if ($(form).valid()) {
					$(form).find("[type=submit]").attr("disabled", true);
					form.submit();
				}
			}
		});

		$(document).on('click', '.download-popup', function() {
			const id = $(this).data('id');
			$('#policy_id').val(id);
			$('#download-policy').show();
			$('#download-policy').addClass('popup-show');
			$("body").addClass("body-popup");
		});

		// open coupon pop up for lead after 3 second of page load
		@if (!Session::has('popup-closed') && Route::is('front.home'))
			setTimeout(() => {
				$('#global-coupon-trigger').trigger('click');
			}, 5000)
		@endif

		$('#coupon-offer').on('classChange', function(event) {
			$.ajax({
				type: "GET",
				url: "{{ route('popup-closed') }}",
				dataType: 'json',
				global: false
			});
		});
	</script>
	<!--Start of Tawk.to Script-->
	<script type="text/javascript">
		var Tawk_API = Tawk_API || {},
			Tawk_LoadStart = new Date();
		(function() {
			var s1 = document.createElement("script"),
				s0 = document.getElementsByTagName("script")[0];
			s1.async = true;
			s1.src = 'https://embed.tawk.to/642421874247f20fefe8a3a1/1guscr70s';
			s1.charset = 'UTF-8';
			s1.setAttribute('crossorigin', '*');
			s0.parentNode.insertBefore(s1, s0);
		})();
	</script>
	<!--End of Tawk.to Script-->
	@yield('js')
</body>

</html>
