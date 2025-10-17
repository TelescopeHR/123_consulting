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
				<div class="col-md-6 col-sm-12">
					<div class="card">
						<form id="form-data" role="form" method="post"
							action="{{ isset($data) ? route('tag.update', ['tag' => $data->id]) : route('tag.store') }}">
							@csrf
							@if (isset($data))
								<input type="hidden" name="_method" value="put">
							@endif
							<div class="card-header">
								<h3 class="card-title">{{ isset($data) ? 'Update' : 'Add' }} {{ ucfirst(Str::singular($module)) }}</h3>
							</div>
							<div class="card-body">
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
											<label for="code">Description</label>
											<textarea name="description" id="description" class="form-control" placeholder="Description">{{ old('description', @$data->description) }}</textarea>
											@error('description')
												<span class="error invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">{{ isset($data) ? 'Update' : 'Submit' }}</button>
								<a href="{{ route('tag.index') }}" class="btn btn-default">Cancel</a>
							</div>
						</form>
					</div>
				</div>

				<div class="col-md-6 col-sm-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">List all tags</h3>
						</div>
						<div class="card-body">
							<table id="data-table" class="table ">
								<thead>
									<tr>
										<th>Name</th>
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
			ajax: "{{ route('tag.ajax') }}",
			columns: [{
					data: 'name',
					className: 'all'
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
	</script>
@endsection
