@extends('front.layouts.master')

@section('title', 'Reset Password')

@section('css')
	<style>
		.input-group-text {
			border-radius: 0rem 0rem 0rem 0rem;
		}

		.passwordfield {
			border-radius: 0rem 0rem 0rem 0rem;
		}

		.password-box~.invalid-feedback {
			display: block;
		}
	</style>
@endsection

@section('content')
	<div class="section section-forgot">
		<section class="pagehead pagehead-shrink bg--lightgray">
			<div class="container text-center">
				<h1>{{ __('Reset Password') }}</h1>
				<p class="text-center text-lt pb-3">Please enter your username or email address. You will reset your
					password.</p>
			</div>
		</section>
		<section class="section section-forgot">
			<div class="container">
				<div class="accountform accountform-forgot">
					<form method="POST" id="form-data" action="{{ route('password.update') }}">
						@csrf
						<div class="row">
							<input type="hidden" name="token" value="{{ $token }}">

							<div class="formgroup">
								<input id="email" type="email" class="inputfield @error('email') is-invalid @enderror" name="email"
									value="{{ $email ?? old('email') }}" autocomplete="email" autofocus readonly placeholder="Email">
								@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>

							<div class="formgroup">
								<div class=" d-flex password-box">
									<input id="password" type="password" class="inputfield passwordfield @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password">

									<div class="input-group-append d-flex">
										<span class="input-group-text">
											<a href="#" class="toggle_hide_password">
												<i class="fas fa-eye-slash" aria-hidden="true"></i>
											</a>
										</span>
									</div>
								</div>
								@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>

							<div class="formgroup">
								<div class=" d-flex password-box">
									<input id="password-confirm" type="password" class="inputfield passwordfield" name="password_confirmation" autocomplete="new-password" placeholder="Confirm Password">
									<div class="input-group-append d-flex">
										<span class="input-group-text">
											<a href="#" class="toggle_hide_password">
												<i class="fas fa-eye-slash" aria-hidden="true"></i>
											</a>
										</span>
									</div>
								</div>
								@error('password_confirmation')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>

							<div class="formgroup">
								<input type="submit" name="submit" class="bttn bttn-primary w-100" value="{{ __('Reset Password') }}" required />
							</div>

						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
@endsection


@section('js')
	<script src="{{ asset('js/recaptcha.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script>
		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[a-z]+$/i.test(value);
		}, "Please add letters only.");

		$("#form-data").validate({
			rules: {
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 8,
				},
				password_confirmation: {
					required: true
				},
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
				if ($(element).hasClass('form-check-input')) {
					$(element).parent().parent().append(error[0]);
				} else if ($(element).hasClass('passwordfield')) {

					$(element).parent().parent('.formgroup').append(error[0]);
				} else {
					$(element).parent().append(error[0]);
				}
			}
		});

		$(document).ready(function() {
			$(document).on('click', '.toggle_hide_password', function(e) {
				e.preventDefault()

				var input_group = $(this).closest('.formgroup')
				var input = input_group.find('input.passwordfield')
				var icon = input_group.find('i')
				input.attr('type', input.attr("type") === "text" ? 'password' : 'text')
				icon.toggleClass('fa-eye-slash fa-eye')
			})
		})
	</script>
@endsection
