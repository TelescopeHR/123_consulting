@extends('admin.layouts.master')

@section('title', 'Certificates')

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">

	<style>
		.tooltip-inner {
			width: 250px;
			padding: 15px;
			background-color: #fff;
			border: 5px solid rgba(0, 0, 0, .5);
			color: #333;
			font-family: Helvetica, Arial;
			font-size: 16px;
			-webkit-box-sizing: content-box;
			-moz-box-sizing: content-box;
			box-sizing: content-box;
			-moz-background-clip: padding;
			-webkit-background-clip: padding;
			background-clip: padding-box;
			text-align: left;
			border-radius: 5px;
		}
	</style>
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => 'Certificates'])

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<table id="certificate_table" class="table ">
								<thead>
									<tr>
										<th width="20%">Course</th>
										<th width="20%">Recipient Name</th>
										<th width="5%">Score</th>
										<th id="actionCol" width="5%">
											Action&nbsp;
											<i data-toggle="tooltip" data-html="true" data-placement="top"
												title="Click on the PDF image under Action to download your certificate."
												class="fa fa-info-circle"aria-hidden="true"></i>
										</th>
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
		const dataTable = $('#certificate_table').DataTable({
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
			ajax: "{{ route('user.certificates') }}",
			columns: [{
					data: 'course.title',
				}, {
					data: 'caregiver',
					orderable: true
				}, {
					data: 'passing_score',
				},
				{
					data: 'action',
					className: 'all',
					searchable: false,
					orderable: false
				},
			],
		});

		$('[data-toggle="tooltip"]').tooltip();
	</script>
@endsection
