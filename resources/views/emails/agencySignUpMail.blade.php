@component('mail::message')
	Hello Admin,<br>
	New user has just registered on the site,
	Here is details below
	<p><strong>Name:</strong> {{ $data['name'] }}</p>
	<p><strong>Email:</strong> {{ $data['email'] }}</p>
	<p><strong>Phone:</strong> {{ $data['phone'] }}</p>
	Thanks,<br>
	{{ config('app.name') }}
@endcomponent
