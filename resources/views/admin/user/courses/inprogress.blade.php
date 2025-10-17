@extends('admin.layouts.master')

@section('title', 'My Courses')

@section('css')
	<style type="text/css">
		#assignment-list .card {
			border-radius: 4px;
			background: #fff;
			box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
			transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
			cursor: pointer;
		}

		#assignment-list .card:hover {
			transform: scale(1.05);
			box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
		}

		@media(max-width: 990px) {
			#assignment-list .card {
				margin-bottom: 20px;
			}
		}
	</style>
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', ['module_title' => 'In Progress'])
	@role(Config::get('constants.users_roles.customer') . '|' . Config::get('constants.users_roles.caregiver'))
		<section class="content">
			<div class="card">
				<div class="container-fluid">
					<div class="row @if ($user_courses->count()) pt-5 @endif" id="assignment-list">
						@forelse ($user_courses as $key_course => $user_course)
							@php
								$course = $user_course->course;
								$course_lessons = $course->lessons;
								$total_lessons = $course_lessons->count();
							@endphp
							<div class="col-md-4 col-sm-6 col-lg-4 col-xl-3 mb-2" style="padding-left: 20px; padding-bottom: 20px;">
								<div class="card card-primary card-outline h-100">
									<div class="card-header">
										<div class="row">
											<div class="col-md-12">
												<div class="user-block">
													<p class="text-info text-right">
														<small>Purchased on: {{ \Carbon\Carbon::parse($user_course->created_at)->format('m/d/Y') }}</small>
													</p>
													<h5>
														<a class="text-bold text-dark stretched-link" href="#">{{ $course->title }}</a> -
														{{ $user_course->certificate_name ?? ($user_course->caregiver->first_name . ' ' . $user_course->caregiver->last_name) }}
													</h5>
												</div>
											</div>
											<div class="col-md-12">
												<div class="user-block w-100 d-flex">
													@php
														$status = '<div class="text-danger"><i class="fa fa-circle"></i> Not Started</div>';
														if ($user_course->last_active) {
														    $now = \Carbon\Carbon::now();
														    $diff = $now->diffInSeconds(\Carbon\Carbon::parse($user_course->last_active));
														
														    if ($diff <= 2 * 24 * 60 * 60) {
														        $class = 'text-green';
														        $text = 'On Track';
														    } elseif ($diff <= 4 * 24 * 60 * 60) {
														        $class = 'text-warning';
														        $text = 'At Risk';
														    } else {
														        $class = 'text-danger';
														        $text = 'Not Started';
														    }
														    $status = '<div class="' . $class . ' w-50"><i class="fa fa-circle"></i> ' . $text . '</div>';
														    $status .= '<div class="w-50"><div style="text-align: right;">' . \Carbon\Carbon::parse($user_course->last_active)->diffForHumans() . '</div></div>';
														}
													@endphp
													{!! $status !!}
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<a class="text-bold text-dark stretched-link" href="{{ route('user.course', [$user_course]) }}"></a>
										<h5 class="text-uppercase text-bold">Course</h5>
										<span class="card-subtitle mb-2">{{ $total_lessons }}
											{{ Str::plural('Lesson', $total_lessons) }}</span>
										<p class="course_description">
											{!! \Illuminate\Support\Str::limit(strip_tags($course->description), 100, '...') !!}
										</p>
									</div>
									<div class="card-footer">
										<div class="row">
											<div class="col-md-6">
												<div class="row">
													@php
														$progressPercent = 0;
														$status = 'Not Started Yet';
														$completed_lesson_ids = $user_course->completed_lesson_ids ? explode(',', $user_course->completed_lesson_ids) : [];
														$progressPercent = ($user_course->completed_lessons * 100) / ($total_lessons ?: 1);
														
														if ($progressPercent) {
														    $status = $progressPercent == 100 ? 'Take a Quiz' : ($total_lessons - $user_course->completed_lessons > 1 ? $total_lessons - $user_course->completed_lessons . ' Lessons Left' : $total_lessons - $user_course->completed_lessons . ' Lesson Left');
														} else {
														    if ($user_course->start_date) {
														        $status = 'Watch Lessons';
														    }
														}
													@endphp

													<div class="col-md-12 text-center">
														<span>{{ $status }}</span>
													</div>
													<div class="col-md-12">
														<div class="progress mb-3">
															<div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{ $progressPercent }}"
																aria-valuemin="0" aria-valuemax="100" style="width:{{ $progressPercent }}%"></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						@empty
							<div class="card-body">
								<div class="row pt-3" id="assignment-list">
									<div class="col-md-12">
										<h6 class=" text-center">
											<a class="text-dark">No Courses Found</a>
										</h6>
									</div>
								</div>
							</div>
						@endforelse
					</div>
				</div>
			</div>
		</section>
	@endrole
@endsection
@section('js')
@endsection
