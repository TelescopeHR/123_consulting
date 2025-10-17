@extends('admin.layouts.master')

@section('title', 'Reviews')

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('star-ratings/star-rating-svg.css') }}">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => 'Reviews - ' . $course->title])
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<table id="data-table" class="table">
								<thead>
									<tr>
										<th width="15%">User</th>
										<th width="15%">Ratings</th>
										<th width="60%">Review</th>
										<th width="10%">Action</th>
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

	<div class="modal fade ratings-modal" id="ratingsModel" tabindex="-1" role="dialog"
		aria-labelledby="ratingsLabelModal" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="col-md-12 col-sm-12">
					<div class="modal-header">
						<h5 class="modal-title" id="cargivermodel">Ratings</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
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
	<script src="{{ asset('js/jquery-impromptu.js') }}"></script>
	<script src="{{ asset('star-ratings/jquery.star-rating-svg.js') }}"></script>
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
			ajax: "{{ route('course.reviews', ['course' => $course->id]) }}",
			columns: [{
				data: 'user'
			}, {
				data: 'ratings'
			}, {
				data: 'review'
			}, {
				data: 'action',
				className: 'all',
				searchable: false,
				orderable: false
			}],
			drawCallback: function(settings, json) {
				$(".course-ratings-box").starRating({
					initialRating: 0,
					strokeWidth: 0,
					minRating: 0.5,
					starSize: 25,
					ratedColor: 'orange',
					activeColor: 'orange',
					readOnly: true,
					disableAfterRate: true,
				});
				$.each($(".course-ratings-box"), function(indexOfElement, formElement) {
					$(this).starRating('setRating', parseFloat($(this).data('average-ratings')), false);
				});
			}
		});

		$(document).on("click", ".show-ratings", function(event) {
			event.preventDefault();
			let url = $(this).attr("target-url");

			$.ajax({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
				},
				type: "GET",
				url: url,
				dataType: 'json',
				success: function(response) {
					if (response.status) {
						$("#ratingsModel").find(".modal-body").html(response.data);
						$(".course-ratings-box").starRating({
							initialRating: 0,
							strokeWidth: 0,
							minRating: 0.5,
							starSize: 25,
							ratedColor: 'orange',
							activeColor: 'orange',
							readOnly: true,
							disableAfterRate: true,
						});

						$.each($(".course-ratings-box"), function(indexOfElement, formElement) {
							$(this).starRating('setRating', parseFloat($(this).data('average-ratings')), false);
						});
						$("#ratingsModel").modal("show");
					}
				}
			});
		});
	</script>
@endsection
