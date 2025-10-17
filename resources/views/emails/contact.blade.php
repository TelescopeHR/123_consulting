@component('mail::message')

Hello Admin,<br>
User contacted you, here is details below
<p><strong>Name:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Phone:</strong> {{ $data['phone'] }}</p>
<p><strong>Message:</strong> {{ $data['message'] }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent