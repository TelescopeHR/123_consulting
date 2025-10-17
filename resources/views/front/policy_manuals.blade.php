@if ($policy_manuals->count())
	<div class="course-card-box">
		@foreach ($policy_manuals as $key_policy_manual => $policy_manual)
			@include('front.policy_manual.card', ['policy_manual' => $policy_manual])
		@endforeach
	</div>

	<div class="d-flex justify-content-end">
			{{ $policy_manuals->links('components.custom-pagination') }}
	</div>	
@else	
	<div class="policy-manual-list row">
		<div class="col-md-12"><span class="text-center">No records found!</span></div>
	</div>
@endif
