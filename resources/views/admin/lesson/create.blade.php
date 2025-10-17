@extends('admin.layouts.master')

@section('title', ucfirst(Str::singular($module)))

@section('css')
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', [
		'module_title' => Str::singular((isset($data) ? 'Edit ' : 'Add new ') . $module),
	])

	<section class="content">
		<div class="container-fluid">
			<div class="card card-primary">
				<form id="form-data" role="form" method="post"
					action="{{ isset($data) ? route('lesson.update', ['lesson' => $data->id]) : route('lesson.store') }}"
					enctype="multipart/form-data">
					@csrf
					@if (isset($data))
						<input type="hidden" name="_method" value="put">
					@endif
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="course_id">Course</label>
									<select class="form-control select2 @error('course_id') is-invalid @enderror" name="course_id" id="course_id">
										<option value="">Select option</option>
										@foreach ($courses as $course)
											<option value="{{ $course->id }}" @if ( old('course_id', @$data->course_id) == $course->id ) selected @endif>{{ $course->title }}
											</option>
										@endforeach
									</select>
									@error('course_id')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
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
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="video">Video URL</label>
									<input type="text" name="video" class="form-control @error('video') is-invalid @enderror" id="video"
										placeholder="Video" value="{{ old('video', @$data->video) }}">
									@error('video')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
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
						</div>
						@isset($data)
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="order">Order</label>
										<input type="number" name="order" class="form-control @error('order') is-invalid @enderror" id="order"
											placeholder="order" value="{{ old('order', @$data->order) }}">
										@error('order')
											<span class="error invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
						@endisset
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
						<a href="{{ url()->previous() }}" class="btn btn-default">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</section>

@endsection

@section('js')
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
	<script>
		CKEDITOR.replace(document.querySelector('#description'));
		CKEDITOR.config.extraPlugins = 'colorbutton';

		$.validator.addMethod('vimeo', function(value) {
			return /(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/.test(value);
		}, 'Please enter a valid vimeo url.');

		$("#form-data").validate({
			ignore: [],
			rules: {
				title: {
					required: true,
					maxlength: 200
				},
				description: {
					required: function() {
						CKEDITOR.instances.description.updateElement();
					},
					minlength: 10
				},
				course_id: {
					required: true
				},
				video: {
					required: true,
					url: true,
					vimeo: true,
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
