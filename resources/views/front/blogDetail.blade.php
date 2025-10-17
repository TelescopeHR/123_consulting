@extends('front.layouts.master')

@section('title', $blog->title)

@section('meta_description', $blog->title)

@if (isset($blog) && !empty($blog->image) && file_exists(public_path('images/blog/' . $blog->image)))
	@section('meta_image', asset('images/blog/' . $blog->image))
@endif

@section('css')
	<style>
		#social-links {
			margin: 0 auto;
			max-width: 500px;
			float: right;
		}

		#social-links ul li {
			display: inline-block;
		}

		#social-links ul li a {
			padding: 15px;
			border: 1px solid #ccc;
			margin: 1px;
			font-size: 30px;
		}

		.container #social-links {
			display: inline-table;
		}

		.container #social-links ul li {
			display: inline;
		}

		.container #social-links ul li a {
			padding: 5px 10px;
			border: 1px solid #ccc;
			margin: 5px;
			font-size: 15px;
			background: white;
			color: #3368fa;
			border-radius: 30%;
		}

		.container #social-links ul li a:hover {
			background: #3368fa;
			color: white;
		}
	</style>
@endsection

@section('content')
	<!--Inner Page Head-->
	<section class="blogpage bloginner blog-details-page">
		<div class="featured-blogs">
			<div class="container header-container">

				@if (isset($blog) && !empty($blog->image) && file_exists(public_path('images/blog/' . $blog->image)))
					<div class="bloginner-featimg">
						<img src="{{ asset('images/blog/' . $blog->image) }}" alt="{{ $blog->title }}" class="blog-details-page-images"
							alt="How to Write a Caregiver Job Post that Attracts Top Applicants" width="100%">
					</div>
					<br>
				@endif
                @php
                    $description = $blog->description;
                    preg_match_all('/\[media-id=(.*?)]/', $description, $matches);
                    if ($matches && count($matches)) {
                        foreach ($matches[0] as $key => $match) {
                            $title = 'Click Here';
                            $form_id = $match;
                            if (str_contains($match, ' title=')) {
                                $titleArr = explode(" title='", $match);
                                $title = str_replace([']', "'"], '', $titleArr[1]);
                                $form_id = $titleArr[0];
                            }
                            $description = str_replace(
                                $match,
                                '<a href="javascript:void(0)" class="open-form" data-id="' . $form_id . '">' . $title . '</a>',
                                $description,
                            );
                        }
                    }
                @endphp

				<br>
				<div class="bloginner-wrap">
					<h1>{{ $blog->title }}</h1>
					<div class="blog-details-social-media d-flex align-items-center justify-content-end w-100">
						<ul class="social-media-icon d-flex">
							
							<li>
								<a href="{{$facebookUrl}}" target="_blank" class="social-link social-media-facebook d-flex">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" height="19" viewBox="0 0 10 19" fill="none">
										<path
											d="M9.33876 10.6044L9.82563 7.40483H6.78225V5.32854C6.78225 4.45338 7.20724 3.59976 8.57038 3.59976H9.95379V0.87594C9.95379 0.87594 8.69853 0.659912 7.49805 0.659912C4.99192 0.659912 3.35385 2.19255 3.35385 4.96665V7.40538H0.567871V10.6049H3.35385V18.3399H6.78225V10.6049L9.33876 10.6044Z"
											fill="white" />
									</svg>
								</a>
							</li>
							<li>
								<a href="{{$twitterUrl}}" target="_blank" class="social-link social-media-twitter d-flex">
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="15" viewBox="0 0 18 15" fill="none">
										<path
											d="M17.362 2.39096C16.7673 2.62482 16.1355 2.78672 15.4665 2.85868C16.1727 2.46291 16.7116 1.83328 17.0089 1.09572C17.0275 1.04175 16.9717 1.00577 16.9346 1.02376C16.2656 1.38355 15.5408 1.6354 14.7789 1.77932C14.1285 1.11371 13.1808 0.699951 12.1587 0.699951C10.1703 0.699951 8.55359 2.22905 8.55359 4.13593C8.55359 4.40577 8.59075 4.65762 8.6465 4.90947C5.65462 4.76556 3.01582 3.41635 1.25042 1.34757C1.25042 1.32958 1.23183 1.32958 1.21325 1.34757C0.915921 1.85127 0.748672 2.42693 0.748672 3.05656C0.748672 4.22588 1.36191 5.25127 2.29107 5.86291C2.30965 5.8809 2.29107 5.89889 2.27249 5.89889C1.715 5.86291 1.21325 5.719 0.748672 5.48514C0.730089 5.48514 0.711511 5.48514 0.730094 5.50312C0.730094 5.64704 0.785841 6.33064 0.971672 6.76238C1.41767 7.84175 2.40258 8.65127 3.61048 8.88514C3.31315 8.95709 2.97865 9.01106 2.66273 9.01106C2.43973 9.01106 2.23532 8.99307 2.01232 8.95709C1.99374 8.95709 1.99374 8.97508 1.99374 8.97508C2.45832 10.3063 3.75914 11.2777 5.28296 11.3317C5.30154 11.3317 5.32012 11.3497 5.30154 11.3677C4.07505 12.2671 2.55124 12.8068 0.878757 12.8068C0.581427 12.8068 0.302673 12.7888 0.0239258 12.7529C1.62208 13.7243 3.51756 14.3 5.54312 14.3C8.34917 14.3 10.6163 13.3645 12.2888 11.9433C13.9799 10.5042 15.0948 8.57932 15.5408 6.60048C15.7081 5.91688 15.7824 5.2153 15.7824 4.5317C15.7824 4.38778 15.7824 4.24387 15.7638 4.08196C16.4142 3.63223 16.9903 3.07455 17.4549 2.46291C17.4549 2.42694 17.4177 2.37297 17.362 2.39096Z"
											fill="white" />
									</svg>
								</a>
							</li>
							<li>
								<a href="{{$linkedInUrl}}" target="_blank" class="social-link social-media-linkedin- d-flex">
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
										<path fill-rule="evenodd" clip-rule="evenodd"
											d="M0.531738 2.137C0.531738 1.74525 0.685168 1.36955 0.958273 1.09254C1.23138 0.815535 1.60179 0.659914 1.98802 0.659914H16.5049C16.6963 0.659597 16.8858 0.697575 17.0628 0.771673C17.2397 0.845771 17.4004 0.954535 17.5359 1.09174C17.6713 1.22894 17.7787 1.39188 17.8519 1.57125C17.9252 1.75061 17.9628 1.94286 17.9627 2.137V16.8612C17.9629 17.0554 17.9254 17.2477 17.8522 17.4272C17.7791 17.6066 17.6718 17.7697 17.5365 17.907C17.4011 18.0443 17.2404 18.1533 17.0636 18.2276C16.8867 18.3018 16.6971 18.34 16.5057 18.3399H1.98802C1.79671 18.3399 1.60728 18.3017 1.43054 18.2274C1.25381 18.1531 1.09323 18.0442 0.957993 17.907C0.822754 17.7698 0.715502 17.6068 0.642364 17.4275C0.569225 17.2482 0.531634 17.0561 0.531738 16.862V2.137ZM7.43124 7.40082H9.79155V8.60306C10.1322 7.91193 11.0038 7.28991 12.3135 7.28991C14.8244 7.28991 15.4194 8.66654 15.4194 11.1924V15.8711H12.8784V11.7678C12.8784 10.3293 12.5377 9.51759 11.6725 9.51759C10.4722 9.51759 9.97299 10.3928 9.97299 11.7678V15.8711H7.43124V7.40082ZM3.07349 15.761H5.61525V7.28991H3.07349V15.7602V15.761ZM5.97892 4.52701C5.98371 4.74775 5.94499 4.96723 5.86502 5.17258C5.78505 5.37794 5.66544 5.56502 5.51322 5.72285C5.361 5.88068 5.17923 6.00608 4.97858 6.0917C4.77794 6.17731 4.56245 6.22141 4.34477 6.22141C4.12709 6.22141 3.9116 6.17731 3.71095 6.0917C3.5103 6.00608 3.32853 5.88068 3.17631 5.72285C3.02409 5.56502 2.90449 5.37794 2.82452 5.17258C2.74454 4.96723 2.70582 4.74775 2.71061 4.52701C2.72002 4.09373 2.89632 3.68142 3.20176 3.37836C3.5072 3.07531 3.91749 2.90561 4.34477 2.90561C4.77204 2.90561 5.18234 3.07531 5.48778 3.37836C5.79321 3.68142 5.96951 4.09373 5.97892 4.52701Z"
											fill="white" />
									</svg>
								</a>
							</li>
						</ul>
					</div>
					{!! str_replace('class="media"', '', $description) !!}
				</div>
			</div>
		</div>
	</section>

	<form id="form-data" method="post" class="d-none" action="{{ route('front.blog-form') }}">
		@csrf
		<input type="hidden" name="file_id" id="file_id" />
		<div class="formcontrol formsubmit">
			<button type="submit">submit</button>
		</div>
	</form>
    
@endsection

@section('js')
	<!-- JavaScript Bundle with Popper -->
	<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
	<script>
		$('.open-form').click(function() {
			$('#file_id').val($(this).attr('data-id'));
			$('#form-data').submit();
		});
	</script>
@endsection
