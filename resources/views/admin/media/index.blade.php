@extends('admin.layouts.master')

@php
	$module = 'Media';
@endphp

@section('title', ucfirst(Str::plural($module)))

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/jquery-impromptu.css') }}">
	<link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => ucfirst(Str::plural($module))])

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<form action="{{ route('media.store') }}" class='dropzone'>
					</form>
				</div>
			</div>
		</div>
	</section>

	<section class="content mt-5">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<table id="data-table" class="table ">
								<thead>
									<tr>
										<th>File</th>
										<th>Image</th>
										<th>Short Code</th>
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
	<script src="{{ asset('js/dropzone.min.js') }}"></script>

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
			ajax: "{{ route('media.ajax') }}",
			columns: [{
					data: 'file'
				},
				{
					data: 'image_div'
				},
				{
					data: 'short_code'
				},
				{
					data: 'action',
					className: 'all',
					searchable: false,
					orderable: false
				},
			]
		});

		Dropzone.autoDiscover = false;
		var mediaDropzone = new Dropzone(".dropzone", {
			dictDefaultMessage: "Drop file here to upload <br> Max size 100 MB",
			maxFiles: 1,
			maxFilesize: 100, // 100 mb
		});
		mediaDropzone.on("sending", function(file, xhr, formData) {
			formData.append("_token", $('input[name="_token"]').val());
		});
		mediaDropzone.on("success", function() {
			dataTable.ajax.reload();
		});
		mediaDropzone.on("error", function(file, message) {
			toastr.error(message);
			this.removeFile(file);
		});
		mediaDropzone.on("complete", function(file) {
			this.removeAllFiles(true);
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

		function copyToClipboard(text) {
			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val(text).select();
			document.execCommand("copy");
			$temp.remove();
			toastr.success("URL copied to clipboard.");
		}
	</script>
@endsection
