@extends('front.layouts.master')

@section('title', 'Book Consultation')

@section('css')
@endsection

@section('content')
<div class="header-height header-bg"></div>
<section class="section consultation-booking-page">
    <!-- Calendly inline widget begin -->
    <div class="calendly-inline-widget" data-url="https://calendly.com/telescopehr/consulting-meeting" style="min-width:320px;height:665px;"></div>
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
    <!-- Calendly inline widget end -->
</section>
@endsection
@section('js')
@endsection
