@extends('admin.layouts.master')

@section('title', ucfirst(Str::singular($module)))

@section('css')
@endsection

@section('content')
    @include('admin.layouts.breadcrumb', ['module_title' => ucfirst(Str::singular($module))])

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form id="form-data" role="form" method="post" action="{{ route('setting.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h4>Stripe Settings</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile">Stripe Enviroment</label>
                                    <select class="form-control @error('stripe_enviroment') is-invalid @enderror"
                                        name="stripe_enviroment" id="stripeenv">
                                        <option value="" selected disabled>Select Enviroment
                                        </option>
                                        <option value="test"
                                            {{ old('stripe_enviroment', get_setting_value('stripe_enviroment')) == 'test' ? 'selected' : '' }}>
                                            Test</option>
                                        <option value="live"
                                            {{ old('stripe_enviroment', get_setting_value('stripe_enviroment')) == 'live' ? 'selected' : '' }}>
                                            Live</option>
                                    </select>
                                    @error('stripe_enviroment')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Publishable key</label>
                                    <input type="text" name="publishable_key"
                                        class="form-control @error('publishable_key') is-invalid @enderror" id="publishkey"
                                        placeholder="Publishable key"
                                        value="{{ old('publishable_key', get_setting_value('publishable_key')) }}">
                                    @error('publishable_key')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Stripe Key</label>
                                    <input type="text" name="stripe_key"
                                        class="form-control @error('stripe_key') is-invalid @enderror" id="stripekey"
                                        placeholder="Enter Stripe key"
                                        value="{{ old('stripe_key', get_setting_value('stripe_key')) }}">
                                    @error('stripe_key')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>SMTP Settings</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mailer">Mailer</label>
                                    <input type="text" name="mailer"
                                        class="form-control @error('mailer') is-invalid @enderror" id="mailer"
                                        placeholder="Mailer" value="{{ old('mailer', get_setting_value('mailer')) }}">
                                    @error('mailer')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_host">Mail Host</label>
                                    <input type="text" name="mail_host"
                                        class="form-control @error('mail_host') is-invalid @enderror" id="mail_host"
                                        placeholder="Mail Host"
                                        value="{{ old('mail_host', get_setting_value('mail_host')) }}">
                                    @error('mail_host')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_port">Mail Port</label>
                                    <input type="text" name="mail_port"
                                        class="form-control @error('mail_port') is-invalid @enderror" id="mail_port"
                                        placeholder="Mail port"
                                        value="{{ old('mail_port', get_setting_value('mail_port')) }}">
                                    @error('mail_port')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_encryption">Encription</label>
                                    <select class="form-control @error('mail_encryption') is-invalid @enderror"
                                        name="mail_encryption" id="mail_encryption"
                                        value="{{ old('mail_encryption', get_setting_value('mail_encryption')) }}">
                                        <option value="{{ old('mail_encryption') }}" selected disabled>Select Encription
                                        </option>
                                        <option value="ssl"
                                            {{ old('mail_encryption', get_setting_value('mail_encryption')) == 'ssl' ? 'selected' : '' }}>
                                            SSL</option>
                                        <option value="tls"
                                            {{ old('mail_encryption', get_setting_value('mail_encryption')) == 'tls' ? 'selected' : '' }}>
                                            TLS</option>
                                        <option value="auto"
                                            {{ old('mail_encryption', get_setting_value('mail_encryption')) == 'auto' ? 'selected' : '' }}>
                                            Auto</option>
                                    </select>
                                    @error('mail_encryption')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror" id="username"
                                        placeholder="Username"
                                        value="{{ old('username', get_setting_value('username')) }}">
                                    @error('username')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Password</label>
                                    <input type="text" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        placeholder="Password"
                                        value="{{ old('password', get_setting_value('password')) }}">
                                    @error('password')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_address">Mail Adrress</label>
                                    <input type="email" name="mail_address"
                                        class="form-control @error('mail_address') is-invalid @enderror" id="mail_address"
                                        placeholder="Mail Address"
                                        value="{{ old('mail_address', get_setting_value('mail_address')) }}">
                                    @error('mail_address')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="youtube_link">Mailer Name</label>
                                    <input type="text" name="mailer_name"
                                        class="form-control @error('mailer_name') is-invalid @enderror" id="mailer_name"
                                        placeholder="Mailer Name"
                                        value="{{ old('mailer_name', get_setting_value('mailer_name')) }}">
                                    @error('mailer_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>

                        <h4>Social Media Links</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="facebook_link">Facebook</label>
                                    <input type="text" name="facebook_link"
                                        class="form-control @error('facebook_link') is-invalid @enderror" id="facebook_link"
                                        placeholder="Facebook"
                                        value="{{ old('facebook_link', get_setting_value('facebook_link')) }}">
                                    @error('facebook_link')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="twitter_link">Twitter</label>
                                    <input type="text" name="twitter_link"
                                        class="form-control @error('twitter_link') is-invalid @enderror" id="twitter_link"
                                        placeholder="Twitter"
                                        value="{{ old('twitter_link', get_setting_value('twitter_link')) }}">
                                    @error('twitter_link')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instagram_link">Instagram</label>
                                    <input type="text" name="instagram_link"
                                        class="form-control @error('instagram_link') is-invalid @enderror" id="instagram_link"
                                        placeholder="Instagram"
                                        value="{{ old('instagram_link', get_setting_value('instagram_link')) }}">
                                    @error('instagram_link')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin_link">Linkedin</label>
                                    <input type="text" name="linkedin_link"
                                        class="form-control @error('linkedin_link') is-invalid @enderror" id="linkedin_link"
                                        placeholder="Linkedin"
                                        value="{{ old('linkedin_link', get_setting_value('linkedin_link')) }}">
                                    @error('linkedin_link')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="youtube_link">Youtube</label>
                                    <input type="text" name="youtube_link"
                                        class="form-control @error('youtube_link') is-invalid @enderror" id="youtube_link"
                                        placeholder="Youtube"
                                        value="{{ old('youtube_link', get_setting_value('youtube_link')) }}">
                                    @error('youtube_link')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>

                        <h4>Google Login Settings</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="google_clientid">Google Client Id</label>
                                    <input type="text" name="google_clientid"
                                        class="form-control @error('google_clientid') is-invalid @enderror"
                                        id="google_clientid" placeholder="Google Client Id"
                                        value="{{ old('google_clientid', get_setting_value('google_clientid')) }}">
                                    @error('google_clientid')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="google_secret">Google Client Secret</label>
                                    <input type="text" name="google_secret"
                                        class="form-control @error('google_secret') is-invalid @enderror"
                                        id="google_secret" placeholder="Google Client Secret"
                                        value="{{ old('google_secret', get_setting_value('google_secret')) }}">
                                    @error('google_secret')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>Google-recaptch Settings</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="google_clientid">Google Recaptcha Key</label>
                                    <input type="text" name="g_recaptcha_key"
                                        class="form-control  @error('g-recaptcha-key') is-invalid @enderror"
                                        id="g-recaptcha-key" placeholder="G-recaptch key"
                                        value="{{ old('g_recaptcha_key', get_setting_value('g_recaptcha_key')) }}">
                                    @error('g-recaptcha-key')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="google_clientid">Google Recaptcha Secret</label>
                                    <input type="text" name="g_recaptcha_secret"
                                        class="form-control  @error('g-recaptcha-secret') is-invalid @enderror"
                                        id="g-recaptcha-secret" placeholder="G-recaptcha Secret"
                                        value="{{ old('g_recaptcha_secret', get_setting_value('g_recaptcha_secret')) }}">
                                    @error('g-recaptcha-secret')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Upload Logo</h4><br>
                                <div class="form-group">
                                    <input type="file" name="logo"
                                        class="form-control @error('logo') is-invalid @enderror" />
                                    @if (get_setting_value('logo') && file_exists(public_path('images/settings/' . get_setting_value('logo'))))
                                        <img src="{{ asset('images/settings/' . get_setting_value('logo')) }}"
                                            class="img-thumbnail mt-2" width="200">
                                    @endif
                                    @error('logo')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h4>Favicon icon</h4><br>
                                <div class="form-group">
                                    <input type="file" name="faviconicon"
                                        class="form-control @error('faviconicon') is-invalid @enderror" />
                                    @if (get_setting_value('faviconicon') &&
                                        file_exists(public_path('images/settings/' . get_setting_value('faviconicon'))))
                                        <img src="{{ asset('images/settings/' . get_setting_value('faviconicon')) }}"
                                            class="img-thumbnail mt-2" width="200">
                                    @endif
                                    @error('faviconicon')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/recaptcha.js') }}" async defer></script>
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        $("#form-data").validate({
            rules: {

                stripe_enviroment: {
                    required: function(element) {
                        return $("#publishkey").val() != '' || $("#stripekey").val() != '';
                    }
                },
                publishable_key: {
                    required: function(element) {
                        return $("#stripeenv").val() != null || $("#stripekey").val() != '';
                    }
                },
                stripe_key: {
                    required: function(element) {
                        return $("#publishkey").val() != '' || $("#stripeenv").val() != null;
                    }
                },
                mailer: {
                    required: function(element) {
                        return $("#mail_host").val() != '' || $("#mail_port").val() != '' || $(
                                "#mail_encryption")
                            .val() != null || $("#username").val() != '' || $("#password").val() != '' || $(
                                "#mail_address").val() != '' || $("#mailer_name").val() != '';
                    }
                },
                mail_host: {
                    required: function(element) {
                        return $("#mailer").val() != '' || $("#mail_port").val() != '' || $("#mail_encryption")
                            .val() != null || $("#username").val() != '' || $("#password").val() != '' || $(
                                "#mail_address").val() != '' || $("#mailer_name").val() != '';
                    }
                },
                mail_port: {
                    required: function(element) {
                        return $("#mail_host").val() != '' || $("#mailer").val() != '' || $("#mail_encryption")
                            .val() != null || $("#username").val() != '' || $("#password").val() != '' || $(
                                "#mail_address").val() != '' || $("#mailer_name").val() != '';
                    }
                },
                mail_encryption: {
                    required: function(element) {
                        return $("#mail_host").val() != '' || $("#mail_port").val() != '' || $("#mailer")
                            .val() != '' || $("#username").val() != '' || $("#password").val() != '' || $(
                                "#mail_address").val() != '' || $("#mailer_name").val() != '';
                    }
                },
                username: {
                    required: function(element) {
                        return $("#mail_host").val() != '' || $("#mail_port").val() != '' || $(
                                "#mail_encryption")
                            .val() != null || $("#mailer").val() != '' || $("#password").val() != '' || $(
                                "#mail_address").val() != '' || $("#mailer_name").val() != '';
                    }
                },
                password: {
                    required: function(element) {
                        return $("#mail_host").val() != '' || $("#mail_port").val() != '' || $(
                                "#mail_encryption")
                            .val() != null || $("#username").val() != '' || $("#mailer").val() != '' || $(
                                "#mail_address").val() != '' || $("#mailer_name").val() != '';
                    }
                },
                mail_address: {
                    required: function(element) {
                        return $("#mail_host").val() != '' || $("#mail_port").val() != '' || $(
                                "#mail_encryption")
                            .val() != null || $("#username").val() != '' || $("#password").val() != '' || $(
                                "#mailer").val() != '' || $("#mailer_name").val() != '';
                    }
                },
                mailer_name: {
                    required: function(element) {
                        return $("#mail_host").val() != '' || $("#mail_port").val() != '' || $(
                                "#mail_encryption")
                            .val() != null || $("#username").val() != '' || $("#password").val() != '' || $(
                                "#mail_address").val() != '' || $("#mailer").val() != '';
                    }
                },
                google_clientid: {
                    required: function(element) {
                        return $("#google_secret").val() != '';
                    }
                },
                google_secret: {
                    required: function(element) {
                        return $("#google_clientid").val() != '';
                    }
                },
                g_recaptcha_key: {
                    required: function(element) {
                        return $("#g-recaptcha-secret").val() != '';
                    }
                },
                g_recaptcha_secret: {
                    required: function(element) {
                        return $("#g-recaptcha-key").val() != '';
                    }
                },
                facebook_link:{
                    url: true
                },
                twitter_link:{
                    url: true
                },
                instagram_link:{
                    url: true
                },
                linkedin_link:{
                    url: true
                },
                youtube_link:{
                    url: true
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
    </script>
@endsection
