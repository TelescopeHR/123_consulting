@extends('admin.layouts.master')

@php
	$module = 'Feedback';
@endphp

@section('title', $module)

@section('css')
	<link rel="stylesheet" href="{{ asset('star-ratings/star-rating-svg.css') }}">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => $module])

	@role(Config::get('constants.users_roles.customer') . '|' . Config::get('constants.users_roles.caregiver'))
		<section class="content">
			<div class="card">
				<div class="card-header">
					<h4 class="w-100">{{ $course->title }}</h4>
				</div>
				<form id="feedback_form" method="post" action="{{ route('user.course.submit-feedback') }}" enctype="multipart/form-data">
					@csrf
					<div class="card-body ml-4">
						<input type="hidden" name="course_id" value="{{ $course->id }} ">
						<div class="row">
							<div class="col-md-12">
								@foreach ($review_questions as $key => $question)
									<div class="w-100 my-3 question-ratings-box" data-question="{{ $question->id }}">
										<h5>{{ $key + 1 }}. &nbsp;{{ $question['question'] }}</h5>
										<div class="mb-2 ratings-box"></div>
										<input type="hidden" class="ratings-value @error('ratings.' . $question->id) is-invalid @enderror"
											value="{{ old('ratings.' . $question->id) }}" name="ratings[{{ $question->id }}]">
										@error('ratings.' . $question->id)
											<span class="error invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								@endforeach
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="comment">Additional comment:</label>
									<textarea id="comment" rows="5" name="comment" class="form-control @error('comment') is-invalid @enderror"
									 placeholder="Place your comment here.">{{ old('comment') }}</textarea>
									@error('comment')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer mt-4">
						<div class="row justify-content-center">
							<div class="col-sm-12 text-right">
								<button type="submit" class="btn btn-primary text-uppercase submit-feedback">Submit Feedback</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</section>
	@endrole
@endsection

@section('js')
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('js/jquery-impromptu.js') }}"></script>
	<script src="{{ asset('star-ratings/jquery.star-rating-svg.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>

	<script>
		$(".ratings-box").starRating({
			initialRating: 0,
			strokeWidth: 0,
			minRating: 0.5,
			disableAfterRate: false,
			callback: function(currentRating, element) {
				let questionId = $(element).closest(".question-ratings-box").data("question");
				$(element).closest(".question-ratings-box").find("input.ratings-value").val(currentRating).attr(
					"value", currentRating).valid();
			}
		});

		$("#feedback_form").validate({
			ignore: [],
			errorElement: 'span',
			errorClass: 'invalid-feedback',
			errorPlacement: function(error, element) {
				$(error[0]).insertAfter(element);
			},
		});

		$.each($("input.ratings-value"), function(indexOfElement, formElement) {
			let field_title = $(formElement).data('title');
			$(formElement).rules("add", {
				required: true,
				messages: {
					required: "Select ratings."
				}
			});

			if ($(formElement).val() != "") {
				$(formElement).closest(".question-ratings-box").find(".ratings-box").starRating('setRating', $(
					formElement).val(), true);
			}
		});
	</script>
@endsection
