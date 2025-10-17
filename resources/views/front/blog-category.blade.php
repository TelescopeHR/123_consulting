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
	<section class="section blog-listing-section">
		<div class="container">
			<div class="row">
                <div class="col-12 blog-post-items-header">
                    <h2 class="blog-post-items-title">{{ $category->name }}</h2>
                </div>

                @foreach ($blogs as $key => $blog)
                    <div class="col-lg-6">
                        <div class="blog-post-category-card  with-thumb">
                            <div class="blog-post-category-thumb">
                                <img src="{{ $blog->full_image }}" alt="">
                            </div>
                            <div class="blog-post-category-body">
                                <div class="blog-post-category-title">
                                    <h3>
                                        <a href="{{ route('front.page', $blog->slug_relation->slug) }}">{{ $blog->title }}</a>
                                    </h3>
                                </div>
                                <p class="blog-post-category-desc">{!! \Illuminate\Support\Str::limit(strip_tags($blog->description), 100, '...') !!}</p>
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
                @endforeach

            </div>
		</div>
	</section>
@endsection

@section('js')
@endsection
