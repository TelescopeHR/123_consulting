@extends('front.layouts.master')

@section('title', 'How-to Videos - 123 Consulting Solutions')

@section('css')
@endsection

@section('content')
	<!--Inner Page Head-->
	<section class="section how-to-videos-page">
		<div class="container">
			<div class="courselist row how-to-videos-list">
				@foreach ($videos as $video)
                    <div class="how-to-videos-items">
                        <h3 class="courseitem-name" title="{{ $video->title }}">
                            {{ $video->title }}
                        </h3>
                        <div class="courseitem-excerpt">
                            {!! \Illuminate\Support\Str::limit(strip_tags($video->description), 200, '...') !!}
                        </div>
                        <div class="courseitem-ratings">
                        </div>
                        <div class="courseitem-actions">
                            <a class="bttn bttn-gray watch-video-button button-primary" href="{{ $video->youtube_link }}" target="_blank" title="Watch Video">Watch Video</a>
                        </div>
                    </div>
				@endforeach
			</div>
		</div>
	</section>
@endsection

@section('js')
@endsection
