<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Agency</th>
			<th>Phone</th>
			<th>Address</th>
			<th>City</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $key_user => $user)
			<tr>
				<td>{{ ucwords($user->first_name . ' ' . $user->last_name) }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ ucwords($user->agency_name) }}</td>
				<td>{{ $user->phone }}</td>
				<td>{{ ucwords($user->address) }}</td>
				<td>{{ ucwords($user->city) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
