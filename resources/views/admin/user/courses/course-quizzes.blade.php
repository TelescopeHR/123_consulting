@extends('admin.layouts.master')

@section('title', ucfirst($current_course->title))

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
	<style>
		#myTab a {
			color: #495057;
		}

		#myTab.nav-tabs .nav-item.show .nav-link,
		#myTab.nav-tabs .nav-link.active {
			color: #007bff;
		}

		@media screen and (min-width: 1024px) {
			.lesson-tab {
				display: none;
			}
		}

		@media screen and (max-width: 1024px) {
			.lesson-list-div {
				display: none;
			}
		}

		.form-check {
			padding: 10px 10px 10px 30px;
			background: #ededed;
			border: 1px solid black;
			border-radius: 6px;
		}

		.form-check-success {
			background: #06f32e29;
		}
	</style>
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => 'Quiz'])
	@php
		$quiz = $current_quiz;
	@endphp
	<section class="content">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">{{ $current_course->title }}</h3>
				</div>
				<div class="card-body">
					<div class="row">
						@include('admin.user.courses.lessons')
						<div class="col-md-12 col-lg-9 min-vh-100">
							<div class="row d-flex justify-content-center">
								<div class="col-md-12">
									<div class="quiz-section">
										<section class="content">
											<div class="container-fluid">
												<div class="row">
													<div class="col-md-12 col-sm-12">
														@php
															$question_count = $current_quiz->questions->count();
														@endphp

														@if ($question_count)
															<div class="card">
																<div class="card-header">
																	<h3 class="w-100">{{ $current_quiz->title }}</h3>
																</div>
																<form id="lesson_quiz" class="disabledSubmit" enctype="multipart/form-data">
																	@csrf
																	<div class="card-body mx-4">
																		<input type="hidden" name="user_course_id" value="{{ $user_course->id }} ">
																		<input type="hidden" name="course_id" value="{{ $current_course->id }} ">
																		<input type="hidden" name="quiz_id" value="{{ $current_quiz->id }} ">
																		<div class="row">
																			@foreach ($current_quiz->questions as $key => $question)
																				<div class="w-100 answer-wrap @if ($key == 0) d-block @else d-none next @endif"
																					data-question-id="{{ $key }}">
																					<p class=""><span class="text-bold mr-2">Question {{ $key + 1 }}</span>of
																						{{ $question_count }}
																					</p>
																					<h4>{{ $question['title'] }}</h4>
																					@if ($question['answers'])
																						@foreach ($question['answers'] as $answer)
																							@if ($question['answer_type'] == 1)
																								<label for="que_{{ $answer['id'] }}" class="form-check-label w-100">
																									<div class="form-group w-100">
																										<div class="form-check answer-item-check" data-answer-is-correct="{{ $answer['is_true'] }}">
																											<input class="form-check-input answer-item" type="radio"
																												name="question[{{ $key }}][]" id="que_{{ $answer['id'] }}"
																												value="{{ $answer['id'] }}">
																											<input type="hidden" name="question_id[{{ $key }}][]"
																												value="{{ $question['id'] }}">
																											<label class="form-check-label" for="que_{{ $answer['id'] }}">{{ $answer['title'] }}</label>
																										</div>
																									</div>
																								</label>
																							@else
																								<label for="que_{{ $answer['id'] }}" class="form-check-label w-100">
																									<div class="form-group w-100">
																										<div class="form-check answer-item-check" data-answer-is-correct="{{ $answer['is_true'] }}">
																											<input class="form-check-input answer-item" type="checkbox"
																												name="question[{{ $key }}][]" id="que_{{ $answer['id'] }}"
																												value="{{ $answer['id'] }}">
																											<input type="hidden" name="question_id[{{ $key }}][]"
																												value="{{ $question['id'] }}">
																											<label class="form-check-label" for="que_{{ $answer['id'] }}">{{ $answer['title'] }}</label>
																										</div>
																									</div>
																								</label>
																							@endif
																						@endforeach
																					@endif
																				</div>
																			@endforeach
																		</div>
																	</div>
																	<div class="card-footer mt-4">
																		<div class="row justify-content-center">
																			<div class="col-sm-12 text-right">
																				@if ($question_count == 1)
																					<button type="submit" class="btn btn-primary text-uppercase submit-question">Submit Quiz</button>
																				@else
																					<button type="button" class="btn btn-primary text-uppercase previous-question d-none">Previous
																						Question</button>
																					<button type="button" class="btn btn-primary text-uppercase next-question">Next Question</button>
																					<button type="submit" class="btn btn-primary text-uppercase d-none submit-question">Submit
																						Quiz</button>
																				@endif
																			</div>
																		</div>
																	</div>
																</form>
															</div>
														@endif
													</div>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div class="row mt-2 d-flex justify-content-center mt-3">
								<div class="col-md-12">
									<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
										@if ($current_quiz->description)
											<li class="nav-item" role="presentation">
												<a class="nav-link active" id="quiz-description-tab" data-toggle="tab" href="#quiz-description"
													role="tab" aria-controls="quiz-description" aria-selected="true">Quiz Overview</a>
											</li>
										@endif

										<li class="nav-item" role="presentation">
											<a class="nav-link {{ $current_quiz->description == null ? 'active' : '' }}" id="course-description-tab"
												data-toggle="tab" href="#course-description" role="tab" aria-controls="course-description"
												aria-selected="true">Course Overview</a>
										</li>
									</ul>
									<div class="tab-content" id="myTabContent">
										@if ($current_quiz->description)
											<div class="tab-pane fade show active" id="quiz-description" role="tabpanel"
												aria-labelledby="quiz-description-tab">
												<div class="pt-3">
													{!! $current_quiz->description !!}
												</div>
											</div>
										@endif
										<div class="tab-pane fade {{ $current_quiz->description == null ? ' show active' : '' }}"
											id="course-description" role="tabpanel" aria-labelledby="course-description-tab">
											<div class="pt-3">
												{!! $current_course->description !!}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection

