@extends('admin.layouts.master')

@section('title', 'Policy Manuals')

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => 'Policy Manuals'])
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<table id="policy_manuals_table" class="table ">
								<thead>
									<tr>
										<th width="75%">Policy</th>
										<th width="20%">Purchase date</th>
										<th width="5%">Action</th>
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
		const dataTable = $('#policy_manuals_table').DataTable({
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
			}, {
				bSortable: false,
				aTargets: [1]
			}],
			ajax: "{{ route('user.policies') }}",
			columns: [{
					data: 'policy_manual.title',
					className: 'all'
				},{
					data: 'purchase_date',
					className: 'all',
					orderable: true
				},
				{
					data: 'action',
					className: 'all',
					searchable: false,
					orderable: false
				},
			]
		});
	</script>
@endsection
