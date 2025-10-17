@extends('front.layouts.master')

@section('title', 'ForgotPassword - 123 Consulting Solutions')

@section('content')
    <section class="pagehead forgot-password-page section-spacing-top">
        <div class="container text-center">
            <h1 class="forgot-password-page-title section_heading">Forgot Password</h1>
            <p class="forgot-password-page-description">Reset your password here!</p>
        </div>
    </section>

    <section class=" section-forgot forgot-password-page section-spacing-bottom">
        <div class="container">
            <div class="accountform accountform-forgot">
                <h2 class="lost-password-sub-title text-center">Lost your password?</h2>
                <p class="lost-password-sub-des text-center">Please enter your username or email address. You will receive a link to
                    create a new password via email.</p>

                <form method="POST" id="form-data" action="{{ route('password.email') }}">
                    @csrf
                    <div class="row">
                        <div class="formgroup">
                            <input type="text" name="email" class="inputfield @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="Username / Email *" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="formgroup">
                            <input type="submit" name="submit" class="bttn button-primary forgot-password-page-form-submit-button w-100" value="Reset Password"
                                required />
                        </div>
                    </div>
                </form>

                <div class="formaltlink-block">Go back to <a class="formaltlink"
                        href="{{ route('login') }}">Login</a></div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script>
        $("#form-data").validate({
            rules: {
                email: {
                    required: true
                },
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback',
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function(error, element) {
                if ($(element).hasClass('form-check-input')) {
                    $(element).parent().parent().append(error[0]);
                } else {
                    $(element).parent().append(error[0]);
                }
            }
        });
    </script>
@endsection