@section('js')
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('js/jquery-impromptu.js') }}"></script>

	<script>
		$(document).on("click", ".next-question", function(event) {
			let valid = true;
			for (let i = 0; i < $('.answer-wrap.d-block').length; i++) {
				let item = $('.answer-wrap.d-block')[i]
				let checked = $(item).find('.answer-item:checked')
				if (!checked.length) {
					valid = false
					break;
				}
			}
			if (!valid) {
				$.prompt("Answer is missing.");
				return false;
			} else {
				var id = $('.answer-wrap.d-block').data('question-id');
				next = id + 1;
				next2 = id + 2;
				if ($('.answer-wrap[data-question-id="' + next + '"]').length) {
					$('[data-question-id="' + id + '"]').removeClass('d-block').addClass('d-none');
					$('[data-question-id="' + next + '"]').removeClass('d-none').addClass('d-block');
				}
				if ($('.answer-wrap[data-question-id*="' + id + '"]').length) {
					$('.previous-question').removeClass('d-none');
				}
				if (!$('.answer-wrap[data-question-id*="' + next2 + '"]').length) {
					$('.next-question').addClass('d-none');
					$('.submit-question.d-none').removeClass('d-none');
				}
			}
		});

		$(document).on("click", ".previous-question", function(event) {
			var id = $('.answer-wrap.d-block').data('question-id');
			previous = id - 1;
			previous2 = id - 2;
			if ($('.answer-wrap[data-question-id="' + previous + '"]').length) {
				$('[data-question-id="' + id + '"]').removeClass('d-block').addClass('d-none');
				$('[data-question-id="' + previous + '"]').removeClass('d-none').addClass('d-block');
			}
			if ($('.answer-wrap[data-question-id*="' + previous + '"]').length) {
				$('.next-question').removeClass('d-none');
			}
			if (!$('.answer-wrap[data-question-id*="' + previous2 + '"]').length) {
				$('.previous-question').addClass('d-none');
			}
			if (!$('.answer-wrap[data-question-id*="' + next2 + '"]').length) {
				$('.submit-question').addClass('d-none');
			} else {
				$('.submit-question').removeClass('d-none');
			}
		});

		$(document).on("submit", "#lesson_quiz", function() {
			event.preventDefault();
			let valid = true;
			for (let i = 0; i < $('.answer-wrap.d-block').length; i++) {
				let item = $('.answer-wrap.d-block')[i]
				let checked = $(item).find('.answer-item:checked')
				if (!checked.length) {
					valid = false
					break;
				}
			}
			if (!valid) {
				$.prompt("Answer is missing.");
				return false;
			} else {
				data = $("#lesson_quiz").serialize();
				var token = $('input[name="_token"]').val();
				$.ajax({
					headers: {
						'X-CSRF-Token': token
					},
					type: "POST",
					data: data,
					url: "{{ route('user.course.store-quiz-answers') }}",
					success: function(data) {
						if (data) {
							$('.quiz-section').html(data);
						}
					}
				});
			}
		});

		$(document).on("click", ".view_answers", function() {
			if ($(".view-ans").hasClass('d-none')) {
				$(".view-ans").removeClass('d-none');
				$(".view-result").addClass('d-none');
			} else {
				$(".view-ans").addClass('d-none');
				$(".view-result").removeClass('d-none');
			}
		});

		$(document).on("click", "a.course_lesson, a.course_quiz", function(event) {
			event.preventDefault();
			let url = $(this).attr("href");
			let queryParams = window.location.search;
			window.location.href = queryParams.length ? url + queryParams : url;
		});
	</script>
@endsection
