@component('mail::message')
	Hi {{ $data['admin_user']->first_name . ' ' . $data['admin_user']->last_name }},<br>
	{{ $data['user']->first_name . ' ' . $data['user']->last_name }}&nbsp;has submit a review for
	{{ $data['course']->title }}&nbsp;course.
	<table align="left" cellpadding="0" cellspacing="0" role="presentation"
		style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';margin:10px auto;padding:0;text-align:left; width:100%;">
		<tbody>
			<tr>
				<td width="100%" style="vertical-align: top;"><b>Ratings : </b> {{ number_format($data['average_ratings'], 2) }}</td>
			</tr>
			@if ($data['review']->comment)
				<tr>
					<td width="100%" style="vertical-align: top;"><b>Review : </b> {{ $data['review']->comment }}</td>
				</tr>
			@endif
		</tbody>
	</table>
	<br>
	Thanks,<br>
	{{ config('app.name') }}
@endcomponent
