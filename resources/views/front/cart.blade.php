@extends('front.layouts.master')

@section('title', 'Cart - 123 Consulting Solutions')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/jquery-impromptu.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/jquery/jquery-ui.css') }}">
	<style>
		.tooltip-inner {
			width: 250px;
			padding: 15px;
			background-color: #fff;
			border: 5px solid rgba(0, 0, 0, .5);
			color: #333;
			font-family: Helvetica, Arial;
			font-size: 16px;
			-webkit-box-sizing: content-box;
			-moz-box-sizing: content-box;
			box-sizing: content-box;
			-moz-background-clip: padding;
			-webkit-background-clip: padding;
			background-clip: padding-box;
			text-align: left;
			border-radius: 5px;
		}
	</style>
@endsection

@section('content')
	@php
		$cart_amount = cart_total_calculation();
		$sub_total = $cart_amount['sub_total'];
		$total = $cart_amount['total'];
		$discount = $cart_amount['discount'];
		$tax = $cart_amount['tax'];
		$applied_coupon = session()->has('applied_coupon') ? session()->get('applied_coupon') : null;
	@endphp

	<!-- Section Head -->
	<section class="pagehead pagehead-shrink bg--lightgray mt-5 card-page-heading">
		<div class="container text-center">
			<h1>Cart</h1>
		</div>
	</section>

	<section class="section section-cart cart-page">
		<div class="container container-15">
			<h2>Cart Items ({{ count($cartData) }})</h2>

			<div class="cartwrapper">
				<form method="post" action="{{ route('cart.update') }}" id="checkout_form">
					@csrf
					<div class="carttab">
						@forelse ($cartData as $cart)
							@if (isset($cart['course']))
								<div class="carttab-r">
									<div class="carttab-c prodimg">
										<img src="{{ $cart['course']->full_image }}" alt="Product Image" width="1280" height="853" />
									</div>
									<div class="carttab-c prodinfo">
										<div class="prodinfo-head">
											<h3>
												{{ $cart['course']->title }}
												<a href="{{ route('cart.remove', $cart['id']) }}"><i class="icon-x"></i></a>
											</h3>
										</div>
                                        <p class="text-danger ">Enter certificate name</p>
										@php
											$names = isset($cart['certificate_details']) ? json_decode($cart['certificate_details'], true)['names'] : null;
											$course_categories = $cart['course']->categories->pluck('id')->toArray();
										@endphp

										@if (!in_array(1, $course_categories))
											<div class="prodinfo-cartusers append-div-{{ $cart['id'] }}">
												<small class="pt-2 text-danger email-alert-text mb-2" style="display: none">Only enter an email if you'd like the recipient of this course (the certificate name) to create their own profile to view their course. If the recipient will log in to this account to complete their course, leave the email blank.</small>
												@for ($i = 0; $i < $cart['quantity']; $i++)
													@php
														$first_name = $names ? (isset($names[$i]['first_name']) ? $names[$i]['first_name'] : null) : '';
														$last_name = $names ? (isset($names[$i]['last_name']) ? $names[$i]['last_name'] : null) : '';
														$email = $names ? (isset($names[$i]['email']) ? $names[$i]['email'] : null) : '';
													@endphp
													<div class="cartusers-item name_div_{{ $cart['id'] }}_{{ $i }}">
														<div class="cartusercell cartuser-fname">
															<input type="text"
																class="name_validation @error('course.' . $cart['id'] . '.' . $i . '.first_name') is-invalid @enderror"
																name="course[{{ $cart['id'] }}][{{ $i }}][first_name]"
																id="first_name_{{ $cart['id'] . '_' . $i }}" placeholder="First Name"
																value="{{ old('course.' . $cart['id'] . '.' . $i . '.first_name', $first_name) }}"
																data-title="First name" />
															@error('course.' . $cart['id'] . '.' . $i . '.first_name')
																<span class="error invalid-feedback">{{ $message }}</span>
															@enderror
														</div>
														<div class="cartusercell cartuser-lname">
															<input type="text"
																class="name_validation @error('course.' . $cart['id'] . '.' . $i . '.last_name') is-invalid @enderror"
																name="course[{{ $cart['id'] }}][{{ $i }}][last_name]"
																id="last_name_{{ $cart['id'] . '_' . $i }}" placeholder="Last Name"
																value="{{ old('course.' . $cart['id'] . '.' . $i . '.last_name', $last_name) }}"
																data-title="Last name" />
															@error('course.' . $cart['id'] . '.' . $i . '.last_name')
																<span class="error invalid-feedback">{{ $message }}</span>
															@enderror
														</div>
														<div class="cartusercell cartuser-email">
															<input type="email"
																class="name_validation cart_email @error('course.' . $cart['id'] . '.' . $i . '.email') is-invalid @enderror"
																name="course[{{ $cart['id'] }}][{{ $i }}][email]" id="email_{{ $cart['id'] . '_' . $i }}"
																placeholder="Email (Optional)" value="{{ old('course.' . $cart['id'] . '.' . $i . '.email', $email) }}"
																data-title="Email" />
															@error('course.' . $cart['id'] . '.' . $i . '.email')
																<span class="error invalid-feedback">{{ $message }}</span>
															@enderror
														</div>
														<div class="cartusercell cartuser-remove">
															<a href="javascript:void(0)"
																class="bttn-removecartuser text-{{ $cart['quantity'] == 1 ? 'secondary' : 'primary quantity-minus' }}"
																data-id="{{ $cart['id'] }}" data-item="{{ $i }}"><i class="icon-x"></i></a>
														</div>
													</div>
												@endfor
											</div>
											<a href="javascript:void(0)" class="bttn-addmoreusers quantity-plus" data-id="{{ $cart['id'] }}">
												+ Add User
											</a>
										@endif
									</div>
									<div class="carttab-c prodcalc">
										<div class="prodsumm-item">
											<div class="prodsumm-label">Price</div>
											<div class="prodsumm-value">${{ $cart['course']->price }}</div>
										</div>
										<div class="prodsumm-item">
											<div class="prodsumm-label">Qty</div>
											<div class="prodsumm-value">{{ $cart['quantity'] }}</div>
										</div>
										<div class="prodsumm-item">
											<div class="prodsumm-label">Total</div>
											<div class="prodsumm-value">${{ $cart['course']->price * $cart['quantity'] }}</div>
										</div>
									</div>
								</div>
							@elseif (isset($cart['policy_manual']))
								<div class="carttab-r">
									<div class="carttab-c prodimg">
										<img src="{{ asset('images/default.jpg') }}" alt="Policy Manual Image" width="1280" height="853" />
									</div>
									<div class="carttab-c prodinfo">
										<div class="prodinfo-head @error('policy.' . $cart['id']) is-invalid @enderror">
											<h3>
												{{ $cart['policy_manual']->title }}
												<a href="{{ route('cart.remove', $cart['id']) }}"><i class="icon-x"></i></a>
											</h3>
										</div>
										@error('policy.' . $cart['id'])
											<span class="error invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
									<div class="carttab-c prodcalc">
										<div class="prodsumm-item">
											<div class="prodsumm-label">Price</div>
											<div class="prodsumm-value">${{ $cart['policy_manual']->price }}</div>
										</div>
										<div class="prodsumm-item">
											<div class="prodsumm-label">Qty</div>
											<div class="prodsumm-value">{{ $cart['quantity'] }}</div>
										</div>
										<div class="prodsumm-item">
											<div class="prodsumm-label">Total</div>
											<div class="prodsumm-value">${{ $cart['policy_manual']->price * $cart['quantity'] }}</div>
										</div>
									</div>
								</div>
							@endif
						@empty
							<div class="row">
								<div class="col-12 text-center" style="font-weight: 600;">
									Cart is Empty.
								</div>
							</div>
						@endforelse
					</div>

					@if (!empty($cartData))
						<div class="cart-summary">
							<h5>Set Your Agency Up for Success - Next Steps:</h5>
                            <p>After you complete your admin training, your next step is building a fully operational agency.</p>
                            <ul class="mb-3">
                                <li class="text-muted">Download your policies</li>
                                <li class="text-muted">Set up your client care management system</li>
                                <li class="text-muted">Automate caregiver hiring & onboarding</li>
                            </ul>
                            <span class="text-muted">Check the box below to receive free info, pricing, and a walkthrough.</span>
                            <span class="text-muted">(No spam - just tools that save you time & stress)</span>
							@php
								$helps = [
									'Check this box to receive'
								];
							@endphp
							@foreach ($helps as $help)
								<div class="form-check mt-2">
									<input class="form-check-input" type="checkbox" name="help[]" value="{{ $help }}" id="{{ $help }}" @if (isset($session_cart_help) && in_array($help, $session_cart_help)) checked @endif>
									<label class="form-check-label" for="{{ $help }}" style="font-weight: 500;line-height: 24px;">
										{{ $help }}
									</label>
								</div>
							@endforeach
                            
						</div>
						<div class="cart-summary">
							<h3>Cart Summary</h3>
							<div class="cartsum-item">
								<div class="cartsum-lbl">Subtotal</div>
								<div class="cartsum-val">${{ number_format($sub_total, 2) }}</div>
							</div>
							<div class="cartsum-item">
								<div class="cartsum-lbl">Tax</div>
								<div class="cartsum-val">${{ number_format($tax, 2) }}</div>
							</div>
							<div class="cartsum-item cartsum-coupon">
								<div class="cartsum-lbl">Coupon Code</div>
								<div class="cartsum-val">
									<a href="#apply-coupon" title="Apply Coupon Code?" class="toggleCollapse">Apply Coupon Code?</a>
								</div>
							</div>
							<div class="cartsum-item couponcode" id="apply-coupon">
								<div class="couponcode-wrapper">
									<input type="text" class="input-field couponcode-inp" name="coupon_code"
										placeholder="Type Coupon Code Here"
										value="{{ $applied_coupon && isset($applied_coupon->code) ? $applied_coupon->code : '' }}" />
									<a href="javascript:void(0)" class="couponcode-btn bttn bttn-primary apply_coupon bttn-sm">Apply</a>
								</div>
							</div>
							@if (!empty($applied_coupon))
								<div class="cartsum-item">
									<div class="cartsum-lbl">
										Coupon Applied
										<a href="javascript:void(0)" class="text-danger remove_coupon" title="Remove Coupon">X</a>
									</div>
									<div class="cartsum-val">- ${{ number_format($discount, 2) }}</div>
								</div>
							@endif
							<div class="cartsum-item cartsum-item--total">
								<div class="cartsum-lbl">Total</div>
								<div class="cartsum-val">${{ number_format($total, 2) }}</div>
							</div>
							<div class="cart-checkout">
								@if ($download_url)
									<a href="{{ $download_url }}" class="bttn bttn-primary button-primary justify-content-center text-center" target="_blank" download>Download</a>
								@else
									<button type="submit" class="bttn bttn-primary button-primary justify-content-center">Checkout</button>
								@endif
							</div>
						</div>
					@endif
				</form>
			</div>
		</div>
	</section>
