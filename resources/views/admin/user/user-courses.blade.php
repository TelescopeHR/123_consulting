@extends('admin.layouts.master')

@section('title', 'User Courses')

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/jquery-impromptu.css') }}">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => 'User Courses'])

	<section class="content">
		<div class="container-fluid">
			<div class="row mt-3">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<table id="data-table" class="table ">
								<thead>
									<tr>
										<th>User Name</th>
										<th>Course Name</th>
                                        <th>Certificate Name</th>
										<th>Purchased At</th>
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
@endsection

@section('js')
	<!-- DataTables -->
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
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
			serverSide: true,
			ajax: "{{ route('user-courses.index') }}",
			columns: [
                { data: 'user', name: 'users.first_name' },
                { data: 'course', name: 'courses.title' },
                { data: 'certificate_name' },
                { data: 'purchase_date', name: 'user_courses.purchase_date' },
                {
                    data: 'is_completed',
                    name: 'user_courses.is_completed',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'action',
                    className: 'all',
                    searchable: false,
                    orderable: false
                }
            ]
		});


		$('body').on('click', '#data-table .delete', function() {
			var url = $(this).data("url");
			var token = $('input[name="_token"]').val();

			$.prompt("This action cannot be undone, Are you sure want to delete this record?", {
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
								dataTable.ajax.reload(null, false);
                                toastr.success('Course deleted for user successfully');
							}
						});
					}
					$.prompt.close();
				}
			});
		});
	</script>
@endsection
