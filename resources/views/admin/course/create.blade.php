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
					action="{{ isset($data) ? route('course.update', ['course' => $data->id]) : route('course.store') }}"
					enctype="multipart/form-data">
					@csrf
					@if (isset($data))
						<input type="hidden" name="_method" value="put">
					@endif
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="category_id">Category</label>
									<select class="form-control select2 @error('category_id') is-invalid @enderror" name="category_id[]"
										id="category_id" multiple>
										@foreach ($categories as $category)
											<option value="{{ $category->id }}" @if (in_array(
													$category->id,
													old('category_id', isset($courseCategories) && !empty($courseCategories) ? $courseCategories : []))) selected @endif>{{ $category->name }}
											</option>
										@endforeach
									</select>
									@error('category_id')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="tag_id">Tags</label>
									<select class="form-control select2 @error('tag_id') is-invalid @enderror" name="tag_id[]" id="tag_id"
										multiple>
										@foreach ($tags as $tag)
											<option value="{{ $tag->id }}" @if (in_array($tag->id, old('tag_id', isset($courseTags) && !empty($courseTags) ? $courseTags : []))) selected @endif>{{ $tag->name }}
											</option>
										@endforeach
									</select>
									@error('tag_id')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
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
								<div class="form-group">
									<label for="quiz_id">Quiz</label>
									<select class="form-control select2 @error('quiz_id') is-invalid @enderror" name="quiz_id[]" id="quiz_id">
										<option value="" disabled selected>Select an option</option>
										@foreach ($quizzes as $quiz)
											<option value="{{ $quiz->id }}" @if (in_array($quiz->id, old('quiz_id', isset($courseQuizzes) && !empty($courseQuizzes) ? $courseQuizzes : []))) selected @endif>{{ $quiz->title }}
											</option>
										@endforeach
									</select>
									@error('quiz_id')
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
									<label for="image">Image</label>
									<input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image"
										accept="image/*">
									@error('image')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="title">Tax</label>
									<div class="form-group input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text">$</span>
										</div>
										<input type="number" class="form-control @error('tax') is-invalid @enderror" name="tax"
											aria-label="Amount (to the nearest dollar)" id="tax" placeholder="Tax"
											value="{{ old('tax', @$data->tax) ? old('tax', @$data->tax) : null }}">
										@error('tax')
											<span class="error invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
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
						@isset($data)
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="order">Order</label>
										<input type="number" name="order" class="form-control @error('order') is-invalid @enderror"
											id="order" placeholder="order" value="{{ old('order', @$data->order) }}">
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

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="seo_title">Seo Title</label>
									<input type="text" name="seo_title" class="form-control @error('seo_title') is-invalid @enderror"
										id="seo_title" placeholder="Seo Title" value="{{ old('seo_title', @$data->seo_title) }}">
									@error('seo_title')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="seo_description">Seo Description</label>
									<textarea id="seo_description" name="seo_description"
									 class="form-control @error('seo_description') is-invalid @enderror" placeholder="Seo Description">{{ old('seo_description', @$data->seo_description) }}</textarea>
									@error('seo_description')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary">{{ isset($data) ? 'Update' : 'Submit' }}</button>
						<a href="{{ route('course.index') }}" class="btn btn-default">Cancel</a>
					</div>
				</form>
			</div>

			@if (isset($data))
				<div class="card">
					<div class="card-header d-flex align-items-center">
						<h3 class="card-title">Lessons</h3>
						<div class="card-tools ml-auto">
							<a href="{{ route('lesson.create') }}" class="btn btn-primary">Add New</a>
						</div>
					</div>
					<div class="card-body">
						<table id="lessons-data-table" class="table">
							<thead>
								<tr>
									<th>Lesson</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			@endif
		</div>
	</section>
@endsection

@section('js')
	<!-- DataTables -->
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('js/jquery-impromptu.js') }}"></script>
	<script>
		CKEDITOR.replace(document.querySelector('#description'));
		CKEDITOR.config.extraPlugins = 'colorbutton';

		$.validator.addMethod("taxMinThanPrice", function(value, element) {
			if (value) {
				return parseFloat(value) < parseFloat($("#price").val());
			}
			return true;
		}, "Tax should be less than price.");

		$.validator.addMethod("rangeCheck", function(value, element) {
			if (value && value != 0) {
				return parseFloat(value) >= 1 && parseFloat(value) <= 9999.99;
			}
			return true;
		});

		$("#form-data").validate({
			ignore: [],
			rules: {
				"category_id[]": {
					required: true,
				},
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
				"quiz_id[]": {
					required: true
				},
				price: {
					required: true,
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

		@if (isset($data))
			let course_id = "{{ $data->id }}";
			const lessonsDataTable = $('#lessons-data-table').DataTable({
				lengthChange: false,
				language: {
					search: '',
					searchPlaceholder: "Search..."
				},
				responsive: window.screen.width < 1024,
				aaSorting: [],
				aoColumnDefs: [{
					bSortable: false,
					aTargets: [-1]
				}],
				ajax: {
					url: "{{ route('lesson.ajax') }}",
					data: {
						course_id: course_id,
					},
				},
				columns: [{
						data: 'title',
						className: 'all',
					},
					{
						data: 'action',
						className: 'all col-2 none',
						searchable: false,
						orderable: false
					},
				]
			});
			$('body').on('click', '.lesson-delete', function() {
				let url = $(this).attr('target-url');
				var id = $(this).data("id");
				var token = $('input[name="_token"]').val();
				$.prompt("Are you sure want to delete this record?", {
					title: "Are you sure?",
					buttons: {
						"No": false,
						"Yes": true
					},
					focus: 1,
					submit: function(e, v, m, f) {
						if (v) {
							e.preventDefault();
							$.ajax({
								headers: {
									'X-CSRF-Token': token
								},
								type: "DELETE",
								url: url,
								success: function(data) {
									if (data.status) {
										location.reload();
									}
								}
							});
						}
						$.prompt.close();
					}
				});
			});
		@endif

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
