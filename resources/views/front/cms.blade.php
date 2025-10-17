@extends('front.layouts.master')

@section('title')
    {{ $cmslist->meta_title }}
@endsection

@section('meta_description', $cmslist->meta_description)

@section('meta_keyword', $cmslist->meta_name)

@section('content')
    <section class="section innerfirst fulfillment-policies-page course-details-content-section ">
        <div class="container">
            <h1 class="course-details-content-title section_heading">{{ $cmslist->name }}</h1>
            {!! $cmslist->page_content !!}
        </div>
    </section>
@endsection
