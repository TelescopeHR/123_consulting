<div class="row">
	<div class="col-md-12 table-responsive mb-0">
		<table class="table table-sm mb-0">
			<thead class="thead">
				<tr>
					<th>Image</th>
					<th>Course/Policy</th>
					<th>Price</th>
					<th width="5%">Action</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($fbt_courses as $course)
					<tr>
						<td>
							<img src="{{ url('images/course/' . $course->image) }}" width="85px" />
						</td>
						<td>
							{{ $course->title }}<br>
							@php
								$average_ratings = 0;
								$course_reviews = $course->reviews->count();
								if ($course_reviews) {
								    $ratings = 0;
								    $ratings_counts = $course->ratings->count();
								
								    foreach ($course->ratings as $key_rating => $rating) {
								        $ratings += $rating->ratings;
								    }
								
								    $average_ratings = $ratings / $ratings_counts;
								}
							@endphp
							<div class=" d-flex align-items-center mt-0">
								<p class="course-card-total-rating m-0">{{ number_format($average_ratings, 1) }}</p>
								<div class="mx-2 course-ratings-box" data-average-ratings="{{ number_format($average_ratings, 2) }}">
								</div>
								<p class="course-card-total-reviews">({{ $course->reviews->count() }})</p>
							</div>

						</td>
						<td>
							{{ $course->price ? '$' . $course->price : 'Free' }}
						</td>
						<td>
							<a class="bttn bttn-primary bttn-cart btn-add-cart" href="{{ route('cart.add', $course->id) }}"
								title="Add to Cart">
								<i class="icon-cart"></i>
							</a>
						</td>
					</tr>
				@empty
				@endforelse

				@forelse ($fbt_policies as $policy)
					<tr>
						<td>
						<a href="{{ route('front.page', $policy->slug_relation->slug) }}"
								title="View Policy Manual Details"><img src="{{ asset('images/default.jpg') }}" width="85px" /></a>
						</td>
						<td>
							<a class="policy-link" href="{{ route('front.page', $policy->slug_relation->slug) }}"
								title="View Policy Manual Details">{{ $policy->title }}</a>
						</td>
						<td>{{ $policy->price ? '$' . $policy->price : 'Free' }}</td>
						<td>
							<a class="bttn bttn-primary bttn-cart btn-add-cart" href="{{ route('cart.policy.add', $policy->id) }}"
								title="Add to Cart">
								<i class="icon-cart"></i>
							</a>
						</td>
					</tr>
				@empty
				@endforelse
			</tbody>
		</table>
	</div>
</div>
