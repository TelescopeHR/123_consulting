@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/jquery-impromptu.css') }}">
@endsection

@section('content')
	@role(Config::get('constants.users_roles.super_admin'))
		@include('admin.layouts.breadcrumb', ['module_title' => 'Dashboard'])

		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{ route('blog.index') }}" class="text-dark">
							<div class="info-box">
								<span class="info-box-icon bg-primary elevation-1">
									<i class="fas fa-blog"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">Total Blogs</span>
									<span class="info-box-number">
										{{ \App\Models\Blog::count() }}
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{ route('category.index') }}" class="text-dark">
							<div class="info-box">
								<span class="info-box-icon bg-danger elevation-1">
									<i class="fas fa-list-alt"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">Total Categories</span>
									<span class="info-box-number">
										{{ \App\Models\Category::count() }}
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{ route('course.index') }}" class="text-dark">
							<div class="info-box">
								<span class="info-box-icon bg-success elevation-1">
									<i class="fas fa-user-graduate"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">Total Courses</span>
									<span class="info-box-number">
										{{ \App\Models\Course::count() }}
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-12 col-sm-6 col-md-3">
						<a href="{{ route('lesson.index') }}" class="text-dark">
							<div class="info-box">
								<span class="info-box-icon bg-warning elevation-1">
									<i class="fas fa-book-open"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">Total Lessons</span>
									<span class="info-box-number">
										{{ \App\Models\Lesson::count() }}
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-12 col-sm-6 col-md-4">
						<a href="{{ route('quiz.index') }}" class="text-dark">
							<div class="info-box">
								<span class="info-box-icon bg-primary elevation-1">
									<i class="fas fa-comment"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">Total Quizzes</span>
									<span class="info-box-number">
										{{ \App\Models\Quiz::count() }}
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-12 col-sm-6 col-md-4">
						<a href="{{ route('question.index') }}" class="text-dark">
							<div class="info-box">
								<span class="info-box-icon bg-danger elevation-1">
									<i class="fas fa-question"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">Total Questions</span>
									<span class="info-box-number">
										{{ \App\Models\Question::count() }}
									</span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-12 col-sm-6 col-md-4">
						<a href="{{ route('user.index') }}" class="text-dark">
							<div class="info-box">
								<span class="info-box-icon bg-success elevation-1">
									<i class="fas fa-users"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">Total Users</span>
									<span class="info-box-number">
										{{ \App\Models\User::role([Config::get('constants.users_roles.customer')])->count() }}
									</span>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<h3 class="card-title">Latest Purchased Courses</h3>
								</div>
								<table id="data-table" class="table">
									<thead>
										<tr>
											<th>Order</th>
											<th>User</th>
											<th>Courses/Policies</th>
											<th>Date</th>
											<th>Status</th>
											<th>Total</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		{{-- order details modal --}}
		<div class="modal fade order-detail-modal" id="orderDetailModal" tabindex="-1" role="dialog"
			aria-labelledby="orderDetailModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content"></div>
			</div>
		</div>
		{{-- order details modal --}}
	@endrole

	@role(Config::get('constants.users_roles.customer'))
		@include('admin.layouts.breadcrumb', ['module_title' => 'Dashboard'])
		<section class="content">
			<div class="container-fluid">
				<div class="card">
					<div class="card-header text-center border-0">
						<img src="{{ asset('images/img_avatar.png') }}" class="rounded-circle" alt="image is broken" width="200"
							height="200">
						<p class="h1">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</p>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-3 col-6">
								<div class="small-box bg-info">
									<div class="inner">
										<h3>{{ $in_progress_courses }}</h3>
										<p>In Progress Courses</p>
									</div>
									<div class="icon">
										<i class="fas fa-graduation-cap"></i>
									</div>
									<a href="{{ route('user.courses.in-progress') }}" class="small-box-footer">
										More info <i class="fas fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3>{{ $certificates }}</h3>
										<p>Completed</p>
									</div>
									<div class="icon">
										<i class="fas fa-check-circle"></i>
									</div>
									<a href="{{ route('user.courses.in-progress') }}" class="small-box-footer">
										More info <i class="fas fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-warning">
									<div class="inner">
										<h3>{{ $certificates }}</h3>
										<p>Certificates</p>
									</div>
									<div class="icon">
										<i class="fas fa-certificate"></i>
									</div>
									<a href="{{ route('user.certificates') }}" class="small-box-footer">
										More info <i class="fas fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-primary">
									<div class="inner">
										<h3>{{ $policies }}</h3>
										<p>Policies</p>
									</div>
									<div class="icon">
										<i class="fas fa-gavel"></i>
									</div>
									<a href="{{ route('user.policies') }}" class="small-box-footer">
										More info <i class="fas fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	@endrole

	@role(Config::get('constants.users_roles.caregiver'))
		@include('admin.layouts.breadcrumb', ['module_title' => 'Dashboard'])
		<section class="content">
			<div class="container-fluid">
				<div class="card">
					<div class="card-header text-center border-0">
						<img src="{{ asset('images/img_avatar.png') }}" class="rounded-circle" alt="image is broken" width="200"
							height="200">
						<p class="h1">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</p>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-3 col-6">
								<div class="small-box bg-info">
									<div class="inner">
										<h3>{{ $in_progress_courses }}</h3>
										<p>In Progress Courses</p>
									</div>
									<div class="icon">
										<i class="fas fa-graduation-cap"></i>
									</div>
									<a href="{{ route('user.courses.in-progress') }}" class="small-box-footer">
										More info <i class="fas fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3>{{ $certificates }}</h3>
										<p>Completed</p>
									</div>
									<div class="icon">
										<i class="fas fa-check-circle"></i>
									</div>
									<a href="{{ route('user.courses.in-progress') }}" class="small-box-footer">
										More info <i class="fas fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-warning">
									<div class="inner">
										<h3>{{ $certificates }}</h3>
										<p>Certificates</p>
									</div>
									<div class="icon">
										<i class="fas fa-certificate"></i>
									</div>
									<a href="{{ route('user.certificates') }}" class="small-box-footer">
										More info <i class="fas fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

							<div class="col-lg-3 col-6">
								<div class="small-box bg-primary">
									<div class="inner">
										<h3>{{ $policies }}</h3>
										<p>Policies</p>
									</div>
									<div class="icon">
										<i class="fas fa-gavel"></i>
									</div>
									<a href="{{ route('user.policies') }}" class="small-box-footer">
										More info <i class="fas fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	@endrole

