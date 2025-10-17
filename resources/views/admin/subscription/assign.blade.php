@extends('admin.layouts.master')

@section('title', "Assign Course")

@section('css')
@endsection

@section('content')
    @include('admin.layouts.breadcrumb', ['module_title' => "Assign Course <strong>$course->title</strong> to caregivers"])

	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <form id="course-form" method="post" action="{{ route('user.assign.course', ['user_id' => $user_id]) }}">
                    @csrf
                    <input type="hidden" name="course" value="{{ $course->id }}" />
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ $course->full_image }}" class="img-responsive img-thumbnail"/>
                                </div>
                                <div class="col-md-9 dynamic-name-list">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary mt-2" id="add-user">Add More Caregiver</a>
                                    @php
                                        $old_names = old('name');
                                        $selected_course = old('course') ? App\Models\Course::whereId(old('course'))->first() : [];
                                    @endphp
                                    @if (!empty($old_names))
                                        @forelse ($old_names as $key_name => $old_name)
                                            <div class="row mt-2">
                                                <div class="col-md-3 pt-1">
                                                    <input type="text" name="name[{{ $key_name }}][first_name]"
                                                        class="form-control name_validation @error('name.' . $key_name . '.first_name') is-invalid @enderror"
                                                        placeholder="First Name" data-title="First Name" value="{{ $old_name['first_name'] }}" />
                                                    @error('name.' . $key_name . '.first_name')
                                                        <span class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 pt-1">
                                                    <input type="text" name="name[{{ $key_name }}][last_name]"
                                                        class="form-control name_validation @error('name.' . $key_name . '.last_name') is-invalid @enderror"
                                                        placeholder="Last Name" data-title="Last Name" value="{{ $old_name['last_name'] }}" />
                                                    @error('name.' . $key_name . '.last_name')
                                                        <span class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 pt-1">
                                                    <input type="email" name="name[{{ $key_name }}][email]"
                                                        class="form-control name_validation @error('name.' . $key_name . '.email') is-invalid @enderror"
                                                        placeholder="Email" data-title="Email" value="{{ $old_name['email'] }}" />
                                                    @error('name.' . $key_name . '.email')
                                                        <span class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 pt-1">
                                                    <a href="javascript:void(0)" class="btn btn-danger remove-user"><i class="fa fa-minus"></i></a>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script>
    $(document).on('click', '#add-user', function() {
        loadUserList();
    });

    $(document).on('click', '.remove-user', function() {
        let row = $(`[class*="dynamic-name-list"]`).find('.row').length;
        if (row > 1) {
            $(this).parent().parent('.row').remove();
        }
    });

    loadUserList();
    function loadUserList() {
        var token = $('meta[name="csrf-token"]').attr('content');
        var url = "{{ route('user.list.page') }}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            type: "POST",
            url: url,
            global: false,
            success: function(data) {
                $('.dynamic-name-list').append(data);

                $.each($("input.name_validation"), function(indexOfElement, formElement) {
                    let field_title = $(formElement).data('title');
                    if ($(formElement).attr('type') == 'email') {
                        $(formElement).rules("add", {
                            required: true,
                            messages: {
                                required: field_title + ' is required.'
                            }
                        });
                    }
                    if ($(formElement).attr('type') == 'email') {
                        $(formElement).rules("add", {
                            email: true,
                            unique: true,
                        });
                    }
                });
            }
        });
    }

    $.validator.addMethod("unique", function(value, element) {
        let timeRepeated = 0;
        if (value != '') {
            $($(element).closest('.dynamic-name-list').find('[type=email]')).each(function() {
                if ($(this).val() === value) {
                    timeRepeated++;
                }
            });
        }
        return timeRepeated === 1 || timeRepeated === 0;

    }, "Enter unique email.");

    $("#course-form").validate({
        ignore: [],
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
            $(error[0]).insertAfter(element);
        },
    });
</script>
@endsection
