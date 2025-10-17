@extends('admin.layouts.master')

@section('title', ucfirst(Str::singular($module)))

@section('css')
    <link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('admin.layouts.breadcrumb', ['module_title' => Str::singular((isset($data) ? 'Edit ' : 'Add new ') . $module)])

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form id="form-data" role="form" method="post"
                    action="{{ isset($data) ? route('question.update', ['question' => $data->id]) : route('question.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if (isset($data))
                        <input type="hidden" name="_method" value="put">
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quiz_id">Quiz</label>
                                    <select class="form-control select2 @error('quiz_id') is-invalid @enderror" name="quiz_id" id="quiz_id">
                                        <option value="">Select options</option>
                                        @foreach($quizzes as $quiz)
                                            <option value="{{ $quiz->id }}" @if( old('quiz_id', @$data->quiz_id) == $quiz->id) selected @endif>{{ $quiz->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('quiz_id')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="answer_type">Answer Type</label>
                                    <select class="form-control select2 @error('answer_type') is-invalid @enderror" name="answer_type" id="answer_type">
                                        <option value="">Select options</option>
                                        <option value="1" @if( old('answer_type', @$data->answer_type) == 1) selected @endif>Single</option>
                                        <option value="2" @if( old('answer_type', @$data->answer_type) == 2) selected @endif>Multiple</option>
                                    </select>
                                    @error('answer_type')
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
                        </div>

                        <hr>
                        <h3>Answers</h3>
                        <div class="row">
                            @if (isset($data) && count($data->answers))
                                <input type="hidden" name="answer[]">
                                @foreach ($data->answers as $key => $answer)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="oldanswer[{{ $answer->id }}]" class="form-control @error('answer') is-invalid @enderror" placeholder="Answer" value="{{ $answer->title }}">
                                            @error('answer')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input answer-is-true" name="oldis_true[{{ $answer->id }}]" id="oldis_true{{ $answer->id }}" value="1" {{ $answer->is_true ? 'checked' : '' }}>
                                            <label for="oldis_true{{ $answer->id }}" class="custom-control-label">Correct Answer</label>
                                        </div>
                                    </div>
                                    @if ($key)
                                        <div class="col-md-2">
                                            <a href="javascript:void(0)" id="delete-answer-btn" class="btn btn-danger delete" data-id="{{ $answer->id }}"  target-url="{{ route('answer.destroy', ['answer' => $answer->id]) }}" title="Delete Answer">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    @else
                                        <div class="col-md-2">
                                            <a href="javascript:void(0)" id="delete-answer-btn" class="btn btn-danger delete" data-id="{{ $answer->id }}" target-url="{{ route('answer.destroy', ['answer' => $answer->id]) }}" title="Delete Answer">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <a href="javascript:void(0)" id="add-more-btn" class="btn btn-primary" title="Add More Answer">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="answer[]" class="form-control @error('answer') is-invalid @enderror" placeholder="Answer" value="">
                                        @error('answer')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input answer-is-true" name="is_true[0]" id="is_true0" value="1">
                                        <label for="is_true0" class="custom-control-label">Correct Answer</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a href="javascript:void(0)" id="add-more-btn" class="btn btn-primary">
                                        <i class="fa fa-plus-square"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div id="dynamic_field"></div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-2 checkboxerror"></div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit"
                            class="btn btn-primary">{{ isset($data) ? 'Update' : 'Submit' }}</button>
                        <a href="{{ route('question.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/jquery-impromptu.js') }}"></script>
    <script>
        $("#form-data").validate({
            rules: {
                quiz_id: {required: true},
                title: {
                    required: true,
                    maxlength: 200
                },
                answer_type: {required: true},
                "answer[]": {required: true}
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback',
            highlight: function(element, errorClass, validClass) {
                if ($(element).hasClass('select2')) {
                    $(element).next('.select2-container').addClass('is-invalid');
                } else {
                    if(!$(element).hasClass('answer-is-true')){
                        $(element).addClass('is-invalid');
                    }
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
                if ($(element).hasClass('answer-is-true')) {
                    $(".checkboxerror").append(error[0]);
                }else{
                    $(element).parent('.form-group').append(error[0]);
                }
            }
        });

        let i = 1;
        $.validator.addMethod('atLeastOneChecked', function(value, element) {
            return ($('.answer-is-true:checked').length > 0);
        }, "Select at-least one correct answer.");

        $(".answer-is-true").rules("add", { 
            atLeastOneChecked:true,  
        });

        $('#add-more-btn').click(function() {
            $('#dynamic_field').append(`
            <div class="row" id="answer-div-${i}">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="answer[]" class="form-control @error('answer') is-invalid @enderror" placeholder="Answer" value="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input answer-is-true" name="is_true[${i}]" id="is_true${i}" value="1">
                        <label for="is_true${i}" class="custom-control-label">Correct Answer</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="javascript:void(0)" class="btn btn-danger btn_remove" id="${i}" title="Remove Answer">
                        <i class="fa fa-minus"></i>
                    </a>
                </div>
            </div>`);
            i++;

            $(".answer-is-true").rules("add", { 
                atLeastOneChecked:true,  
            });
        });

        $(document).on("change", ".answer-is-true", function(e){
            let checkedCounts = $('.answer-is-true:checked').length;
            if(checkedCounts > 1){
                $('[name="answer_type"]').val("2").change();
            }else{
                $('[name="answer_type"]').val("1").change();
            }
            $('.answer-is-true').valid();
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#answer-div-' + button_id).remove();
        });

        $('body').on('click', '.delete', function() {
            var id = $(this).data("id");
            var token = $('input[name="_token"]').val();
            let url = $(this).attr('target-url');
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
    </script>
@endsection
