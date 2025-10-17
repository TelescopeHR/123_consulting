<div class="container-fluid">
	@forelse ($ratings as $key_rating => $rating)
		@if ($rating->review_question)
			<h5>{{ $key_rating + 1 }}. &nbsp;{{ $rating->review_question->question }}</h5>
			<div class="ml-1 mb-3 course-ratings-box" data-average-ratings="{{ number_format($rating->ratings, 2) }}"></div>
		@endif
	@empty
	@endforelse
</div>

@if ($review->comment)
	<p><b>Review : </b>{{ $review->comment }}</p>
@endif
