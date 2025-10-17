@extends('admin.layouts.master')

@section('title', ucfirst(Str::singular($module)))

@section('css')
@endsection

@section('content')
	@include('admin.layouts.breadcrumb', [
		'module_title' => Str::singular((isset($video) ? 'Edit ' : 'Add new ') . $module),
	])

	<section class="content">
		<div class="container-fluid">
			<div class="card card-primary">
				<form id="form-data" role="form" method="post"
					action="{{ isset($video) ? route('video.update', $video) : route('video.store') }}"
					enctype="multipart/form-data">
					@csrf
					@if (isset($video))
						<input type="hidden" name="_method" value="put">
					@endif
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="title">Title</label>
									<input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title"
										placeholder="Title" value="{{ old('title', @$video->title) }}">
									@error('title')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="youtube_link">Youtube link</label>
									<input type="text" name="youtube_link" class="form-control @error('youtube_link') is-invalid @enderror" id="youtube_link"
										placeholder="Youtube link" value="{{ old('youtube_link', @$video->youtube_link) }}">
									@error('youtube_link')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="description">Description</label>
									<textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', @$video->description) }}</textarea>
									@error('description')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary">{{ isset($video) ? 'Update' : 'Submit' }}</button>
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
				youtube_link: {
					required: true,
					url: true
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

	</script>
@endsection
