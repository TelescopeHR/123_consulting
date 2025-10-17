@extends('admin.layouts.master')

@section('title', ucfirst(Str::plural($module)))

@section('css')
@endsection

@section('content')
    @include('admin.layouts.breadcrumb', ['module_title' => "Courses"])

	<section class="content">
		<div class="card">
			<div class="container-fluid">
				<div class="row @if ($courses->count()) pt-5 @endif" id="assignment-list">
					@forelse ($courses as $course)
						<div class="col-md-4 col-sm-6 col-lg-4 col-xl-3 mb-2" style="padding-left: 20px; padding-bottom: 20px;">
							<div class="card card-primary card-outline h-100">
								<div class="card-header">
									<div class="row">
										<div class="col-md-12">
											<div class="user-block">
												<p class="text-info"></p>
												<h5>
													<a class="text-bold text-dark stretched-link" >{{ $course->title }}</a>
												</h5>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<h5 class="text-uppercase text-bold">Course</h5>
									<span class="card-subtitle mb-2">{{ $course->lessons->count() }}
										{{ Str::plural('Lesson', $course->lessons->count()) }}</span>
									<p class="course_description">
										{!! \Illuminate\Support\Str::limit(strip_tags($course->description), 100, '...') !!}
									</p>
								</div>
								<div class="card-footer">
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12">
													<a href="{{ route('subscription.course.assign', $course) }}" class="btn btn-primary">Assign</a>
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
@endsection

@section('js')

@endsection
