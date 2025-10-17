@extends('front.layouts.master')

@section('title', 'Courses - 123 Consulting Solutions')

@section('content')
	<!-- Section Head -->
	<section class="pagehead pagehead-shrink bg--lightgray">
		<div class="container text-center my-4">
			<h1>Policy Manuals</h1>
		</div>
	</section>

	<section class="our-courses-section section-space-b">
		<div class="container">
			<div class="our-courses-tabing">
				<div class="tab-content" id="courseTabsContent">
					<div class="tab-pane fade show active" id="admin" role="tabpanel">
						<div class="tabing-content-details ">
							<div class="courselist row">
								<div class="course-card-box">
									@foreach ($policy_manuals as $policy_manual)
										@include('front.policy_manual.card', ['policy_manual' => $policy_manual])
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
