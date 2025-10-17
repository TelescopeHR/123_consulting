@extends('front.layouts.master')

@section('title', 'Profile')

@section('css')
@endsection

@section('content')
	<!--Inner Page Head-->
	<input type="hidden" name="csrf-token" content="{{ csrf_token() }}">

	<section class="section innerfirst ">
		<div class="container" style="width: 65rem;">
			<div class="card-body">
				<div class="text-center">
					<h1>{{ $userprofile->first_name }} {{ $userprofile->last_name }}</h1>
				</div>
			</div>
			<div class="card-body">
				<form id="user-form" action="{{ route('user.profile.update', $userprofile->id) }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label><b>Agency Name</b></label>
						<input type="text" name="agency_name" id="agency_name" class="form-control "
							value="{{ old('agency_name', $userprofile->agency_name) }}">
						<span class='text-danger'>
							@error('agency_name')
								<br>
								{{ $message }}
							@enderror
						</span>

					</div>
					<div class="form-group">
						<label><b>First Name</b></label>
						<input type="text" name="first_name" id="first_name" class="form-control "
							value="{{ old('first_name', $userprofile->first_name) }}">
						<span class='text-danger'>
							@error('first_name')
								<br>
								{{ $message }}
							@enderror
						</span>
					</div>
					<div class="form-group">
						<label><b>Last Name</b></label>
						<input type="text" name="last_name" id="last_name" class="form-control "
							value="{{ old('last_name', $userprofile->last_name) }}">
						<span class='text-danger'>
							@error('last_name')
								<br>
								{{ $message }}
							@enderror
						</span>
					</div>
					<div class="form-group">
						<label><b>Email-Id</b></label>
						<input type="email" name="email" id="email" class="form-control "
							value="{{ old('email', $userprofile->email) }}">
						<span class='text-danger'>
							@error('email')
								<br>
								{{ $message }}
							@enderror
						</span>
					</div>
					<div class="form-group">
						<label><b>Username</b></label>
						<input type="text" name="username" id="username" class="form-control "
							value="{{ old('username', $userprofile->username) }}">
						<span class='text-danger'>
							@error('username')
								<br>
								{{ $message }}
							@enderror
						</span>
					</div>
					<div class="form-group">
						<label><b>phone</b></label>
						<input type="phone" name="phone" id="phone" class="form-control "
							value="{{ old('phone', $userprofile->phone) }}">
						<span class='text-danger'>
							@error('phone')
								<br>
								{{ $message }}
							@enderror
						</span>
					</div>

					<div class="form-group">
						<label><b>Address</b></label>
						<input type="text" name="address" id="address" class="form-control "
							value="{{ old('address', $userprofile->address) }}">
						<span class='text-danger'>
							@error('address')
								<br>
								{{ $message }}
							@enderror
						</span>
					</div>
					<div class="form-group">
						<label><b>City</b></label>
						<input type="text" name="city" id="city" class="form-control "
							value="{{ old('city', $userprofile->city) }}">
						<span class='text-danger'>
							@error('city')
								<br>
								{{ $message }}
							@enderror
						</span>
					</div>
					<div class="form-group">
						<label><b>Zip-code</b></label>
						<input type="text" name="zipcode" id="zipcode" class="form-control "
							value="{{ old('zipcode', $userprofile->zipcode) }}">
						<span class='text-danger'>
							@error('zipcode')
								<br>
								{{ $message }}
							@enderror
						</span>
					</div>
					<div class="form-group">
						<label><b>Country</b></label>
						<select class="form-control" id="country_id" name="country_id">
							<option selected readonly disabled>Select Country</option>
							@forelse ($countries as $country)
								<option value="{{ $country->id }}"
									{{ old('country_id', @$userprofile->country_id) == $country->id ? ' selected' : null }}>
									{{ $country->name }}</option>
							@empty
							@endforelse
						</select>

					</div>
					<div class="form-group">
						<label><b>State</b></label>
						<select name="state" id="state" class="form-control @error('state') is-invalid @enderror">
							@forelse ($states as $state)
								<option value="{{ $state->id }}" {{ old('state', @$userprofile->state) == $state->id ? ' selected' : '' }}>
									{{ $state->name }}</option>
							@empty
							@endforelse
						</select>
						@error('state')
							<span class="error invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="hero-ctas text-center">
						<button class="btn mr-3 form-control col-md-4" type="submit">SUBMIT</button>
					</div>
				</form>
			</div>
		</div>
	</section>
	<!--Inner Page Head ENDS-->
@endsection

@section('js')
	{{-- select2 --}}
	<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>

	<script>
		let required = true;
		@if (isset($data))
			required = false;
		@endif

        $.validator.addMethod("phoneRegex", function(value, element) {
            return /^[\+\(\s\-\d\)]{5,30}$/.test(value);
        }, "Enter valid phone number.");

		$("#user-form").validate({
			ignore: [],
			rules: {
				agency_name: {
					required: true,
					maxlength: 150
				},
				first_name: {
					required: true,
					maxlength: 150
				},
				last_name: {
					required: true,
					maxlength: 150
				},
				email: {
					required: true,
					email: true
				},
				address: {
					required: true,
					maxlength: 150
				},
				city: {
					required: true,
					maxlength: 150
				},
				zipcode: {
					required: true,
					maxlength: 7,
					minlength: 5,
					number: true
				},
				phone: {
					required: true,
                    minlength: 10,
                    phoneRegex: true,
				},
				state: {
					required: true
				},
				country_id: {
					required: true
				},
				username: {
					required: required,
					maxlength: 150,
				},
			},
			messages: {
				zipcode: {
					number: 'Enter valid zipcode.'
				},
			},
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
				$(element).parent('.form-group').append(error[0]);
			}
		});



		$(document).on("change", "#country_id", function(e) {
			let countryId = $(this).val();
			init_state_select2(countryId);
		});

		function init_state_select2(country_id = 1) {

			$.ajax({
				method: 'POST',
				url: "{{ route('get_state') }}",
				headers: {
					"X-CSRF-TOKEN": $('input[name="csrf-token"]').attr('content')
				},
				data: {
					country_id: country_id
				},
				success: function(data) {
					$("#state").html('');
					$.each(data, function(key, value) {
						$("#state").append('<option value=' + value.id + '>' + value.name + '</option>');
					});

				}

			});
		}
	</script>

@endsection
