@component('mail::message')

<p>Hello Admin,</p>
<p>Please find the attached weekly report</p>

Thanks,<br>
{{ config('app.name') }}

@endcomponent
