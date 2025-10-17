@extends('admin.layouts.master')

@section('title', ucfirst(Str::singular($module)))

@section('css')
	<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', [
		'module_title' => Str::singular((isset($data) ? 'Edit ' : 'Add new ') . $module),
	])

	<section class="content">
		<div class="container-fluid">
			<div class="card card-primary">
				<form id="form-data" role="form" method="post"
					action="{{ isset($data) ? route('coupon.update', ['coupon' => $data->id]) : route('coupon.store') }}"
					enctype="multipart/form-data">
					@csrf
					@if (isset($data))
						<input type="hidden" name="_method" value="put">
					@endif
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="code">Code</label>
									<input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="code"
										placeholder="Code" value="{{ old('code', @$data->code) }}">
									@error('code')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="expired_at">Expiry date</label>
									<input type="text" name="expired_at" class="form-control @error('expired_at') is-invalid @enderror"
										id="expired_at" placeholder="MM/DD/YYYY"
										value="{{ old('expired_at', isset($data) && $data->expired_at ? $data->expired_at->format('m/d/Y') : '') }}">
									@error('expired_at')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="type">Type</label>
									<select class="form-control select2 @error('type') is-invalid @enderror" name="type" id="type">
										<option value="" selected disabled>Select type</option>
										<option value="percentage" @if (old('type', @$data->type) == 'percentage') selected @endif>
											Percentage</option>
										<option value="price" @if (old('type', @$data->type) == 'price') selected @endif>Price
										</option>
									</select>
									@error('type')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="value">Amount</label>
									<div class="form-group input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text type_symbol">{{ isset($data) && $data->type == 'percentage' ? '%' : '$' }}</span>
										</div>
										<input type="text" name="value" class="form-control @error('value') is-invalid @enderror" id="value"
											placeholder="Value" value="{{ old('value', @$data->value) }}">
										@error('value')
											<span class="error invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary">{{ isset($data) ? 'Update' : 'Submit' }}</button>
						<a href="{{ route('coupon.index') }}" class="btn btn-default">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</section>

@endsection

@section('js')
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
	<script>
		$.validator.addMethod("price_percentage", function(value, element) {
			if ($("#type").val().length && $("#type").val() == "percentage") {
				if (value > 100) {
					return false;
				}
			}
			return true;
		}, "Percentage value should be less than 100");

		$(document).on("change", "#type", function() {
			if ($("#value").val().length) {
				$("#value").valid();
			}
		});

		$("#form-data").validate({
			rules: {
				code: {
					required: true,
					maxlength: 150
				},
				expired_at: {
					date: true
				},
				type: {
					required: true,
				},
				value: {
					required: true,
					price_percentage: true,
					number: true
				}
			},
			errorElement: 'span',
			errorClass: 'invalid-feedback',
			highlight: function(element, errorClass, validClass) {
				if ($(element).hasClass('select2')) {
					$(element).next('.select2-container').addClass('is-invalid');
				} else {
					$(element).addClass('is-invalid');
				}
			},
			unhighlight: function(element, errorClass, validClass) {
				if ($(element).hasClass('select2')) {
					$(element).next('.select2-container').removeClass('is-invalid');
				} else {
					$(element).removeClass('is-invalid');
				}
			},
			errorPlacement: function(error, element) {
				$(element).closest('.form-group').append(error[0]);
			},
		});

		$("#expired_at").datepicker({
			format: 'mm/dd/yyyy',
			autoclose: true
		}).on('changeDate', function(ev) {
			if ($('#expired_at').valid()) {
				$('#expired_at').removeClass('invalid');
			}
		});

		$(document).on("change", "#type", function(event) {
			event.preventDefault();
			let sign = $(this).val() == "percentage" ? "%" : "$";
			$("span.type_symbol").html(sign);
		});
	</script>
@endsection
