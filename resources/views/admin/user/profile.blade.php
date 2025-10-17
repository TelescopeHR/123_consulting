@extends('admin.layouts.master')

@section('title', 'Profile')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/jquery-impromptu.css') }}">
@endsection

@section('content')
	<input type="hidden" name="csrf-token" content="{{ csrf_token() }}">
	@include('admin.layouts.breadcrumb', ['module_title' => 'Profile'])

	<section class="content">
		<div class="container-fluid">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
						aria-selected="true">Profile Information</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password"
						aria-selected="false">Change Password</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="card card-primary">
						<form id="profile-form-data" role="form" method="post" action="{{ route('user.update-profile') }}"
							enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="id" id="id" value="{{ $userprofile->id }}" />
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="first_name">First Name</label>
											<input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
												id="first_name" placeholder="First Name" value="{{ old('first_name', $userprofile->first_name) }}">
											@error('first_name')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="last_name">Last Name</label>
											<input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
												id="last_name" placeholder="Last Name" value="{{ old('last_name', $userprofile->last_name) }}">
											@error('last_name')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="email">Email</label>
											<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
												placeholder="Email" value="{{ old('email', $userprofile->email) }}">
											@error('email')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<label for="phone">Phone</label>
										<div class="form-group input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1">+1</span>
											</div>
											<input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
												placeholder="Phone" value="{{ old('phone', $userprofile->phone) }}">
											@error('phone')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="address">Username</label>
											<input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
												id="username" placeholder="Username" value="{{ old('username', $userprofile->username) }}">
											@error('username')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<label for="address">Address</label>
										<div class="form-group input-group mb-3">
											<input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
												id="address" placeholder="Address" value="{{ old('address', $userprofile->address) }}">
											@error('address')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="city">City</label>
											<input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
												id="city" placeholder="city" value="{{ old('city', $userprofile->city) }}">
											@error('city')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<label for="zipcode">Zip-Code</label>
										<div class="form-group input-group mb-3">
											<input type="text" name="zipcode" class="form-control @error('zipcode') is-invalid @enderror"
												id="zipcode" placeholder="zipcode" value="{{ old('zipcode', $userprofile->zipcode) }}">
											@error('zipcode')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><b>Country</b></label>
											<select class="form-control" id="country_id" name="country_id">
												<option selected>Select Country</option>
												@forelse ($countries as $country)
													<option value="{{ $country->id }}"
														{{ old('country_id', @$userprofile->country_id) == $country->id ? ' selected' : null }}>
														{{ $country->name }}</option>
												@empty
												@endforelse
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<label><b>State</b></label>
										<select name="state" id="state" class="form-control @error('state') is-invalid @enderror">
											@if (isset($userprofile))
												@forelse ($states as $state)
													<option value="{{ $state->id }}" {{ old('state', $userprofile->state) == $state->id ? ' selected' : '' }}>
														{{ $state->name }}</option>
												@empty
												@endforelse
											@endif
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<p>To better serve you, please check off your license type (check all that apply)</p>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="license_type[]" id="home_care" value="Home Care" @if(@$userprofile->license_type && in_array('Home Care', explode(', ', $userprofile->license_type))) checked @endif>
											<label for="home_care" class="custom-control-label">Home Care</label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="license_type[]" id="home_health" value="Home Health" @if(@$userprofile->license_type && in_array('Home Health', explode(', ', $userprofile->license_type))) checked @endif>
											<label for="home_health" class="custom-control-label">Home Health</label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="license_type[]" id="hospice" value="Hospice" @if(@$userprofile->license_type && in_array('Hospice', explode(', ', $userprofile->license_type))) checked @endif>
											<label for="hospice" class="custom-control-label">Hospice</label>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-primary float-right">Update</button>
							</div>
						</form>
					</div>
				</div>
				<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
					<div class="card card-primary">
						<form id="password_form" role="form" method="post" action="{{ route('user.change-password') }}"
							enctype="multipart/form-data">
							@csrf
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="current_password">Current Password</label>
													<input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" placeholder="Current Password" value="">
													@error('current_password')
														<span class="error invalid-feedback">{{ $message }}</span>
													@enderror
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="password">New Password</label>
													<input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
														id="mainpassword" placeholder="Password" value="">
													@error('password')
														<span class="error invalid-feedback">{{ $message }}</span>
													@enderror
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="password_confirmation ">Confirm New Password</label>
													<input type="password" name="password_confirmation"
														class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
														placeholder="Confirm Password" value="">
													@error('password_confirmation')
														<span class="error invalid-feedback">{{ $message }}</span>
													@enderror
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
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

		$("#profile-form-data").validate({
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
					maxlength: 150
				},
				city: {
					maxlength: 150
				},
				zipcode: {
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

		$("#password_form").validate({
			rules: {
				current_password: {
					required: true,
				},
				password: {
					required: true,
					minlength: 8,
				},
				password_confirmation: {
					required: true,
				},
			},
			messages: {},
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
