<hr>
<div class="row">
	<div class="col-3"><label>Price:</label> ${{ $course->price }}</div>
	<div class="col-9">
		<a href="javascript:void(0)" class="btn btn-sm btn-primary float-right" id="add-user" data-id="{{ $course->id }}">Add Caregiver</a>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="row">
			<div class="col-lg-8 col-sm-12">
				<div class="row mt-2">
					<img src="{{ $course->full_image }}" class="img-thumbnail" />
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="mt-2">
			<div class="dynamic-name-list"></div>
		</div>
	</div>
</div>
