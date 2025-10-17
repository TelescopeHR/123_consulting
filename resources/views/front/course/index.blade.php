@extends('front.layouts.master')

@section('title', 'Courses - 123 Consulting Solutions')

@section('content')
	<!-- Section Head -->
	<section class="pagehead pagehead-shrink bg--lightgray">
		<div class="container text-center my-4">
			<h1>{{ isset($category) ? $category->name : '' }}</h1>
		</div>
	</section>

	<!--Inner Page Head-->
	<section class="our-courses-section section-space-b">
		<div class="container">
			<div class="our-courses-tabing">
				<div class="tab-content" id="courseTabsContent">
					<div class="tab-pane fade show active" id="admin" role="tabpanel">
						<div class="tabing-content-details ">
							<div class="courselist row">
								<div class="course-card-box">
									@foreach ($courses as $course)
										@include('front.course.card', ['course' => $course])
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Inner Page Head ENDS-->
@endsection
