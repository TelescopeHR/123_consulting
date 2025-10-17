@extends('admin.layouts.master')

@section('title', 'CMS Pages')

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => 'CMS Pages'])

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-header">
							<div class="card-tools">
								<a href="{{ route('cms-page.create') }}" class="btn btn-primary">Add New</a>
							</div>
						</div>
						<div class="card-body">
							<table id="cms_page_table" class="table ">
								<thead>
									<tr>
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
	<script src="{{ asset('js/jquery-impromptu.js') }}"></script>
	<script>
		if ($('#cms_page_table').length) {
			var cms_page_table = $('#cms_page_table').DataTable({
				info: false,
				processing: true,
				serverSide: true,
				searching: true,
				lengthChange: false,
				responsive: window.screen.width < 1024,
				ajax: {
					url: "{{ route('cms-page.ajax') }}",
					headers: {
						"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
					},
					dataType: 'json',
				},
				columns: [{
						data: 'name',
						name: 'name',
					},
					{
						data: 'slug',
						name: 'slug'
					},
					{
						data: 'action',
						name: 'action',
						className: 'all',
						orderable: false,
						searchable: false
					},
				],
				drawCallback: function(settings) {}
			});
		}

		$('body').on('click', '.delete', function() {
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
	</script>
@endsection
