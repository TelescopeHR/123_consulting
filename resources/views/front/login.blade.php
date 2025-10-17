@extends('front.layouts.master')

@section('title', 'Login - 123 Consulting Solutions')

@section('css')
    <style>
        .input-group-text {
            border-radius: 0rem 0rem 0rem 0rem;
        }

        .passwordfield {
            border-radius: 0rem 0rem 0rem 0rem;
        }

        .google-btn-text {
            margin-top: 35px;
        }
    </style>
@endsection

@section('content')
    <section class="pagehead login-page section-spacing-top">
        <div class="container text-center">
            <h1 class="login-page-title section_heading">Login</h1>
            <p class="login-page-description">Login to your account now!</p>
        </div>
    </section>

    <section class=" section-login login-page section-spacing-bottom">
        <div class="container">
            <div class="accountform accountform-login">
                <div class="google-btn">
                    <div class="google-icon-wrapper">
                        <img class="google-icon-svg" src="{{ asset('front/images/googleicon.svg') }}" />
                    </div>
                    <a href="{{ route('googlewithlogin') }}" class="google-btn-text">{{ __('Continue with Google') }}</a>
                </div>

                <div class="formdivider">
                    <span>Or</span>
                </div>
                <form method="POST" action="{{ route('login') }}" id="form-data">
                    @csrf
                    <div class="row">
                        <div class="formgroup">
                            <input type="text" class="inputfield @error('email') is-invalid @enderror @error('username') is-invalid @enderror" name="email"
                                id="email" placeholder="Username / Email *" value="{{ old('email') }}" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="formgroup">
                            <div class="d-flex">
                                <input type="password" name="password" id="password"
                                    class="inputfield passwordfield @error('password') is-invalid @enderror"
                                    placeholder="Password *" />
                                <div class="input-group-append d-flex">
                                    <span class="input-group-text">
                                        <a href="#" class="toggle_hide_password">
                                            <i class="fas fa-eye-slash" aria-hidden="true">
                                                <svg class="eye-icon-pass-hide" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M19.8822 4.88109L19.1463 4.14515C18.9383 3.93716 18.5543 3.96917 18.3143 4.25711L15.7541 6.80108C14.602 6.30514 13.3382 6.06514 12.0101 6.06514C8.05798 6.08107 4.6342 8.38504 2.98608 11.6973C2.89006 11.9052 2.89006 12.1612 2.98608 12.3372C3.75402 13.9052 4.90609 15.2012 6.34609 16.1772L4.2501 18.3051C4.0101 18.5451 3.97809 18.9291 4.13813 19.1371L4.87408 19.8731C5.08207 20.081 5.46606 20.049 5.70606 19.7611L19.754 5.71321C20.058 5.47334 20.09 5.08938 19.882 4.88137L19.8822 4.88109ZM12.8581 9.71298C12.5861 9.64896 12.2981 9.56901 12.0261 9.56901C10.6661 9.56901 9.57818 10.657 9.57818 12.0169C9.57818 12.2889 9.64219 12.5769 9.72215 12.8489L8.65003 13.9049C8.33008 13.345 8.15409 12.7209 8.15409 12.017C8.15409 9.88899 9.86611 8.17697 11.9941 8.17697C12.6982 8.17697 13.3221 8.35295 13.8821 8.67291L12.8581 9.71298Z" fill="#f36522"/><path d="M21.0347 11.6974C20.4747 10.5774 19.7386 9.56945 18.8267 8.75342L15.8507 11.6974V12.0174C15.8507 14.1454 14.1387 15.8574 12.0107 15.8574H11.6907L9.80273 17.7454C10.5068 17.8893 11.2427 17.9854 11.9627 17.9854C15.9149 17.9854 19.3386 15.6814 20.9868 12.3532C21.1307 12.1292 21.1307 11.9053 21.0347 11.6973L21.0347 11.6974Z" fill="#f36522"/></svg>
                                                <svg class="eye-icon-pass-show" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 25 25" fill="none"><g clip-path="url(#clip0_56329_41138)"><path d="M23.9978 12.288C23.965 12.214 23.1709 10.4524 21.4056 8.68711C19.0534 6.33492 16.0825 5.0918 12.8125 5.0918C9.54249 5.0918 6.57155 6.33492 4.21937 8.68711C2.45405 10.4524 1.65624 12.2168 1.62718 12.288C1.58453 12.384 1.5625 12.4878 1.5625 12.5927C1.5625 12.6977 1.58453 12.8015 1.62718 12.8974C1.65999 12.9715 2.45405 14.7321 4.21937 16.4974C6.57155 18.8487 9.54249 20.0918 12.8125 20.0918C16.0825 20.0918 19.0534 18.8487 21.4056 16.4974C23.1709 14.7321 23.965 12.9715 23.9978 12.8974C24.0404 12.8015 24.0625 12.6977 24.0625 12.5927C24.0625 12.4878 24.0404 12.384 23.9978 12.288ZM12.8125 16.3418C12.0708 16.3418 11.3458 16.1219 10.7291 15.7098C10.1124 15.2978 9.63177 14.7121 9.34794 14.0269C9.06411 13.3416 8.98985 12.5876 9.13455 11.8602C9.27924 11.1328 9.63639 10.4646 10.1608 9.94015C10.6853 9.4157 11.3535 9.05855 12.0809 8.91385C12.8083 8.76916 13.5623 8.84342 14.2476 9.12725C14.9328 9.41108 15.5184 9.89172 15.9305 10.5084C16.3426 11.1251 16.5625 11.8501 16.5625 12.5918C16.5625 13.5864 16.1674 14.5402 15.4641 15.2434C14.7609 15.9467 13.8071 16.3418 12.8125 16.3418Z" fill="#f36522"/></g><defs><clipPath id="clip0_56329_41138"><rect width="24" height="24" fill="white" transform="translate(0.8125 0.591797)"/></clipPath></defs></svg>
                                            </i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="forgotpass">
                            <a href="{{ route('front.forgot-password') }}" class="forgot-password"
                                title="Forgot Password?">Forgot Password?</a>
                        </div>

                        <div class="formgroup">
                            <input type="submit" name="submit" class="bttn button-primary login-form-submit-button w-100" value="Login" required />
                        </div>
                    </div>
                </form>
                <div class="formaltlink-block">Don't have an account? <a class="formaltlink"
                        href="{{ route('front.register') }}">Sign up</a></div>
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
                password: {
                    required: true,
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
                } else if ($(element).hasClass('passwordfield')) {

                    $(element).parent().parent('.formgroup').append(error[0]);
                } else {
                    $(element).parent().append(error[0]);
                }
            }
        });

        $(document).ready(function() {
            $(".toggle_hide_password").on('click', function(e) {
                e.preventDefault()

                var input_group = $(this).closest('.formgroup')
                var input = input_group.find('input.passwordfield')
                var icon = input_group.find('i')
                input.attr('type', input.attr("type") === "text" ? 'password' : 'text')
                icon.toggleClass('fa-eye-slash fa-eye')
            })
        })
    </script>
@endsection