@endsection

@section('js')
	<!-- DataTables -->
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script type="text/javascript">
		$(document).on("click", ".show-order", function(event) {
			event.preventDefault();
			let url = $(this).attr('target-url');
			$.ajax({
				headers: {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
				},
				type: "GET",
				url: url,
				dataType: 'json',
				success: function(response) {
					if (response.status) {
						$(".order-detail-modal .modal-content").html(response.data);
						$(".order-detail-modal").modal("show");
					}
				}
			});
		})

		const dataTable = $('#data-table').DataTable({
			lengthChange: false,
			searching: false,
			paging: false,
			ordering: false,
			info: false,
			responsive: window.screen.width < 1024,
			ajax: "{{ route('order.ajax', ['limit' => 5]) }}",
			columns: [{
					data: 'order_id'
				},
				{
					data: 'user.first_name',
                    render: function(data, type, row) {
                        if (row.user) {
                            let user = row.user.first_name + ' ' + row.user.last_name;
                            user += '<br><a href="mailto:' + row.user.email + '">' + row.user.email + '</a>';
                            return user;
                        }
                        return '<b>User Deleted</b>';
                    }
				},
				{
					data: 'courses'
				},
				{
					data: 'created_at'
				},
				{
					data: 'payment_status'
				},
				{
					data: 'total_amount'
				},
				{
					data: 'action',
					className: 'all',
					searchable: false,
					orderable: false
				},
			]
		});
	</script>
@endsection
