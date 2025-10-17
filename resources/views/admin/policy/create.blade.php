@extends('admin.layouts.master')

@section('title', ucfirst(Str::singular($module)))

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
@endsection

@section('content')
	@php
		if (isset($data)) {
		    $breadcrumb = 'Edit ' . $module . ' - ' . $data->title;
		} else {
		    $breadcrumb = 'Add new ' . $module;
		}
	@endphp
	@include('admin.layouts.breadcrumb', ['module_title' => Str::singular($breadcrumb)])
	<section class="content">
		<div class="container-fluid">
			<div class="card card-primary">
				<form id="form-data" role="form" method="post"
					action="{{ isset($data) ? route('policy.update', ['policy' => $data->id]) : route('policy.store') }}"
					enctype="multipart/form-data">
					@csrf
					@if (isset($data))
						<input type="hidden" name="_method" value="put">
					@endif
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="title">Title</label>
									<input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title"
										placeholder="Title" value="{{ old('title', @$data->title) }}">
									@error('title')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<label for="price">Price</label>
								<div class="form-group input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">$</span>
									</div>
									<input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
										aria-label="Amount (to the nearest dollar)" id="price" placeholder="Price"
										value="{{ old('price', @$data->price) }}">
									@error('price')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="slug">Slug</label>
									<input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug"
										placeholder="Slug"
										value="{{ old('slug', isset($data) && $data->slug_relation ? $data->slug_relation->slug : '') }}">
									@error('slug')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="tax">Tax</label>
									<div class="form-group input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input type="number" class="form-control @error('tax') is-invalid @enderror" name="tax"
											aria-label="Amount (to the nearest dollar)" id="tax" placeholder="Tax"
											value="{{ old('tax', @$data->tax) ? old('tax', @$data->tax) : NULL }}">
										@error('tax')
											<span class="error invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="document">Document</label>
									<input type="file" name="document" class="form-control @error('document') is-invalid @enderror"
										id="document">
									@error('document')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="course_id">Course</label>
									<select class="form-control select2 @error('course_id') is-invalid @enderror" name="course_id" id="course_id">
										<option value="" disabled selected>Select an option</option>
										@foreach ($courses as $course)
											<option value="{{ $course->id }}" @if ($course->id == old('course_id', @$data->course_id))) selected @endif>{{ $course->title }}
											</option>
										@endforeach
									</select>
									@error('course_id')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="custom-control custom-checkbox form-group">
									<input type="checkbox" class="custom-control-input" name="is_in_fbt" id="is_in_fbt" value="1"
										{{ old('is_in_fbt', @$data->is_in_fbt) ? 'checked' : '' }}>
									<label for="is_in_fbt" class="custom-control-label">Frequently Bought Together</label>
									@error('is_in_fbt')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="description">Description</label>
									<textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', @$data->description) }}</textarea>
									@error('description')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary">{{ isset($data) ? 'Update' : 'Submit' }}</button>
						<a href="{{ route('policy.index') }}" class="btn btn-default">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</section>
@endsection
@section('js')
	<!-- DataTables -->
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('js/jquery-validate-additional-methods.min.js') }}"></script>
	<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('js/jquery-impromptu.js') }}"></script>
	<script>
		CKEDITOR.replace(document.querySelector('#description'));
		CKEDITOR.config.extraPlugins = 'colorbutton';

		let required = true;
		@if (isset($data))
			required = false;
		@endif

		$.validator.addMethod("taxMinThanPrice", function(value, element) {
			if (value && value != 0) {
				return parseFloat(value) < parseFloat($("#price").val());
			}
			return true;
		}, "Tax should be less than price.");

		$.validator.addMethod("rangeCheck", function(value, element) {
			if (value) {
				return parseFloat(value) >= 1 && parseFloat(value) <= 9999.99;
			}
			return true;
		});

		$.validator.addMethod('fileSize', function(value, element, param) {
			return this.optional(element) || (element.files[0].size <= param)
		}, 'File size must be less than 20 MB.');

		$("#form-data").validate({
			ignore: [],
			rules: {
				title: {
					required: true,
					maxlength: 200
				},
				document: {
					required: required,
					fileSize: 20500000,
					extension: 'doc|docx|pdf|mp4|ogx|oga|ogv|ogg|webm|zip',
				},
				description: {
					required: function() {
						CKEDITOR.instances.description.updateElement();
					},
					minlength: 10
				},
				price: {
					rangeCheck: true,
				},
				tax: {
					required: false,
					rangeCheck: true,
					taxMinThanPrice: true,
				},
			},
			messages: {
				price: {
					rangeCheck: "The price must be between 1 and 9999.99."
				},
				tax: {
					rangeCheck: "The tax must be between 1 and 9999.99.",
				},
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
				$(element).parent('.form-group').append(error[0]);
			}
		});

		function convert_text_to_slug() {
			var token = $('input[name="_token"]').val();
			$.ajax({
				headers: {
					'X-CSRF-Token': token
				},
				type: "POST",
				url: "{{ route('slug.create') }}",
				data: {
					title: $('#title').val()
				},
				global: false,
				success: function(data) {
					$('#slug').val(data.data);
				}
			});
		}

		$('#title').on('keyup', function() {
			convert_text_to_slug()
		});
	</script>
@endsection
