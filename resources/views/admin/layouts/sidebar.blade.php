<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('images/settings/' . get_setting_value('logo')) }}" class="brand-image"
            style="object-fit: cover;" alt="">
        {{-- <p>{{ env('APP_NAME') }}</p> --}}

    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/user-default.jpg') }}" class="img-circle elevation-2"
                    alt="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}" width="250" height="250">
            </div>
            <div class="info">
                <a href="{{ route('profile', ['id' => Auth::user()->id]) }}"
                    class="d-block">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @role(Config::get('constants.users_roles.super_admin'))
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('abandoned.index') }}" class="nav-link {{ Route::is('abandoned.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-times"></i>
                            <p>Abandoned Cart</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('blog.index') }}" class="nav-link {{ Route::is('blog.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-blog"></i>
                            <p>Blog</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('media.index') }}" class="nav-link {{ Route::is('media.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-image"></i>
                            <p>Media</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('category.index') }}"
                            class="nav-link {{ Route::is('category.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Categories</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('course.index') }}"
                            class="nav-link {{ Route::is('course.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>Courses</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('lead.index') }}"
                            class="nav-link {{ Route::is('lead.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-signal"></i>
                            <p>Leads</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('lesson.index') }}"
                            class="nav-link {{ Route::is('lesson.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>Lessons</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('quiz.index') }}" class="nav-link {{ Route::is('quiz.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-comment"></i>
                            <p>Quizzes</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('question.index') }}"
                            class="nav-link {{ Route::is('question.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-question"></i>
                            <p>Questions</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('tag.index') }}" class="nav-link {{ Route::is('tag.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tag"></i>
                            <p>Tags</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('coupon.index') }}"
                            class="nav-link {{ Route::is('coupon.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-gift"></i>
                            <p>Coupons</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link {{ Route::is('user.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user-courses.index') }}" class="nav-link {{ Route::is('user-courses.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>User Courses</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('cms-page.index') }}"
                            class="nav-link {{ Route::is('cms-page.*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-list-alt"></i>
                            <p>CMS Pages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('certificate.index') }}"
                            class="nav-link {{ Route::is('certificate.*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-certificate"></i>
                            <p>Certificates</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user-certificate.index') }}"
                            class="nav-link {{ Route::is('user-certificate.*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-certificate"></i>
                            <p>User Certificates</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('policy.index') }}"
                            class="nav-link {{ Route::is('policy.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-gavel"></i>
                            <p>Policy Manuals</p>
                        </a>
                    </li>
                      <li class="nav-item">
                        <a href="{{ route('intakeform.index') }}"
                            class="nav-link {{ Route::is('intakeform.*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-list-alt"></i>
                            <p>Intake Forms</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('order.index') }}"
                            class="nav-link {{ Route::is('order.*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-cart-arrow-down"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('setting.index') }}"
                            class="nav-link {{ Route::is('setting.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('video.index') }}"
                            class="nav-link {{ Route::is('video.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-video"></i>
                            <p>Videos</p>
                        </a>
                    </li>
                @endrole
                
                @role(Config::get('constants.users_roles.customer')  . '|' . Config::get('constants.users_roles.caregiver'))
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('user.courses.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Route::is('user.courses.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-table"></i>
                            <p>Assignments <i class="fas fa-angle-right right"></i></p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="display: {{ Route::is('user.courses.*') ? 'block' : 'none' }};">
                            <li class="nav-item">
                                <a href="{{ route('user.courses.in-progress') }}"
                                    class="nav-link {{ Route::is('user.courses.in-progress') || Route::is('user.courses.lessons')|| Route::is('user.courses.quizzes') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>In Progress</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.courses.completed') }}" class="nav-link {{ Route::is('user.courses.completed') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Completed</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.certificates') }}"
                            class="nav-link {{ Route::is('user.certificates') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-certificate"></i>
                            <p>Certificates</p>
                        </a>
                    </li>
                    @role(Config::get('constants.users_roles.customer'))
                        <li class="nav-item">
                            <a href="{{ route('user.old-certificates') }}" class="nav-link">
                                <i class="nav-icon fas fa-certificate"></i>
                                <p>Old Certificates</p>
                            </a>
                        </li>
                    @endrole
                    <li class="nav-item">
                        <a href="{{ route('user.policies') }}"
                            class="nav-link {{ Route::is('user.policies') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-gavel"></i>
                            <p>Policy Manuals</p>
                        </a>
                    </li>
                @endrole

                @role(Config::get('constants.users_roles.customer'))
                    <li class="nav-item">
                        <a href="{{ route('subscription.index') }}"
                            class="nav-link {{ Route::is('subscription.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Subscriptions</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('front.home') }}" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Courses</p>
                        </a>
                    </li>
                @endrole

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</aside>
