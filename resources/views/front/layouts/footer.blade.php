<!-- Footer start -->
<footer class="footer">

	<div class="container">
		<div class="row footer-perent-box">
			<div class="footer-col footer-signup-box col-12 col-lg-6">
				<div class="footer-sign-up-box">
					<h4 class="footer-sign-up-box-title">Stay sharp. Learn from leading experts on the latest business trends.
					</h4>
					<a href="{{ route('front.register') }}" class="button-primary footer-sign-up-box-btn">Sign up for courses</a>
				</div>
			</div>
			<div class="footer-col col-12 col-md-6 col-lg-3">
				<div class="quick-link">
					<h3>Community</h3>
					<ul class="footer-link">
						<li>
							<a href="{{ route('front.resources') }}">Blogs</a>
						</li>
						<li>
							<a href="#">Partner</a>
						</li>
						<li>
							<a href="#">Developers</a>
						</li>
						<li>
							<a href="#">Events</a>
						</li>
						<li>
							<a href="#">Terms of News</a>
						</li>
						<li>
							<a href="{{ route('front.consultation-booking') }}">Consultation Booking</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="footer-col col-12 col-md-6 col-lg-3">
				<div class="quick-link">
					@php
						$cms_pages = \App\Models\CmsPages::latest()->get();
					@endphp
					@if ($cms_pages->count())
						<h3>Resources</h3>
						<ul class="footer-link mb-4">
							@forelse ($cms_pages as $cms_page)
								@if ($cms_page->slug_relation)
									<li>
										<a title="{{ ucwords($cms_page->name) }}"href="{{ route('front.page', $cms_page->slug_relation->slug) }}">
											{{ ucwords($cms_page->name) }}
										</a>
									</li>
								@endif
							@empty
							@endforelse
						</ul>
					@endif
				</div>
				<div class="quick-link call-our-text-field">
					<h3>Call or Text Us at</h3>
					<ul class="footer-link">
						<li>
							<a href="#">7139043571</a>
						</li>
					</ul>
				</div>
				<div class="social-media-and-copyright-section">
					<div class="social-media-and-copyright d-flex align-items-center justify-content-between">
						<ul class="social-media-icon d-flex">
							@if (get_setting_value('facebook_link'))
								<li>
									<a href="//{{ get_setting_value('facebook_link') }}" class="social-link d-flex" target="_blank">
										<img src="{{ asset('assets/images/facebook-icon.svg') }}" alt="icon" width="10" height="18" />
									</a>
								</li>
							@endif
							@if (get_setting_value('instagram_link'))
								<li>
									<a href="//{{ get_setting_value('instagram_link') }}" class="social-link d-flex" target="_blank">
										<img src="{{ asset('assets/images/instagram-icon.svg') }}" alt="icon" width="18" height="18" />
									</a>
								</li>
							@endif
							@if (get_setting_value('linkedin_link'))
								<li>
									<a href="//{{ get_setting_value('linkedin_link') }}" class="social-link d-flex" target="_blank">
										<img src="{{ asset('assets/images/linkedin-icon.svg') }}" alt="icon" width="18" height="18" />
									</a>
								</li>
							@endif
							@if (get_setting_value('twitter_link'))
								<li>
									<a href="//{{ get_setting_value('twitter_link') }}" class="social-link d-flex" target="_blank">
										<img src="{{ asset('assets/images/twitter-icon.svg') }}" alt="icon" width="18" height="14" />
									</a>
								</li>
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container text-center">
			<div class="footer-copy">© Copyright 2012 - {{ date('Y') }}. {{ env('APP_NAME') }}. All Rights Reserved.
			</div>
		</div>
	</div>
</footer>
<!-- Footer End -->


<!--Coupon Offer -->
<div
	class="popup popup-offer @error('offer_email') popup-show @enderror @error('offer_phone') popup-show @enderror @error('g-recaptcha-response') popup-show @enderror"
	id="coupon-offer"
	style="{{ $errors->has('offer_email') || $errors->has('offer_phone') || $errors->has('g-recaptcha-response') ?: 'display: none' }}">
	<div class="popup-wrapper">
		<div class="popup-dialog">
			<button type="button" class="popup-close close-x">x</button>
			<h2>Get $10 Off</h2>
			<p>ENTER YOUR EMAIL TO GET YOUR <span class="text-bd">$10 OFF COUPON CODE</span>.</p>
			<form method="post" action="{{ route('email.coupon') }}" id="get-coupon-form">
				@csrf
				<input type="hidden" name="source" id="source" value="coupon" />
				<input class="input-field mb-1 @error('offer_email') is-invalid @enderror" type="text" name="offer_email"
					value="{{ old('offer_email') }}" placeholder="Enter your email." />
				@error('offer_email')
					<span class="error invalid-feedback">{{ $message }}</span>
				@enderror
				<input class="input-field offer_phone @error('offer_phone') is-invalid @enderror" type="text"
					name="offer_phone" value="{{ old('offer_phone') }}" placeholder="Enter your phone." />
				@error('offer_phone')
					<span class="error invalid-feedback">{{ $message }}</span>
				@enderror
				<div class="formgroup">
					<div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror"
						data-sitekey="{{ get_setting_value('g_recaptcha_key') }}"></div>
					@error('g-recaptcha-response')
						<span class="error invalid-feedback">{{ $message }}</span>
					@enderror
				</div>
				<button type="submit" class="bttn get-it-now-button button-primary justify-content-center">Get it Now!</button>
			</form>
			<!-- <a href="#no-discount" class="popup-close close-link">OR SAVING ISN'T YOUR THING?</a> -->
		</div>
	</div>
</div>

<div class="popup popup-offer" id="download-policy" style="display: none">
	<div class="popup-wrapper">
		<div class="popup-dialog">
			<button type="button" class="popup-close close-x">x</button>
			<h2>Get Policy</h2>
			<p>ENTER YOUR EMAIL TO GET POLICY.</p>
			<form method="post" action="{{ route('email.coupon') }}" id="get-coupon-form">
				@csrf
				<input type="hidden" name="source" id="source" value="policy" />
				<input type="hidden" name="policy_id" id="policy_id" value="" />
				<input class="input-field mb-1 @error('offer_email') is-invalid @enderror" type="email" name="offer_email"
					value="{{ old('offer_email') }}" placeholder="Enter your email." required />
				@error('offer_email')
					<span class="error invalid-feedback">{{ $message }}</span>
				@enderror
				<input class="input-field mb-1 offer_phone @error('offer_phone') is-invalid @enderror" type="text"
					name="offer_phone" value="{{ old('offer_phone') }}" placeholder="Enter your phone." />
				@error('offer_phone')
					<span class="error invalid-feedback">{{ $message }}</span>
				@enderror
				<div class="formgroup">
					<div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror"
						data-sitekey="{{ get_setting_value('g_recaptcha_key') }}"></div>
					@error('g-recaptcha-response')
						<span class="error invalid-feedback">{{ $message }}</span>
					@enderror
				</div>
				<button type="submit" class="bttn get-it-now-button button-primary justify-content-center">Get it Now!</button>
			</form>
		</div>
	</div>
</div>

<!-- Site Loader -->
<div class="loader loader-container" style="display: none">
	<span class="loader-item"></span>
</div>
