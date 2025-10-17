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
	</style>
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => ucfirst('Assignments')])

	@php
		$quiz = $current_course->quizzes->first();
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
									<div class="lesson-video-section">
										<div class="embed-responsive embed-responsive-16by9">
											<div id="lesson-video"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row mt-2 d-flex justify-content-center mt-3">
								<div class="col-md-12">
									<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
										<li class="nav-item" role="presentation">
											<a class="nav-link active" id="lesson-description-tab" data-toggle="tab" href="#lesson-description"
												role="tab" aria-controls="lesson-description" aria-selected="true">Lesson Overview</a>
										</li>

										<li class="nav-item" role="presentation">
											<a class="nav-link" id="course-description-tab" data-toggle="tab" href="#course-description" role="tab"
												aria-controls="course-description" aria-selected="true">Course Overview</a>
										</li>
									</ul>
									<div class="tab-content" id="myTabContent">
										<div class="tab-pane fade show active" id="lesson-description" role="tabpanel"
											aria-labelledby="lesson-description-tab">
											<div class="pt-3">
												{!! $current_lesson->description !!}
											</div>
										</div>
										<div class="tab-pane fade" id="course-description" role="tabpanel" aria-labelledby="course-description-tab">
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
	<script src="{{ asset('js/vimeo-player.js') }}"></script>

	<script>
		var oEmbedEndpoint = 'https://vimeo.com/api/oembed.json'
		var oEmbedCallback = 'switchVideo';

		getVideo("{{ $current_lesson->video }}");

		function getVideo(url) {
			$.getScript(oEmbedEndpoint + '?url=' + url + '&width=504&height=280&callback=' + oEmbedCallback);
		}

		function switchVideo(video) {
			if ($('.lesson-video-section').hasClass('d-none')) {
				$('.quiz-section').addClass('d-none');
				$('.lesson-video-section').removeClass('d-none');
			}
			$('#lesson-video').html(unescape(video.html));
			if ($('#lesson-video iframe')[0]) {
				var player = new Vimeo.Player($('#lesson-video iframe')[0]);
				player.on('ended', function() {
					let id = $('.lesson-list.active').data('id');
					let token = $('input[name="_token"]').val();
					let nextLesson = $('.lesson-list.active').parent('a.course_lesson').next('a.course_lesson');
					$.ajax({
						headers: {
							'X-CSRF-Token': token
						},
						type: "POST",
						data: {
							user_course_id: "{{ $user_course->id }}",
							lession_id: id
						},
						url: "{{ route('user.course.lesson.completed') }}",
						success: function(response) {
							if (response.status) {
								let queryParams = window.location.search;
								if (nextLesson.length) {
									window.location.href = queryParams.length ? nextLesson.attr("href") + queryParams : nextLesson.attr("href");
								} else {
									let nextUrl = '';
									if ($(".pagination").length) {
										let nextPage = $("li.page-item.active").next("li.page-item").find("a.page-link");
										if (nextPage.length) {
											nextUrl = nextPage.attr("href");
										}
									}

									if (nextUrl) {
										$.ajax({
											headers: {
												'X-CSRF-Token': token
											},
											type: "GET",
											data: {},
											url: nextUrl,
											success: function(response) {
												if (response.status) {
													window.location.href = response.data_url;
												} else {
													location.reload();
												}
											}
										});
									} else {
										let isNextQuiz = $("a.course_quiz");
										if (isNextQuiz.length) {
											window.location.href = queryParams.length ? isNextQuiz.attr(
												"href") + queryParams : isNextQuiz.attr("href");
										} else {
											location.reload();
										}
									}
								}
							}
						}
					});
				});
				@php
					$previousUsers = session()->get('previousUsers');
				@endphp
				@if (empty($previousUsers))
					var timeWatched = 0;
					player.on("timeupdate", function(data) {
						if (data.seconds - 1 < timeWatched && data.seconds > timeWatched) {
							timeWatched = data.seconds;
						}
					});

					// Commented this code because of Video forwarding issue.
					// By uncommenting code, will not allow user to forward video. 
					/*
					player.on("seeked", function(data) {
						if (timeWatched < data.seconds) {
							player.setCurrentTime(timeWatched);
						}
					});
					*/
				@endif
				@if ($user_course->start_date == null)
					player.on('play', function() {
						var token = $('input[name="_token"]').val();
						$.ajax({
							headers: {
								'X-CSRF-Token': token
							},
							type: "POST",
							url: "{{ route('user.course.start') }}",
							data: {
								user_course_id: {{ $user_course->id }}
							},
							success: function(data) {}
						});
					});
				@endif
			}
		}

		$(document).on("click", "a.course_lesson, a.course_quiz", function(event) {
			event.preventDefault();
			let url = $(this).attr("href");
			let queryParams = window.location.search;
			window.location.href = queryParams.length ? url + queryParams : url;
		});
	</script>

@endsection
