<div class="course-card-box">
	@foreach ($courses as $key => $course)
		@include('front.course.card', ['course' => $course])
	@endforeach
</div>

<div class="d-flex justify-content-end">
		{{ $courses->links('components.custom-pagination') }}
	
</div>
