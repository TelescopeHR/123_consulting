@component('mail::message')

Hi {{ $data['name'] }},<br>
Thank you for registering to use {{ env('APP_NAME') }}. We know that {{ env('APP_NAME') }} will simplify the way you train your staff and we're eager for you to get started. You have signed up for the subscription.
In order to login, please use the credentials listed below:
<p><strong>Username: </strong> {{ $data['username'] }}</p>
<p><strong>Email: </strong> {{ $data['email'] }}</p>
{{--  <p><strong>Password:</strong> {{ $data['password'] }}</p>  --}}
<p>{{ env('APP_NAME') }} is a different approach to staff training... we are working hard to improve the software continuously, and your feedback is important to our success. What are your next steps? </p>
<p>1) Schedule an on-boarding meeting by adding your preferred time to our calendar </p>
<p>2) Start entering your data into {{ env('APP_NAME') }}.</p>
<p>3) If you have questions, we have answers!</p><br>
If you have any questions, Please call: (713) 904-3571, or email hello@123consultingsolutions.com<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
