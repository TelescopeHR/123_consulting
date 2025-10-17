@extends('front.layouts.master')

@section('title', 'Profile')

@section('css')
    <link href="{{ asset('css/bootstrap-myprofile.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!--Inner Page Head-->
    <input type="hidden" name="csrf-token" content="{{ csrf_token() }}">

    <!--content -->
    <section class="section innerfirst ">
        <div class="container" style="width: 100rem;">
            <div class="card-head">
                <div class="form-group text-center">
                    <img src="{{ asset('images/img_avatar.png') }}" class="rounded-circle" alt="image is broken" width="200" height="200">
                </div>

                <div class="form-group text-center">
                    <p class="h1">{{ $userprofile->first_name }} {{ $userprofile->last_name }}</p>
                    <a href="{{ route('user.profile') }}" class="btn btn-dark btn-lg">Edit Profile</a>
                </div>

                <div class="form-group text-center">
                    <div>
                        <strong>{{ \App\Models\Course::count() }}</strong>
                        <span>Courses</span>
                    </div>
                    <div>
                        <strong>0</strong>
                        <span>Completed</span>
                    </div>
                    <div>
                        <strong>0</strong>
                        <span>Certificates</span>
                    </div>
                    <div>
                        <strong>0</strong>
                        <span>Points</span>
                    </div>
                </div>

                <div class="form-group">
                    <p class="h3">Your Courses</p>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            @foreach ($courses as $key_course => $course)
                                <h2 class="accordion-header" id="flush-headingOne-{{ $key_course }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne-{{ $key_course }}" aria-expanded="false"
                                        aria-controls="flush-collapseOne"
                                        style="font-size : 15px; width: 100%; height: 100px;">
                                        {{ $course->title }}
                                    </button>
                                </h2>
                                <div id="flush-collapseOne-{{ $key_course }}" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne-{{ $key_course }}"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <p class="font-weight-bold">Course Progress</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <p class="font-weight-bold">90%complete</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="passing_score">0/7 steps</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped" role="progressbar"
                                                style="width: 90%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!--Inner Page Head ENDS-->
@endsection

@section('js')
    <script src="{{ asset('js/bootstrap-myprofile.bundle.min.js') }}"></script>
@endsection
