@extends('front.layouts.master')

@section('title', 'Contact 123 Consulting Solution Home Health Care and Hospice')

@section('css')
@endsection

@section('content')
	<!--Inner Page Head-->
	<section class="pagehead pagehead-shrink bg--lightgray">
		<div class="container text-center">
			<h1>Contact US</h1>
		</div>
	</section>

	<section class="section section-signup">
		<div class="container">

			<div class="accountform accountform-signup">
				<form id="form-data" method="post" action="{{ route('front.storeContact') }}">
					@csrf
					<div class="row">
						<div class="formgroup">
							<input type="text" class="inputfield @error('name') is-invalid @enderror" placeholder="Your Name:"
								id="name" name="name" value="{{ old('name') }}" />
							@error('name')
								<span class="error invalid-feedback">{{ $message }}</span>
							@enderror
						</div>

						<div class="formgroup">
							<input type="email" class="inputfield @error('email') is-invalid @enderror" placeholder="Your email:"
								id="email" name="email" value="{{ old('email') }}" />
							@error('email')
								<span class="error invalid-feedback">{{ $message }}</span>
							@enderror
						</div>

						<div class="formgroup">
							<input type="tel" class="inputfield @error('phone') is-invalid @enderror" placeholder="Your phone number:"
								id="phone" name="phone" value="{{ old('phone') }}" />
							@error('phone')
								<span class="error invalid-feedback">{{ $message }}</span>
							@enderror
						</div>

						<div class="formgroup">
							<textarea name="message" class="inputfield @error('message') is-invalid @enderror" placeholder="Your message:"
							 id="message">{{ old('message') }}</textarea>
							@error('message')
								<span class="error invalid-feedback">{{ $message }}</span>
							@enderror
						</div>

						<div class="formgroup">
							<div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror"
								data-sitekey="{{ get_setting_value('g_recaptcha_key') }}"></div>
							@error('g-recaptcha-response')
								<span class="error invalid-feedback">{{ $message }}</span>
							@enderror
						</div>

						<div class="formgroup">
							<input class="bttn bttn-primary w-100" type="submit" name="submit" value="Send Message" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
	<!--Inner Page Head ENDS-->
@endsection

@section('js')
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script>
        $.validator.addMethod("phoneRegex", function(value, element) {
            return /^[\+\(\s\-\d\)]{5,30}$/.test(value);
        }, "Enter valid phone number.");

		$("#form-data").validate({
			rules: {
				name: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				phone: {
					required: true,
                    minlength: 10,
                    phoneRegex: true,
				},
				message: {
					required: true
				}
			},
			errorElement: 'span',
			errorClass: 'invalid-feedback',
			highlight: function(element, errorClass, validClass) {
				$(element).addClass('is-invalid');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).removeClass('is-invalid');
			}
		});
	</script>
@endsection
