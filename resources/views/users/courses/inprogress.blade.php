@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('css')
    <style>
        #assignment-list .card {
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
            transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
            cursor: pointer;
        }

        #assignment-list .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
        }

        @media(max-width: 990px) {
            #assignment-list .card {
                margin-bottom: 20px;
            }
        }
    </style>
@endsection

@section('content')
    @role(Config::get('constants.users_roles.customer'))
        @include('admin.layouts.breadcrumb', ['module_title' => 'Assignments In Progress'])
        <section class="content">
            <div class="card">
                <div class="container-fluid">
                    <div class="row pt-5" id="assignment-list">
                        @foreach ($courses as $course)
                            <div class="col-md-4 col-sm-6 col-lg-4 col-xl-3 m-2"
                                style="padding-left: 20px; padding-bottom: 20px;">
                                <div class="card card-primary card-outline h-100">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="user-block">
                                                    <p class="text-info"></p>
                                                    <h5>
                                                        <a class="text-bold text-dark stretched-link"
                                                            href="#">{{ $course->title }}</a>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="user-block w-100 d-flex">
                                                    <div class="text-green w-50">
                                                        <i class="fa fa-circle"></i> On Track
                                                    </div>
                                                    <div class="w-50">
                                                        <div style="text-align: right">4 seconds ago</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <a class="text-bold text-dark stretched-link" href="#"></a>
                                        <h5 class="text-uppercase text-bold">Course</h5>
                                        <span class="card-subtitle mb-2">5 Lessons | 1.3 Hours</span>
                                        <p class="course_description">
                                            {!! $course->description !!}
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <span>Not Started Yet</span>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="progress mb-3">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 60%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="card-text text-right text-danger"><b>Due:</b> 08/05/2022</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endrole
@endsection