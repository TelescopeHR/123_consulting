@extends('admin.layouts.master')

@section('title', ucfirst(Str::singular($module)))

@section('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <style>
        .ck-editor__editable {
            height: 500px;
        }
    </style>
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
                    action="{{ isset($data) ? route('blog.update', ['blog' => $data->id]) : route('blog.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if (isset($data))
                        <input type="hidden" name="_method" value="put">
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control select2 @error('category_id') is-invalid @enderror" name="category_id[]" id="category_id" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if(in_array($category->id, old('category_id', isset($blogCategories) && !empty($blogCategories) ? $blogCategories : [] ))) selected @endif>{{ $category->name }}</option>
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
                                    <select class="form-control select2 @error('tag_id') is-invalid @enderror" name="tag_id[]" id="tag_id" multiple>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}" @if(in_array($tag->id, old('tag_id', isset($blogTags) && !empty($blogTags) ? $blogTags : [] ))) selected @endif>{{ $tag->name }}</option>
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
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror" id="title"
                                        placeholder="Title" value="{{ old('title', @$data->title) }}">
                                    @error('title')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug"
                                        class="form-control @error('slug') is-invalid @enderror" id="slug"
                                        placeholder="Slug" value="{{ old('slug', @$data->slug_relation->slug) }}">
                                    @error('slug')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image"
                                        class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*">
                                    @error('image')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="author_name">Author Name</label>
                                    <input type="text" name="author_name"
                                        class="form-control @error('author_name') is-invalid @enderror" id="author_name"
                                        placeholder="Author Name" value="{{ old('author_name', @$data->author_name) }}">
                                    @error('author_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="publish_date">Publish Date</label>
                                    <input type="text" name="publish_date"
                                        class="form-control @error('publish_date') is-invalid @enderror" id="publish_date"
                                        placeholder="MM/DD/YYYY" value="{{ old('publish_date', isset($data) && $data->publish_date ? $data->publish_date->format('m/d/Y') : '') }}">
                                    @error('publish_date')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-md-6">
								<div class="custom-control custom-checkbox form-group">
									<input type="checkbox" class="custom-control-input" name="is_premium" id="is_premium" value="1"
										{{ old('is_premium', @$data->is_premium) ? 'checked' : '' }}>
									<label for="is_premium" class="custom-control-label">Is Featured Posts?</label>
									@error('is_premium')
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
                                    <span class="text-muted">Use code like this: [media-id=sde0fb title='click here']</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit"
                            class="btn btn-primary">{{ isset($data) ? 'Update' : 'Submit' }}</button>
                        <a href="{{ route('blog.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/jquery-impromptu.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#description',
            plugins: ["media","code", "image"]
        });

        $("#form-data").validate({
            ignore: [],
            rules: {
				"category_id[]":{
					required: true,
				},
                title: {
                    required: true,
                    maxlength: 100
                },
				description: {
					required: true,
					minlength: 10
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

        $("#publish_date").datepicker({
            format: 'mm/dd/yyyy',
			autoclose: true
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
