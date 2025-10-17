@component('mail::message')
	Hi,<br><br>
	Thank you for choosing us, Use this coupon code: <b>{{ $coupon_code }}</b> to get $10 off.<br><br>
	Thanks,<br>
	{{ config('app.name') }}
@endcomponent
