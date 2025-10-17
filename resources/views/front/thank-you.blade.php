@extends('front.layouts.master')

@section('title', '123 Consulting Solutions - HHSC Approved Home Health, Hospice, PAS Administrator Training')

@section('content')
	<div class="container w-100 my-5 py-3 thank-you-page">
		<div class="row">
			<div class="text-center">
				<h2>Thank you for your purchase.</h2>

				<h5>Order ID: {{ $order->order_id }}</h5>
                <p>We have sent you an invoice to your email address.</p>
				<div>
					@if ($download_link)
						<p>You can download your policy by clicking on Download button.</p>
					@endif
						<a class="bttn bttn button-primary justify-content-center d-inline-flex" href="{{ route('admin.dashboard') }}" title="Dashboard"> Go to Dashboard </a>
					@if ($download_link)
						<a class="bttn bttn button-primary justify-content-center d-inline-flex" href="{{ $download_link }}" title="Download Policy" download> Download Policy </a>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection