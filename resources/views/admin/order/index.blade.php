@extends('admin.layouts.master')

@section('title', ucfirst(Str::plural($module)))

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => Str::plural($module)])
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<table id="data-table" class="table">
								<thead>
									<tr>
										<th>Order</th>
										<th>User</th>
										<th>Courses/Policies</th>
										<th>Date</th>
										<th>Status</th>
										<th>Total</th>
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

	{{-- order details modal --}}
	<div class="modal fade order-detail-modal" id="orderDetailModal" tabindex="-1" role="dialog"
		aria-labelledby="orderDetailModal" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content"></div>
		</div>
	</div>
	{{-- order details modal --}}
@endsection

@section('js')
	<!-- DataTables -->
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
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
            serverSide: true,
            processing: true,
			aoColumnDefs: [{
				bSortable: false,
				aTargets: [-1]
			}],
			ajax: "{{ route('order.ajax') }}",
			columns: [{
					data: 'order_id'
				},
				{
					data: 'user.first_name',
                    render: function(data, type, row) {
                        if (row.user) {
                            let user = row.user.first_name + ' ' + row.user.last_name;
                            user += '<br><a href="mailto:' + row.user.email + '">' + row.user.email + '</a>';
                            return user;
                        }
                        return '<b>User Deleted</b>';
                    }
				},
				{
					data: 'courses',
                    orderable: false,
                    searchable: false,
				},
				{
					data: 'created_at'
				},
				{
					data: 'payment_status'
				},
				{
					data: 'total_amount'
				},
				{
					data: 'action',
					className: 'all',
					searchable: false,
					orderable: false
				},
			]
		});

		$(document).on("click", ".show-order", function(event) {
			event.preventDefault();
			let url = $(this).attr('target-url');
			$.ajax({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
				},
				type: "GET",
				url: url,
				dataType: 'json',
				success: function(response) {
					if (response.status) {
						$(".order-detail-modal .modal-content").html(response.data);
						$(".order-detail-modal").modal("show");
					}
				}
			});
		})
	</script>
@endsection
