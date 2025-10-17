@extends('admin.layouts.master')

@php
	$module = 'Completed';
@endphp

@section('title', $module)

@section('css')
	<style>
		#assignment-list span.read_time {
			border-left: 1px solid gray;
			margin-left: 5px;
			padding-left: 8px;
			height: 3px;
		}

		.due_date {
			position: absolute;
			bottom: 10px;
			width: 90%;
		}

		#assignment-list .card {
			border-radius: 4px;
			background: #fff;
			box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
			transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
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
	@include('admin.layouts.breadcrumb', ['module_title' => $module])

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
													<p class="text-info"></p>
													<h5>
														<a class="text-bold text-dark stretched-link" href="#">{{ $course->title }}</a> -
														{{ $user_course->certificate_name ?? ($user_course->caregiver->first_name . ' ' . $user_course->caregiver->last_name) }}
													</h5>
												</div>
											</div>
											<div class="col-md-12">
												<div class="user-block w-100 d-flex">
													<div class="text-green w-50">
														<i class="fa fa-circle"></i> Completed
													</div>
													{{-- <div class="w-50">
														<div style="text-align: right">4 seconds ago</div>
													</div> --}}
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
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
												Completed
												<br>
												<a href="{{ asset('pdfs/certificates/' . $user_course->certificate) }}" target="_blank"><i
														class="fa fa-file-pdf"></i></a>
											</div>
											<div class="col-md-6">
												<p class="card-text text-right text-success"><b>Completed On:</b>
													{{ date('m/d/Y', strtotime($user_course->end_date)) }}</p>
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
	<script src="{{ asset('js/jquery-impromptu.js') }}"></script>
@endsection
