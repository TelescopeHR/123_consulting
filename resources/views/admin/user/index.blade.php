@extends('admin.layouts.master')

@section('title', ucfirst(Str::plural($module)))

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
	<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => Str::plural($module)])

	<section class="content">
		<div class="container-fluid">
			<div class="row mt-3">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-header">
							<div class="card-tools w-100">
								<div class="row">
									<div class="col-md-9">
										<div class="form-group float-left mb-0">
											<select id="export_type" class="form-control" name="export_type">
												<option value="" selected disabled>Select an option</option>
												<option value="all_users">All Agencies</option>
												<option value="inactive_customers_current_year">Inactive customers current year</option>
												<option value="active_customers_current_year">Active customers current year</option>
												<option value="new_customers_current_month">New customers current month</option>
												<option value="customers_who_did_not_take_any_courses_this_year">Customers who did not take any courses this
													year</option>
												<option value="Home Care">Home Care</option>
												<option value="Home Health">Home Health</option>
												<option value="Hospice">Hospice</option>
											</select>
										</div>
										<button type="button" class="btn btn-secondary ml-2 btn-export-users">Export</button>
									</div>
									<div class="col-md-3">
										<a href="{{ route('user.create') }}" class="btn btn-primary float-right">Add New</a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<table id="data-table" class="table ">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Username</th>
										<th>Registered At</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	{{--  reset password modal start  --}}
	<div class="modal fade reset-password-modal-lg" id="resetPasswordModal" tabindex="-1" role="dialog"
		aria-labelledby="resetPasswordLabelModal" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="resetPasswordLabelModal">Reset Password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="card-body">
					<div class="row justify-content-center">
						<div class="col-md-10">
							<form method="POST" action="{{ route('user.reset-password') }}">
								@csrf
								<input type="hidden" name="token" value="{{ csrf_token() }}">
								<input type="hidden" name="user_id" id="user_id_reset_pw" value="0">

								<div class="input-group mb-3">
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
										name="password" required autocomplete="new-password" placeholder="Password">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-lock"></span>
										</div>
									</div>
									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="input-group mb-3">
									<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
										autocomplete="new-password" placeholder="Confirm Password">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-lock"></span>
										</div>
									</div>
									@error('password_confirmation')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="form-group row mb-0">
									<div class="col-md-6 offset-md-4">
										<button type="submit" class="btn btn-primary">
											Reset Password
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{--  reset password modal start  --}}

	<div class="modal fade reset-password-modal-lg" id="caregivermodel" tabindex="-1" role="dialog"
		aria-labelledby="resetPasswordLabelModal" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="col-md-12 col-sm-12">
					<div class="modal-header">
						<h5 class="modal-title" id="cargivermodel">Caregiver</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="modal-body">
						<div class="container-fluid">
							<table id="caregiver-table" class="table">
								<thead>
									<tr>
										<th>FirstName</th>
										<th>Lastname</th>
										<th>Email</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('js')
	<!-- DataTables -->
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
	<script src="{{ asset('js/jquery-impromptu.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
	<script>
		let columns = [{
				data: 'name'
			},
			{
				data: 'email'
			},
			{
				data: 'username'
			},
			{
				data: 'registered_at',
				name: 'registered_at',

			},
			{
				data: 'status',
				name: 'status',
				searchable: false,
				orderable: false

			},
			{
				data: 'action',
				className: 'all',
				searchable: false,
				orderable: false
			},
		];
		const dataTable = $('#data-table').DataTable({
			lengthChange: false,
			language: {
				search: '',
				searchPlaceholder: "Search..."
			},
			responsive: window.screen.width < 1024,
			aaSorting: [],
			aoColumnDefs: [{
				bSortable: false,
				aTargets: [-1]
			}],
			serverSide: true,
			ajax: "{{ route('user.ajax') }}",
			columns: columns

		});


		$("#status").on("change", function() {
			dataTable.ajax.url("{{ route('user.ajax') }}?status=" + $(this).val()).load();
		});

		$('body').on('click', '#data-table .delete', function() {
			var id = $(this).data("id");
			var token = $('input[name="_token"]').val();
			let url = $(this).attr('target-url');
			$.prompt("Are you sure want to delete this record?", {
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
								'X-CSRF-Token': token
							},
							type: "DELETE",
							url: url,
							success: function(data) {
								if (data.status) {
									location.reload();
								}
							}
						});
					}
					$.prompt.close();
				}
			});
		});

		$('body').on('click', '#caregiver-table .delete', function() {
			$('#caregivermodel').modal('hide');
			var id = $(this).data("id");
			var token = $('input[name="_token"]').val();
			let url = $(this).attr('target-url');
			$.prompt("Are you sure want to delete this record?", {
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
								'X-CSRF-Token': token
							},
							type: "DELETE",
							url: url,
							success: function(data) {
								if (data.status) {
									location.reload();
								}
							}
						});
					}
					$.prompt.close();
				}
			});
		});

		$("#form-data").validate({
			rules: {
				first_name: {
					required: true,
					maxlength: 200
				},
				last_name: {
					required: true,
					maxlength: 200
				},
				username: {
					required: true,
					maxlength: 200
				},
				email: {
					required: true,
					email: true,
					maxlength: 200
				},
				phone: {
					required: true,
					maxlength: 15
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

		$('body').on('click', '.reset_password', function() {
			$('#resetPasswordModal').modal('show');
			var id = $(this).data('id');
			localStorage.setItem('user', id);
			$('#user_id_reset_pw').val(id);
		});

		const caregiverDatatables = $('#caregiver-table').DataTable({
			lengthChange: false,
			language: {
				search: '',
				searchPlaceholder: "Search..."
			},
			responsive: window.screen.width < 1024,
			aaSorting: [],
			aoColumnDefs: [{
				bSortable: false,
				aTargets: [-1]
			}],
			columns: [{
					data: 'first_name'
				},
				{
					data: 'last_name'
				},
				{
					data: 'email',
				},
				{
					data: 'action',
					className: 'all',
				}
			]
		});

		$('body').on('click', '.caregiver', function() {
			$('#caregivermodel').modal('show');
			let url = "{{ route('caregivers.ajax', [':id']) }}";
			url = url.replace(':id', $(this).data('id'));
			caregiverDatatables.ajax.url(url).load();
		});

		$('body').on('click', '.activeInactive', function() {
			var id = $(this).data("user-id");
			let url = $(this).attr("target-url");
			let element = $(this);
			let checked = ($(this).is(':checked')) ? 1 : 0;
			$.prompt("Are you sure want to change the approve status?", {
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
							type: "get",
							url: url,
							success: function(data) {
								location.reload();
							}
						});
					} else {
						element.prop('checked', !checked);
					}
					$.prompt.close();
				}
			});
		});

		$(document).on("click", "button.btn-export-users", function(event) {
			event.preventDefault();
			let url = "{{ route('users.export') }}";
			let exportType = $('#export_type').val();

			if (exportType) {
				$.ajax({
					headers: {
						'X-CSRF-Token': $('input[name="_token"]').val()
					},
					type: 'POST',
					url: url,
					data: {
						'export_type': exportType,
					},
					dataType: 'JSON',
					success: function(response) {
						if (response.status) {
							let anchor = document.createElement('a');
							anchor.href = "{{ asset('/excel') }}/" + response.file_name;
							anchor.setAttribute('target', '_blank');
							anchor.click();
						} else {
							toastr.error(response.message);
						}
						$('#export_type').val('').change();
					}
				});
			} else {
				toastr.error("Select an option to export users.");
			}
		});
	</script>
@endsection
