@extends('front.layouts.master')

@section('title', 'Blog - 123 Consulting Solutions')
@section('css')
	<style>
		.image-box img {
			object-fit: fill;
		}
	</style>
@endsection

@section('content')

	<section class="blog-listing-section">
		<div class="container header-container">
			@if ($featuredBlogs && count($featuredBlogs))
				@php
					$firstFeaturedBlogs = $featuredBlogs->first();
					$description = $firstFeaturedBlogs->description;
					preg_match_all('/\[media-id=(.*?)]/', $description, $matches);
					if ($matches && count($matches)) {
					    foreach ($matches[0] as $match) {
					        $description = str_replace($match, '', $description);
					    }
					}
				@endphp

				<div class="row">
					<div class="cal-12 col-lg-7 blog-listing-left-col">
						<div class="blog-post-featured">
							<div class="blog-post-featured-image">
								<img src="{{ $firstFeaturedBlogs->full_image }}" width="670" height="300" alt="blog image" class="w-100">
							</div>
							<div class="blog-post-featured-body">
								<h3 class="blog-post-featured-title">
									<a href="{{ route('front.page', $firstFeaturedBlogs->slug_relation->slug) }}">{{$firstFeaturedBlogs->title}}</a>
								</h3>
								<p class="blog-post-featured-desc">{!! \Illuminate\Support\Str::limit(strip_tags($description), 180, '...') !!}</p>
								<div class="blog-post-featured-footer">
									<p class="blog-post-featured-author mb-0 me-3 ">{{ $firstFeaturedBlogs->author_name }}</p>
									<span class="blog-post-featured-date">{{ $firstFeaturedBlogs->publish_date->format('m/d/Y') }}</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-5 blog-listing-right-col">
						<div class="blog-post-category">
							<div class="blog-post-category-header">
								<h2>Featured Posts</h2>
							</div>
							@foreach ($featuredBlogs as $featuredBlog)
								@if (!$loop->first)
									<div class="blog-post-category-body">

										<div class="blog-post-category-card">
											<div class="blog-post-category-title">
												<h3>
													<a href="{{ route('front.page', $featuredBlog->slug_relation->slug) }}">{{ $featuredBlog->title }}</a>
												</h3>
											</div>
											<div class="blog-post-category-footer">
												@if ($featuredBlog->author_name)
													<span class="blog-post-category-auther">
														{{ $featuredBlog->author_name }}
													</span>
												@endif
												@if ($featuredBlog->publish_date)
													<span class="blog-post-featured-date">{{ $featuredBlog->publish_date->format('m/d/Y') }}</span>
												@endif
											</div>
										</div>
									</div>
								@endif
							@endforeach
						</div>
					</div>

				</div>
			@endif
			@foreach ($categories as $category)
				<div class="row">
					<div class="col-12 blog-post-items-header">
						<h2 class="blog-post-items-title">{{ $category->name }}</h2>
						@if (count($category->blogs) > 4)
							<a href="{{ route('blog-by-category', $category->slug_relation->slug) }}" class="blog-post-items-seemore">See
								more {{ strtolower($category->name) }}</a>
						@endif
					</div>

					@foreach ($category->blogs as $key => $blog)
						<div class="col-12 col-lg-6">
							<div class="blog-post-category-card  with-thumb">
								<div class="blog-post-category-thumb">
									<img src="{{ $blog->full_image }}" width="152" height="136" alt="blog featured img">
								</div>
								<div class="blog-post-category-body">
									<div class="blog-post-category-title">
										<h3>
											<a href="{{ route('front.page', $blog->slug_relation->slug) }}">{{ $blog->title }}</a>
										</h3>
									</div>
									<p class="blog-post-category-desc"> {!! \Illuminate\Support\Str::limit(strip_tags($blog->description), 100, '...') !!}</p>
									<div class="blog-post-category-footer">
										@if ($blog->author_name)
											<span class="blog-post-category-auther">
												{{ $blog->author_name }}
											</span>
										@endif
										@if ($blog->publish_date)
											<span class="blog-post-category-date">
												{{ $blog->publish_date->format('m/d/Y') }}
											</span>
										@endif
									</div>
								</div>
							</div>
						</div>
						@if ($key >= 3)
							@break
						@endif
					@endforeach
				</div>
			@endforeach
		</div>
	</section>
@endsection
