<!--CTA Bar-->
<div class="footer-cta text-lt">
	<div class="container">
		<div class="cta-row">
			<div class="cta-left">
				<p>Stay sharp. Learn from leading experts on the latest business trends.</p>
			</div>
			<div class="cta-right">
				<a class="bttn bttn-white" href="{{ route('front.register') }}" title="Sign up for courses">Sign up for courses</a>
			</div>
		</div>
	</div>
</div>

<!--Footer-->
<footer class="footer">
	<div class="footer-top">
		<div class="container">
			<div class="row foo-row">
				<div class="foocol foocol-1 col-6 col-sm-4 col-lg-4">
					<h3>Community</h3>
					<ul class="foo-nav">
						<li><a href="{{ route('front.resources') }}" title="Blogs">Blogs</a></li>
						<li><a href="#" title="Partner">Partner</a></li>
						<li><a href="#" title="Developers">Developers</a></li>
						<li><a href="#" title="Events">Events</a></li>
						<li><a href="#" title="News">News</a></li>
						<li><a href="{{ route('front.consultation-booking') }}" title="Consultation Booking">Consultation Booking</a></li>
					</ul>
				</div>
				<div class="foocol foocol-2 col-6 col-sm-4 col-lg-4">
					@php
						$cms_pages = \App\Models\CmsPages::latest()->get();
					@endphp
					@if ($cms_pages->count())
						<h3>Resources</h3>
						<ul class="foo-nav">
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
				<div class="foocol foocol-3 col-12 col-lg-4">
					{{-- <a class="bttn bttn-primary" href="{{ route('front.contact-us') }}" title="Get Support">Get Support</a> --}}
					<a class="text-white" href="tel:7139043571" title="Call or Text Us at: 7139043571">Call or Text Us at: 7139043571</a>

					<ul class="foo-social">
						@if (get_setting_value('facebook_link'))
							<li>
								<a href="//{{ get_setting_value('facebook_link') }}" target="_blank" title="Facebook">
									<i class="icon-facebook"></i>
								</a>
							</li>
						@endif
						@if (get_setting_value('instagram_link'))
							<li>
								<a href="//{{ get_setting_value('instagram_link') }}" target="_blank" title="Instagram">
									<i class="icon-instagram"></i>
								</a>
							</li>
						@endif
						@if (get_setting_value('youtube_link'))
							<li>
								<a href="//{{ get_setting_value('youtube_link') }}" target="_blank" title="YouTube">
									<i class="icon-youtube"></i>
								</a>
							</li>
						@endif
						@if (get_setting_value('twitter_link'))
							<li>
								<a href="//{{ get_setting_value('twitter_link') }}" target="_blank" title="Twitter">
									<i class="icon-twitter"></i>
								</a>
							</li>
						@endif
						@if (get_setting_value('linkedin_link'))
							<li>
								<a href="//{{ get_setting_value('linkedin_link') }}" target="_blank" title="Linkedin">
									<i class="icon-linkedin"></i>
								</a>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<hr class="footer-divider">
	</div>

	<div class="footer-bottom">
		<div class="container text-center">
			<div class="footer-copy">© Copyright 2012 - {{ date('Y') }}. {{ env('APP_NAME') }}. All Rights Reserved.</div>
		</div>
	</div>
</footer>

<!--Coupon Offer -->
<div class="popup popup-offer @error('offer_email') popup-show @enderror @error('offer_phone') popup-show @enderror @error('g-recaptcha-response') popup-show @enderror" id="coupon-offer"
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
				<input class="input-field mb-1 offer_phone @error('offer_phone') is-invalid @enderror" type="text" name="offer_phone" value="{{ old('offer_phone') }}" placeholder="Enter your phone." />
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
				<button type="submit" class="bttn bttn-primary">Get it Now!</button>
			</form>
			<a href="#no-discount" class="popup-close close-link">OR SAVING ISN'T YOUR THING?</a>
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
					value="{{ old('offer_email') }}" placeholder="Enter your email." required/>
				@error('offer_email')
					<span class="error invalid-feedback">{{ $message }}</span>
				@enderror
				<input class="input-field mb-1 offer_phone @error('offer_phone') is-invalid @enderror" type="text" name="offer_phone" value="{{ old('offer_phone') }}" placeholder="Enter your phone." />
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
				<button type="submit" class="bttn bttn-primary">Get it Now!</button>
			</form>
		</div>
	</div>
</div>

<!-- Site Loader -->
<div class="loader loader-container" style="display: none">
	<span class="loader-item"></span>
</div>
