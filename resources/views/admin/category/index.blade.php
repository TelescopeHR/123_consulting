@extends('admin.layouts.master')

@section('title', ucfirst(Str::plural($module)))

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => ucfirst(Str::plural($module))])

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-5 col-sm-12">
					<div class="card">
						<form id="form-data" role="form" method="post"
							action="{{ isset($data) ? route('category.update', ['category' => $data->id]) : route('category.store') }}">
							@csrf
							@if (isset($data))
								<input type="hidden" name="_method" value="put">
							@endif
							<div class="card-header">
								<h3 class="card-title">{{ isset($data) ? 'Update' : 'Add' }}
									{{ ucfirst(Str::singular($module)) }}</h3>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="type">Type</label>
											<select name="type" id="type" class="form-control">
												<option value="">Select Type</option>
												@foreach ($types as $type)
													<option value="{{ $type }}" {{ old('type', @$data->type) == $type ? 'selected' : '' }}>
														{{ $type }}
													</option>
												@endforeach
											</select>
											@error('type')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="name">Name</label>
											<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
												placeholder="Name" value="{{ old('name', @$data->name) }}">
											@error('name')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="slug">Slug</label>
											<input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug"
												placeholder="Slug" value="{{ old('slug', @$data->slug_relation ? @$data->slug_relation->slug : '') }}">
											@error('slug')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">{{ isset($data) ? 'Update' : 'Submit' }}</button>
								<a href="{{ route('category.index') }}" class="btn btn-default">Cancel</a>
							</div>
						</form>
					</div>
				</div>

				<div class="col-md-7 col-sm-12">
					<div class="card">
						<div class="card-body">
							<table id="data-table" class="table ">
								<thead>
									<tr>
										<th>Type</th>
										<th>Name</th>
										<th>Slug</th>
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
@endsection

@section('js')
	<!-- DataTables -->
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('js/jquery-impromptu.js') }}"></script>
	<script>
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
			ajax: "{{ route('category.ajax') }}",
			columns: [{
					data: 'type',
					className: 'all'
				},
				{
					data: 'name'
				},
				{
					data: 'slug_relation.slug'
				},
				{
					data: 'action',
					className: 'all',
					searchable: false,
					orderable: false
				},
			]
		});

		$('body').on('click', '.delete', function() {
			let url = $(this).attr('target-url');
			var token = $('input[name="_token"]').val();
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
				type: {
					required: true
				},
				name: {
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

		function convert_text_to_slug() {
			var token = $('input[name="_token"]').val();
			$.ajax({
				headers: {
					'X-CSRF-Token': token
				},
				type: "POST",
				url: "{{ route('slug.create') }}",
				data: {
					title: $('#name').val()
				},
				global: false,
				success: function(data) {
					$('#slug').val(data.data);
				}
			});
		}

		$('#name').on('keyup', function() {
			convert_text_to_slug()
		});
	</script>
@endsection