@endsection

@section('js')
	<script src="{{ asset('js/jquery-impromptu.js') }}"></script>
	<script src="{{ asset('plugins/jquery/jquery-ui.js') }}"></script>
	<script type="text/javascript">
		function update_cart(id, is_increment) {
			var token = $('input[name="_token"]').val();
			var url = "{{ route('cart.quantity', ':id') }}";
			url = url.replace(':id', id);

			var formData = new FormData($("#checkout_form")[0]);

			$.ajax({
				headers: {
					'X-CSRF-Token': token
				},
				type: "POST",
				url: url,
				dataType: 'json',
				processData: false,
				contentType: false,
				data: formData,
				success: function(data) {
					location.reload();
				}
			});
		}

		// $('.quantity-plus').change(function() {
		// 	let id = $(this).data('id');
		// 	update_cart(id, true);
		// });

		$('.quantity-minus').click(function() {
			let id = $(this).data('id');
			let item = $(this).data('item');
			$(`.name_div_${id}_${item}`).remove();
			update_cart(id, false);
		});

		$('.quantity-plus').click(function() {
			let id = $(this).data('id');
			let count = $(`[class*="name_div_${id}_"]`).length;
			let html = `<div class="cartusers-item name_div_${id}_${count+1}">
				<div class="cartusercell cartuser-fname">
					<input type="text" class="name_validation" name="course[${id}][${count+1}][first_name]" placeholder="First Name" id="first_name_${id}_${count+1}" data-title="First name" spellcheck="false" data-ms-editor="true">
				</div>
				<div class="cartusercell cartuser-lname">
					<input type="text" class="name_validation" name="course[${id}][${count+1}][last_name]" placeholder="Last Name" id="last_name_${id}_${count+1}" data-title="Last name" spellcheck="false" data-ms-editor="true">
				</div>
				<div class="cartusercell cartuser-email">
					<input type="email" class="name_validation cart_email" name="course[${id}][${count+1}][email]" placeholder="Email (optional)" id="email_${id}_${count+1}" data-title="Email">
				</div>
				<div class="cartusercell cartuser-remove">
					<a href="javascript:void(0)" class="bttn-removecartuser quantity-minus" data-id="${id}" data-item="${count+1}"><i class="icon-x"></i></a>
				</div>
			</div>`;
			$(`.append-div-${id}`).append(html);
			update_cart(id, true);
		});

		$(document).on("click", "a.apply_coupon", function(e) {
			e.preventDefault();
			let coupon_code = $("[name='coupon_code']").val();
			let formData = new FormData($("#checkout_form")[0]);

			if (coupon_code.length) {
				$.ajax({
					headers: {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
					},
					type: "POST",
					url: "{{ route('apply_coupon') }}",
					dataType: 'json',
					processData: false,
					contentType: false,
					data: formData,
					success: function(response) {
						if (response.success) {
							toastr.success(response.message);
							setTimeout(() => {
								location.reload();
							}, 1000);
						} else {
							toastr.error(response.message);
						}
					}
				});
			} else {
				toastr.error("Please enter coupon code.");
			}
		});

		$(document).on("click", "a.remove_coupon", function(e) {
			e.preventDefault();

			$.prompt("Are you sure want to remove this coupon?", {
				title: "Are you sure?",
				buttons: {
					"No": false,
					"Yes": true
				},
				focus: 1,
				submit: function(e, v, m, f) {
					if (v) {
						e.preventDefault();
						$.ajax({
							headers: {
								"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
							},
							type: "POST",
							url: "{{ route('remove_coupon') }}",
							dataType: 'json',
							success: function(response) {
								if (response.success) {
									toastr.success(response.message);
									setTimeout(() => {
										location.reload();
									}, 1000);
								} else {
									toastr.error(response.message);
								}
							}
						});
					}
					$.prompt.close();
				}
			});
		});

		$(document).ready(function() {
			$.validator.addMethod("emailExists", function(value, element) {
				var email = $(element).val();
				var ret_val = true;
				var token = $('input[name="_token"]').val();
				$.ajax({
					headers: {
						'X-CSRF-Token': token
					},
					url: "{{ route('email_exists') }}",
					type: 'POST',
					data: {
						email: email
					},
					async: false,
					success: function(response) {
						if (response.status == true) {
							ret_val = false;
						}
					}
				});

				return ret_val;

			}, "This Email has already been taken.");

			$.validator.addMethod("unique", function(value, element) {
				let timeRepeated = 0;
				if (value != '') {
					$($(element).closest('.prodinfo-cartusers').find('[type=email]')).each(function() {
						if ($(this).val() === value) {
							timeRepeated++;
						}
					});
				}
				return timeRepeated === 1 || timeRepeated === 0;

			}, "Enter unique email.");


			$("#checkout_form").validate({
				ignore: [],
				errorElement: 'span',
				errorClass: 'invalid-feedback',
				highlight: function(element, errorClass, validClass) {
					if ($(element).hasClass('select2')) {
						$(element).next('.select2-container').addClass('is-invalid');
					} else {
						$(element).addClass('is-invalid');
					}
				},
				unhighlight: function(element, errorClass, validClass) {
					if ($(element).hasClass('select2')) {
						$(element).next('.select2-container').removeClass('is-invalid');
					} else {
						$(element).removeClass('is-invalid');
					}
				},
				errorPlacement: function(error, element) {
					$(error[0]).insertAfter(element);
				}
			});

			$.each($("input.name_validation"), function(indexOfElement, formElement) {
				let field_title = $(formElement).data('title');
				if ($(formElement).attr('type') != 'email') {
					$(formElement).rules("add", {
						required: true,
						messages: {
							required: field_title + ' is required.'
						}
					});
				}
				if ($(formElement).attr('type') == 'email') {
					$(formElement).rules("add", {
						email: true,
						unique: true,
					});
				}
			});
		});

		$('[data-toggle="tooltip"]').tooltip();

		showEmailText()
		function showEmailText() {
			$.each($(".prodinfo-cartusers"), function(indexOfElement, formElement) {
				let show = false;
				$($(formElement).find('[type=email]')).each(function() {
					let email = $(this).val();
					if (email) {
						show = true
					}
				})
				if (show) {
					$(formElement).find('.email-alert-text').show()
				} else {
					$(formElement).find('.email-alert-text').hide()
				}
			})
		}

		$(document).on("keyup", ".cart_email", function() {
			showEmailText()
		})
	</script>
@endsection
