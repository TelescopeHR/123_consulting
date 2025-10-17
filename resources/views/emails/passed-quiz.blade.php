@component('mail::message')
	Hello Admin,<br>
	<p>User has passed quiz for course.</p>
	<p><strong>Course Name:</strong> {{ $data['course_name'] }}</p>
	<p><strong>Course Purchased On:</strong> {{ $data['course_purchased'] }}</p>
	<p><strong>Quiz Name:</strong> {{ $data['quiz_name'] }}</p>
	<p><strong>Certificate Name: </strong> {{ $data['certificate_name'] }}</p>
	<p><strong>Company Email: </strong> {{ $data['company_email'] }}</p>
	<p><strong>Company Phone: </strong> {{ $data['company_phone'] }}</p>
	<br>
	Kind Regards,<br>
	{{ env('APP_NAME') }}
@endcomponent
