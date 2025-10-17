@extends('admin.layouts.master')

@section('title', 'Old Certificates')

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => 'Old Certificates'])

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<table id="certificate_table" class="table ">
								<thead>
									<tr>
										<th>Name</th>
										<th>File</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ($files as $file)
                                        <tr>
                                            <td>{{ str_replace('.pdf', '', $file) }}</td>
                                            <td>
                                                <a href="{{ url('pdfs/old-certificates/' . strtolower(Auth::user()->email) . '/' . $file) }}" target="_blank"><i class="fa fa-file-pdf"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
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
			}]
		});
	</script>
@endsection
