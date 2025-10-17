@php
	$randNum = rand(11111, 99999);
@endphp
<div class="row mt-2">
	<div class="col-md-3 pt-1">
		<input type="text" name="name[{{ $randNum }}][first_name]"
			class="form-control name_validation @error('name.' . $randNum . '.first_name') is-invalid @enderror"
			placeholder="First Name" data-title="First Name" />
		@error('name.' . $randNum . '.first_name')
			<span class="error invalid-feedback">{{ $message }}</span>
		@enderror
	</div>
	<div class="col-md-3 pt-1">
		<input type="text" name="name[{{ $randNum }}][last_name]"
			class="form-control name_validation @error('name.' . $randNum . '.last_name') is-invalid @enderror"
			placeholder="Last Name" data-title="Last Name" />
		@error('name.' . $randNum . '.last_name')
			<span class="error invalid-feedback">{{ $message }}</span>
		@enderror
	</div>
	<div class="col-md-4 pt-1">
		<input type="email" name="name[{{ $randNum }}][email]"
			class="form-control name_validation @error('name.' . $randNum . '.email') is-invalid @enderror" placeholder="Email (optional)"
			data-title="Email" />
		@error('name.' . $randNum . '.email')
			<span class="error invalid-feedback">{{ $message }}</span>
		@enderror
		<p class="text-muted">Enter your email address. We will send login details to it.</p>
	</div>
	<div class="col-md-2 pt-1">
		<a href="javascript:void(0)" class="btn btn-danger remove-user"><i class="fa fa-minus"></i></a>
	</div>
</div>
