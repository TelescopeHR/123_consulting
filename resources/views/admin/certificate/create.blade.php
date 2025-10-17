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
                    action="{{ isset($data) ? route('certificate.update', ['certificate' => $data->id]) : route('certificate.store') }}"
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
                                    <label for="image">Image</label>
                                    <input type="file" name="image"
                                        class="form-control @error('image') is-invalid @enderror" id="image"
                                        src="{{ asset('images/certificate/') }}" class="img-thumbnail">
                                    @error('image')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Line 1</label>
                                    <input type="text" name="line1"
                                        class="form-control @error('line1') is-invalid @enderror" id="line1"
                                        placeholder="Has successfully completed the course"
                                        value="{{ old('line1', @$data->line1) }}">
                                    @error('line1')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Line 2</label>
                                    <input type="text" name="line2"
                                        class="form-control @error('line2') is-invalid @enderror" id="line2"
                                        placeholder="And has been awarded"
                                        value="{{ old('line2', @$data->line2) }}">
                                    @error('line2')
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
                        <a href="{{ route('certificate.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/ckeditor5.js') }}"></script>
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace(document.querySelector('#description'));
        CKEDITOR.config.extraPlugins = 'colorbutton';

        let required = true;
        @if (isset($data))
            required = false;
        @endif
        $("#form-data").validate({
            ignore: [],
            rules: {
                title: {
                    required: true,
                },
                description: {
                    required: function() {
                        CKEDITOR.instances.description.updateElement();
                    },
                    minlength: 100,
                    maxlength: 800,
                },
                line1: {
                    required: true,
                },
                line2: {
                    required: true,
                },
                image: {
                    required: required
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
