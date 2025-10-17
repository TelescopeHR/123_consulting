<style>
	.card-bg {
		background-image: radial-gradient(white 50%, #f3f0f0);
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

	.form-check-danger {
		background: #f3060629;
	}
</style>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				@isset($totalQuestion, $totalCleared)
					<div class="card view-result card-bg">
						<div class="card-body ml-4">
							<div class="row m-5">
								<div class="col-md-12 text-center">
									@if ($percentage >= $quiz->passing_score)
										<img class="img" width="120px" src="{{ asset('images/success-green-check-mark.png') }}"><br>
									@else
										<img class="img" width="120px" src="{{ asset('images/fail-red-mark.png') }}"><br>
									@endif
								</div>
								<div class="col-md-12 text-center">
									@if ($percentage >= $quiz->passing_score)
										<h3 class="mt-4">Quiz Complete</h3></br>
									@else
										<h3 class="mt-4">Failed</h3></br>
									@endif
								</div>
								<div class="col-md-12 text-center">
									<p class="text-bold">You Scored {{ $totalCleared }} / {{ $totalQuestion }} ,
										({{ $percentage ? number_format((float) $percentage, 2, '.', '') : 0 }})</p><br>
								</div>
								<div class="col-md-12 text-center">
									@if ($percentage >= $quiz->passing_score)
										{{-- <a href="{{ route('user.courses.completed') }}" class="btn btn-primary reload">Next</a> --}}
										<a href="{{ route('user.course.feedback', [$course->id]) }}" class="btn btn-primary">Submit feedback & Download certificate</a>
										<button type="button" class="btn btn-primary view_answers">View Answers</button>
									@else
										<button onClick="window.location.reload();" class="btn btn-primary reload">Retake Quiz</button>
										<button type="button" class="btn btn-primary view_answers">View Answers</button>
									@endif
								</div>
							</div>
						</div>
					</div>
					<div class="card view-ans d-none">
						<div class="card-header">
							<h3 class="w-100">{{ $course['title'] }}</h3>
						</div>
						<div class="card-body ml-4">
							<div class="row">
								@foreach ($questions as $key => $question)
									<div class="w-100 answer-wrap">
										<h5 class="mt-5 w-100">
											<p>{{ $question['title'] }}
											<p>
										</h5>
										@if ($question['answers'])
											@php
												$isCorrect = 1;
											@endphp
											@foreach ($question['answers'] as $answer)
												<div class="form-group w-100">
													@if (in_array($answer['id'], $givenAnswers) && in_array($answer['id'], $correctAns))
														<div class="form-check form-check-success border-success">
															<label class="form-check-label text-bold text-green">{{ $answer['title'] }}</label>
														</div>
													@elseif (!in_array($answer['id'], $givenAnswers) && !in_array($answer['id'], $correctAns))
														<div class="form-check">
															<label class="form-check-label text-bold">{{ $answer['title'] }}</label>
														</div>
													@elseif (!in_array($answer['id'], $givenAnswers) && in_array($answer['id'], $correctAns))
														@php
															$isCorrect = 0;
														@endphp
														<div class="form-check form-check-success border-success">
															<label class="form-check-label text-bold">{{ $answer['title'] }}</label>
														</div>
													@elseif (in_array($answer['id'], $givenAnswers) || !in_array($answer['id'], $correctAns))
														@php
															$isCorrect = 0;
														@endphp
														<div class="form-check form-check-danger border-danger">
															<label class="form-check-label text-bold text-red">{{ $answer['title'] }}</label>
														</div>
													@endif
												</div>
											@endforeach
											@if ($isCorrect)
												<label class="form-check-label text-bold text-green">Correct</label>
											@else
												<label class="form-check-label text-bold text-red">Incorrect</label>
											@endif
										@endif
									</div>
								@endforeach
							</div>
						</div>
						<div class="card-footer mt-4">
							<div class="row justify-content-center">
								<div class="col-sm-12">
									@if ($percentage >= $quiz->passing_score)
										{{-- <a href="{{ route('user.courses.completed') }}" class="btn btn-primary reload">Next</a> --}}
										<a href="{{ route('user.course.feedback', [$course->id]) }}" class="btn btn-primary">Submit feedback & Download certificate</a>
									@else
										<a onClick="window.location.reload();" class="btn btn-primary text-white reload">Retake Quiz</a>
										<a type="button" class="btn btn-primary text-white view_answers">Hide Answers</a>
									@endif
								</div>
							</div>
						</div>
					</div>
				@endisset
			</div>
		</div>
	</div>
</section>
