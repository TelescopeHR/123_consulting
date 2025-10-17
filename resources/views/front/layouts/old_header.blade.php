<!--Top Header-->
<div class="site-offer">
	<a href="#coupon-offer" id="global-coupon-trigger" class="popup-trigger">Click Here</a> to get a $10 off coupon code.
</div>
<!--Header-->
<header class="header">
	<div class="header-top">
		<div class="container">
			<a class="header-top-cta" href="tel:7139043571" title="Call or Text Us at: 7139043571">Call or Text Us at:
				7139043571</a>
		</div>
	</div>

	<div class="header-main">
		<div class="container">
			<div class="row">
				<div class="col-auto">
					<a class="site-logo" href="{{ route('front.home') }}" title="{{ env('APP_NAME') }}">
						@if (get_setting_value('logo') && file_exists(public_path('images/settings/' . get_setting_value('logo'))))
							<img class="site-logo" src="{{ asset('images/settings/' . get_setting_value('logo')) }}"
								alt="{{ env('APP_NAME') }}" height="50" />
						@else
							{{ env('APP_NAME') }}
						@endif
					</a>
				</div>

				<!--Desktop Menu-->
				<div class="col-auto col-lg header-main--desktop">
					<ul class="header-nav">
						<li>
							<a href="{{ route('front.how-it-works') }}" title="Agency Startups">Agency Startups</a>
						</li>
						<li>
							<a href="{{ route('front.page', ['policies']) }}" title="Policy Manuals">Policy Manuals</a>
						</li>
						<li>
							<a href="{{ route('front.page', ['texas-education']) }}" title="Admin Training">Admin Training</a>
						</li>
						<li>
							<a href="{{ route('front.consultation-booking') }}" title="Consultation Booking">Consultation Booking</a>
						</li>
						<li>
							<a href="javascript:void(0);" title="Intake Form">Intake Form</a>
						</li>
						<li class="dropitem">
							<a href="javascript:void(0);" title="Resources">Resources</a>

							<ul class="submenu">
								<li>
									<a title="Blog" href="{{ route('front.resources') }}">Blog</a>
								</li>
								<li>
									<a title="How-to Videos" href="{{ route('front.video') }}">How-to Videos</a>
								</li>
							</ul>
						</li>

						{{-- <li>
                            <a href="{{ route('front.contact-us') }}" title="Support">Support</a>
                        </li> --}}
						<li class="header-cart">
							@php
								$cart_count = session()->has('cart_data') ? count(session()->get('cart_data')) : 0;
							@endphp
							<a href="{{ route('cart') }}" title="Cart">
								<i class="icon-cart"></i>
								<span id="cart-item" class="cart-item-count">{{ $cart_count ? "($cart_count)" : '' }}</span>
							</a>
						</li>
					</ul>

					<ul class="header-authnav">
						@if (Auth::check())
							<li>
								<a href="{{ route('logout') }}" title="Login"
									onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
							</li>
							<li>
								<a class="bttn bttn-primary" href="{{ route('admin.dashboard') }}" title="Dashboard">Dashboard</a>
							</li>
						@else
							<li>
								<a href="{{ route('login') }}" title="Sign in">Sign in</a>
							</li>
							<li>
								<a class="bttn bttn-primary" href="{{ route('front.register') }}" title="Sign up">Sign up</a>
							</li>
						@endif
					</ul>
				</div>

				<!--Mobile Toggle-->
				<div class="col d-lg-none">
					<label class="site-menutoggle">
						<input class="d-none" type="checkbox">
						<span></span>
						<span></span>
						<span></span>
					</label>
				</div>

				<!--Mobile Menu-->
				<div class="header-main--mobile">
					<ul class="header-nav">
						@php
							$categories = App\Models\Category::where('id', '!=', 1)->where('type', 'Course')->whereHas('courses')->get();
						@endphp
						@foreach ($categories as $category)
							<li>
								<a title="{{ ucwords($category->name) }}"
									href="{{ route('front.page', $category->slug_relation->slug) }}">{{ ucwords($category->name) }}</a>
							</li>
						@endforeach
						{{-- <li>
                            <a href="{{ route('front.contact-us') }}" title="Contact us">Contact us</a>
                        </li> --}}
						<li>
							<a href="{{ route('cart') }}" title="Cart">
								<i class="icon-cart"></i>
								<span id="cart-item" class="cart-item-count">{{ $cart_count ? "($cart_count)" : '' }}</span>
							</a>
						</li>
						<li>
							<a title="Blog" href="{{ route('front.resources') }}">Blog</a>
						</li>
						<li>
							<a title="How-to Videos" href="{{ route('front.video') }}">How-to Videos</a>
						</li>
						<li>
							<a href="{{ route('front.consultation-booking') }}" title="Consultation Booking">Consultation Booking</a>
						</li>

						@if (Auth::check())
							<li>
								<a href="{{ route('logout') }}" title="Login"
									onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
							</li>
							<li>
								<a href="{{ route('admin.dashboard') }}" title="Dashboard">Dashboard</a>
							</li>
						@else
							<li>
								<a href="{{ route('login') }}" title="Sign in">Sign in</a>
							</li>
							<li>
								<a href="{{ route('front.register') }}" title="Sign up">Sign up</a>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
	@csrf
</form>
