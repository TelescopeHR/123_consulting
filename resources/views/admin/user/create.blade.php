@extends('admin.layouts.master')

@section('title', ucfirst(Str::singular($module)))

@section('css')
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', [
		'module_title' => Str::singular((isset($data) ? 'Edit ' : 'Add new ') . $module),
	])

	@php
		$old_names = old('name');
		$selected_course = old('course') ? App\Models\Course::whereId(old('course'))->first() : [];
	@endphp

	<section class="content">
		<div class="container-fluid">

			<ul class="nav nav-tabs" id="userTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link {{ old('course') ? '' : 'active' }}" id="profile-tab" data-toggle="tab" href="#profile"
						role="tab" aria-controls="profile" aria-selected="true">User Information</a>
				</li>
				@if (isset($data))
					<li class="nav-item" role="presentation">
						<a class="nav-link {{ old('course') ? 'active' : '' }}" id="course-tab" data-toggle="tab" href="#password"
							role="tab" aria-controls="password" aria-selected="false">Assign Course</a>
					</li>
				@endif
			</ul>
			<div class="tab-content" id="userTabContent">
				<div class="tab-pane fade {{ old('course') ? '' : 'show active' }}" id="profile" role="tabpanel"
					aria-labelledby="profile-tab">
					<div class="card card-primary">
						<form id="user-form" role="form" method="post"
							action="{{ isset($data) ? route('user.update', ['user' => $data->id]) : route('user.store') }}"
							enctype="multipart/form-data">
							@csrf
							@if (isset($data))
								<input type="hidden" name="_method" value="put">
							@endif
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="first_name" class="col-form-label">First Name</label>
											<input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="First Name" value="{{ old('first_name', @$data->first_name) }}">
											@error('first_name')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="last_name" class="col-form-label">Last Name</label>
											<input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name', @$data->last_name) }}">
											@error('last_name')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="email" class="col-form-label">Email</label>
											<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
												placeholder="Email" value="{{ old('email', @$data->email) }}">
											@error('email')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="username" class="col-form-label">Username</label>
											<input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
												name="username" placeholder="Username" value="{{ old('username', @$data->username) }}">
											@error('username')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label for="phone" class="col-form-label">Phone</label>
										<div class="form-group input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1">+1</span>
											</div>
											<input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
												placeholder="Phone" value="{{ old('phone', @$data->phone) }}">
											@error('phone')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="address" class="col-form-label">Address</label>
											<input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
												name="address" placeholder="Address" value="{{ old('address', @$data->address) }}">
											@error('address')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="city" class="col-form-label">City</label>
											<input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
												name="city" placeholder="City" value="{{ old('city', @$data->city) }}">
											@error('city')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="zipcode" class="col-form-label">Zipcode</label>
											<input type="text" class="form-control @error('zipcode') is-invalid @enderror" id="zipcode"
												name="zipcode" placeholder="Zipcode" value="{{ old('zipcode', @$data->zipcode) }}">
											@error('zipcode')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="country_id" class="col-form-label">Country</label>
											<select name="country_id" id="country_id"
												class="form-control select2 @error('country_id') is-invalid @enderror">
												<option selected readonly disabled>Select Country</option>
												@forelse ($countries as $country)
													<option value="{{ $country->id }}"
														{{ old('country_id', @$data->country_id) == $country->id ? ' selected' : null }}>
														{{ $country->name }}</option>
												@empty
												@endforelse
											</select>
											@error('country_id')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="state" class="col-form-label">State</label>
											<select name="state" id="state" class="form-control select2 @error('state') is-invalid @enderror">
												@if (isset($data))
													@forelse ($states as $state)
														<option value="{{ $state->id }}" {{ old('state', @$data->state) == $state->id ? ' selected' : '' }}>
															{{ $state->name }}</option>
													@empty
													@endforelse
												@endif
											</select>
											@error('state')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="agency_name" class="col-form-label">Agency Name</label>
											<input type="text" class="form-control @error('agency_name') is-invalid @enderror" id="agency_name"
												name="agency_name" placeholder="Agency Name"
												value="{{ old('agency_name', @$data->agency_name) }}">
											@error('agency_name')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<p>To better serve you, please check off your license type (check all that apply)</p>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="license_type[]" id="home_care" value="Home Care" @if(@$data->license_type && in_array('Home Care', explode(', ', $data->license_type))) checked @endif>
											<label for="home_care" class="custom-control-label">Home Care</label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="license_type[]" id="home_health" value="Home Health" @if(@$data->license_type && in_array('Home Health', explode(', ', $data->license_type))) checked @endif>
											<label for="home_health" class="custom-control-label">Home Health</label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="license_type[]" id="hospice" value="Hospice" @if(@$data->license_type && in_array('Hospice', explode(', ', $data->license_type))) checked @endif>
											<label for="hospice" class="custom-control-label">Hospice</label>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">{{ isset($data) ? 'Update' : 'Submit' }}</button>
								<a href="{{ route('user.index') }}" class="btn btn-default">Cancel</a>
							</div>
						</form>
					</div>
				</div>

				<div class="tab-pane fade {{ old('course') ? 'show active' : '' }}" id="password" role="tabpanel"
					aria-labelledby="course-tab">
					<div class="card card-primary">
						@if (isset($data))
							<form id="course-form" method="post" action="{{ route('user.assign.course', ['user_id' => $data->id]) }}">
								@csrf
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label for="courses">Course</label>
												<select class="form-control @error('course') is-invalid @enderror" name="course" class="course"
													id="course_id" required>
													<option value="" selected disabled>Select Course</option>
													@if (isset($courses) && count($courses))
														@foreach ($courses as $key => $course)
															<option value="{{ $course->id }}"
																{{ old('course') && old('course') == $course->id ? ' selected' : '' }}>{{ $course->title }}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>
									</div>
									<div class="course-listing course-app">
										@if (!empty($old_names))
											<hr>
											<div class="row">
												<div class="col-3"><label>Price:</label> ${{ $selected_course->price }}</div>
												<div class="col-9">
													<a href="javascript:void(0)" class="btn btn-sm btn-primary float-right" id="add-user"
														data-id="{{ $selected_course->id }}">Add Caregiver</a>
												</div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="row">
														<div class="col-lg-8 col-sm-12">
															<div class="row mt-2">
																<img src="{{ $selected_course->full_image }}" class="img-thumbnail" />
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-8">
													<div class="mt-2">
														<div class="dynamic-name-list">
															@forelse ($old_names as $key_name => $old_name)
																<div class="row mt-2">
																	<div class="col-md-3 pt-1">
																		<input type="text" name="name[{{ $key_name }}][first_name]"
																			class="form-control name_validation @error('name.' . $key_name . '.first_name') is-invalid @enderror"
																			placeholder="First Name" data-title="First Name" value="{{ $old_name['first_name'] }}" />
																		@error('name.' . $key_name . '.first_name')
																			<span class="error invalid-feedback">{{ $message }}</span>
																		@enderror
																	</div>
																	<div class="col-md-3 pt-1">
																		<input type="text" name="name[{{ $key_name }}][last_name]"
																			class="form-control name_validation @error('name.' . $key_name . '.last_name') is-invalid @enderror"
																			placeholder="Last Name" data-title="Last Name" value="{{ $old_name['last_name'] }}" />
																		@error('name.' . $key_name . '.last_name')
																			<span class="error invalid-feedback">{{ $message }}</span>
																		@enderror
																	</div>
																	<div class="col-md-4 pt-1">
																		<input type="email" name="name[{{ $key_name }}][email]"
																			class="form-control name_validation @error('name.' . $key_name . '.email') is-invalid @enderror"
																			placeholder="Email" data-title="Email" value="{{ $old_name['email'] }}" />
																		@error('name.' . $key_name . '.email')
																			<span class="error invalid-feedback">{{ $message }}</span>
																		@enderror
																	</div>
																	<div class="col-md-2 pt-1">
																		<a href="javascript:void(0)" class="btn btn-danger remove-user"><i class="fa fa-minus"></i></a>
																	</div>
																</div>
															@empty
															@endforelse
														</div>
													</div>
												</div>
											</div>
										@endif
									</div>
								</div>
								<div class="card-footer">
									<button type="submit" class="btn btn-primary">Assign Course</button>
								</div>
							</form>
						@endif

					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('js')
	<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script>
		let required = true;
		@if (isset($data))
			required = false;
		@endif

		$("#user-form").validate({
			ignore: [],
			rules: {
				agency_name: {
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
			$('#state').select2({
				placeholder: 'Select state',
				allowClear: true,
				ajax: {
					method: 'POST',
					url: "{{ route('get_state') }}",
					data: function(param) {
						return {
							search: param.term,
							country_id: country_id
						};
					},
					headers: {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
					},
					dataType: 'json',
					processResults: function(data) {
						return {
							results: $.map(data, function(item) {
								return {
									text: item.name,
									id: item.id
								}
							})
						};
					}
				}
			});
		}

		$(document).on("change", "#course_id", function(e) {
			let courseid = $(this).val();
			var token = $('meta[name="csrf-token"]').attr('content');
			var url = "{{ route('assigncourse', ':id') }}";
			url = url.replace(':id', courseid);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': token
				},
				type: "POST",
				method: 'POST',
				url: url,
				success: function(data) {
					$('.course-app').html(data.data);
					loadUserList();
				}
			});
		});

		$(document).on('click', '#add-user', function() {
			loadUserList();
		});

		$(document).on('click', '.remove-user', function() {
			let row = $(`[class*="dynamic-name-list"]`).find('.row').length;
			if (row > 1) {
				$(this).parent().parent('.row').remove();
			}
		});

		function loadUserList() {
			var token = $('meta[name="csrf-token"]').attr('content');
			var url = "{{ route('user.list.page') }}";
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': token
				},
				type: "POST",
				url: url,
				global: false,
				success: function(data) {
					$('.dynamic-name-list').append(data);

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
				}
			});
		}

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
				$($(element).closest('.dynamic-name-list').find('[type=email]')).each(function() {
					if ($(this).val() === value) {
						timeRepeated++;
					}
				});
			}
			return timeRepeated === 1 || timeRepeated === 0;

		}, "Enter unique email.");

		$("#course-form").validate({
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
			},
		});
	</script>
@endsection
