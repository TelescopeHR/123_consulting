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
                <form id="form-data" method="post"
                    action="{{ isset($data) ? route('quiz.update', ['quiz' => $data->id]) : route('quiz.store') }}">
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
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug"
                                        class="form-control @error('slug') is-invalid @enderror" id="slug"
                                        placeholder="Slug"
                                        value="{{  old('slug', isset($data) && $data->slug_relation ? $data->slug_relation->slug : '') }}">
                                    @error('slug')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="passing_score">Quiz Certificate</label>
                                    <select name="certificate_id" id="certificate_id"
                                        class="form-control @error('certificate_id') is-invalid @enderror">
                                        <option selected readonly disabled>Select Certificate</option>
                                        @forelse ($certificates as $certificate)
                                            <option value="{{ $certificate->id }}"
                                                {{ old('certificate_id', @$data->certificate_id) == $certificate->id ? 'selected ' : null }}>
                                                {{ $certificate->title }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('passing_score')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="passing_score">Passing Score %</label>
                                    <input type="number" name="passing_score"
                                        class="form-control @error('passing_score') is-invalid @enderror" id="passing_score"
                                        placeholder="Passing Score"
                                        value="{{ old('passing_score', @$data->passing_score) }}">
                                    @error('passing_score')
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
                        <a href="{{ route('quiz.index') }}" class="btn btn-default">Cancel</a>
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
            rules: {
                title: {
                    required: true,
                    maxlength: 200
                },
                passing_score: {
                    required: true,
                    number: true,
                    min: 1,
                    max: 100
                },
                certificate_id: {
                    required: true,
                }
            },
            messages: {
                passing_score: {
                    min: "Passing score should be 1-100",
                    max: "Passing score should be 1-100"
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
