<div class="col-md-12 col-lg-3 lesson-list-div">
	<ul class="list-group">
		@if ($lessons->count())
			@foreach ($lessons as $key => $lesson)
				<a href="{{ route('user.courses.lessons', [$current_course->slug_relation->slug, $lesson->slug_relation->slug]) }}"
					class="course_lesson" data-lesson-id="{{ $lesson->id }}">
					<li
						class="text-left list-group-item lesson-list {{ isset($current_lesson->id) && $lesson->id == $current_lesson->id ? 'active current btn' : '' }}"
						data-id="{{ $lesson->id }}" title="Lesson">
						@if (in_array($lesson->id, explode(',', $user_course->completed_lesson_ids)))
							<i class="float-right text-green fa fa-check"></i>
						@endif
						{{ $lesson->title }}
					</li>
				</a>
			@endforeach
		@endif

		@if ($quiz)
			<a href="{{ route('user.courses.quizzes', [$current_course->slug_relation->slug, $quiz->slug_relation->slug]) }}"
				title="Quiz" class="course_quiz">
				<li
					class="text-left list-group-item mt-2 {{ isset($current_quiz->id) && $quiz->id == $current_quiz->id ? 'active current btn' : '' }}">
					<i class="nav-icon fas fa-table"></i>
					&nbsp;{{ $quiz->title }}
				</li>
			</a>
		@endif
	</ul>
	@if ($lessons->count())
		<div class="d-flex">
			<div class="mx-auto mt-3">
				{{ $lessons->links('pagination::bootstrap-4') }}
			</div>
		</div>
	@endif
</div>
