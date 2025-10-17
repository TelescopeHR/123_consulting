@extends('admin.layouts.master')

@section('title', ucfirst(Str::singular($module)))

@section('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    @include('admin.layouts.breadcrumb', [
        'module_title' => ucfirst(isset($data) ? 'Edit page' : 'Add new page'),
    ])

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form id="form-data" role="form" method="post"
                    action="{{ isset($data) ? route('cms-page.update', ['cms_page' => $data->id]) : route('cms-page.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($data))
                        <input type="hidden" name="_method" value="put">
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        placeholder="Name" value="{{ old('name', @$data->name) }}">
                                    @error('name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug"
                                        class="form-control @error('slug') is-invalid @enderror" id="slug"
                                        placeholder="Slug"
                                        value="{{ old('slug', @$data->slug_relation ? @$data->slug_relation->slug : '') }}">
                                    @error('slug')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="page_content">Page Content</label>
                                    <textarea id="page_content" name="page_content" class="form-control @error('page_content') is-invalid @enderror">{{ old('page_content', @$data->page_content) }}</textarea>
                                    @error('page_content')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="meta_name">Meta Keywords</label>
									<input type="text" name="meta_name"
										class="form-control @error('meta_name') is-invalid @enderror" id="meta_name"
										placeholder="Meta Keywords"
										value="{{ old('meta_name', @$data->meta_name) }}">
									@error('meta_name')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="meta_title">Meta Title</label>
									<input type="text" name="meta_title"
										class="form-control @error('meta_title') is-invalid @enderror"
										id="meta_title" placeholder="Meta Title"
										value="{{ old('meta_title', @$data->meta_title) }}">
									@error('meta_title')
										<span class="error invalid-feedback">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>

						<div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea id="meta_description" name="meta_description"
                                        class="form-control @error('meta_description') is-invalid @enderror" placeholder="Meta Description">{{ old('meta_description', @$data->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Update' : 'Submit' }}</button>
                        <a href="{{ route('cms-page.index') }}" class="btn btn-default">Cancel</a>
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
        CKEDITOR.replace(document.querySelector('#page_content'));
        CKEDITOR.config.extraPlugins = 'colorbutton';

        $(document).on("change", "#type", function() {
            if ($("#value").val().length) {
                $("#value").valid();
            }
        });

        $("#form-data").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 150
                },
                page_content: {
                    required: function() {
                        CKEDITOR.instances.page_content.updateElement();
                    },
                    minlength: 10
                },
                meta_title: {
                    required: true,
                    maxlength: 150
                },
                meta_name: {
                    required: true,
                    maxlength: 150
                },
                meta_description: {
                    required: true,
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
                $(element).closest('.form-group').append(error[0]);
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
                    title: $('#name').val()
                },
                global: false,
                success: function(data) {
                    $('#slug').val(data.data);
                }
            });
        }

        $('#name').on('keyup', function() {
            convert_text_to_slug()
        });
    </script>
@endsection
