@component('mail::message')
	Hello {{ $user->name }},<br>
	<p>Please be advised that next time you log in to <a href="{{ url('/') }}">{{ env('APP_NAME') }}</a>, you will need to use the following, new,
		information:
	</p>
	<p><strong>Username: </strong> {{ $user->username }}</p>
	<p><strong>Email: </strong> {{ $user->email }}</p>
	<p><strong>Password:</strong> {{ $user->username . "@2023" }}</p>
	<p>We have made changes to your login information because we have made some awesome updates and improvements to the
		site.</p>
	<p>{{ env('APP_NAME') }} will now be even easier to use than before! Thank you for your understanding.</p>
	<br>
	Kind Regards,<br>
	{{ env('APP_NAME') }}
@endcomponent
