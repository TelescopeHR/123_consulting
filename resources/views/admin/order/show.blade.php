<div class="modal-header">
	<h5 class="modal-title">Order {{ $order->order_id }}</h5>
	<span
		class="p-2 badge {{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-danger' }} ml-auto">{{ ucwords($order->payment_status) }}</span>
	<button type="button" class="close ml-1" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<div class="row justify-content-center">
		<div class="col-md-12">
			@php
				$sub_total = 0;
				$total = 0;
				$discount = 0;
				$tax = 0;
				$applied_coupon = $order->coupon;
				$cart_items = json_decode($order->cart_items, true);
			@endphp

			@if ($order->user)
				<p class="pl-3 mb-1">Name: {{ $order->user->first_name . ' ' . $order->user->last_name }}</p>
				<p class="pl-3 mb-1">Email: <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></p>
				<p class="pl-3 mb-1">Phone: <a href="tel:{{ $order->user->phone }}">{{ $order->user->phone }}</a></p>
			@else
				<p class="pl-3 mb-1"><b>User Deleted</b></p>
			@endif

			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th width="10%">Type</th>
							<th width="40%">Course/Policy</th>
							<th width="30%">Caregiver</th>
							<th width="10%">Cost</th>
							<th width="10%">Tax</th>
							<th width="10%" class="text-right">Total</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($courses as $user_course)
							<tr>
								<td><b>Course</b></td>
								<td>{{ $user_course->course->title }}</td>
								<td>
									@if ($user_course->caregiver)
										{{ $user_course->caregiver->first_name . ' ' . $user_course->caregiver->first_name }}
										<br><a href="mailto:{{ $user_course->caregiver->email }}">{{ $user_course->caregiver->email }}</a>
									@else
										<b>Caregiver Deleted</b>
									@endif
								</td>
								<td>${{ $user_course->course->price }}</td>
								<td>${{ $user_course->course->tax }}</td>
								<td class="text-right">${{ $user_course->course->price + $user_course->course->tax }}</td>
							</tr>
						@empty
							@if (isset($cart_items['courses']))
								@forelse ($cart_items['courses'] as $course_id)
									@php
										$course_item = App\Models\Course::where('id', $course_id)->first();
									@endphp
									<tr>
										<td>
											@if (in_array(1, $course_item->categories->pluck('id')->toArray()))
												<b>Subscription Course</b>
											@else
												<b>Course</b>
											@endif
										</td>
										<td>{{ $course_item->title }}</td>
										<td>-</td>
										<td>${{ $course_item->price }}</td>
										<td>${{ $course_item->tax }}</td>
										<td class="text-right">${{ $course_item->price + $course_item->tax }}</td>
									</tr>
								@empty
								@endforelse
							@endif
						@endforelse

						@forelse ($subscription_courses as $subscription_course)
							<tr>
								<td><b>Subscription Course</b></td>
								<td>{{ $subscription_course->course->title }}</td>
								<td>-</td>
								<td>${{ $subscription_course->course->price }}</td>
								<td>${{ $subscription_course->course->tax }}</td>
								<td class="text-right">${{ $subscription_course->course->price + $subscription_course->course->tax }}</td>
							</tr>
						@empty
						@endforelse

						@forelse ($policies as $key_policy => $user_policy)
							<tr>
								<td><b>Policy</b></td>
								<td>{{ $user_policy->policy_manual->title }}</td>
								<td> - </td>
								<td>${{ $user_policy->policy_manual->price }}</td>
								<td>${{ $user_policy->policy_manual->tax }}</td>
								<td class="text-right">${{ $user_policy->policy_manual->price + $user_policy->policy_manual->tax }}</td>
							</tr>
						@empty
							@if (isset($cart_items['policies']))
								@forelse ($cart_items['policies'] as $policy_id)
									@php
										$policy_manual_item = App\Models\PolicyManual::where('id', $policy_id)->first();
									@endphp
									<tr>
										<td><b>Policy</b></td>
										<td>{{ $policy_manual_item->title }}</td>
										<td>-</td>
										<td>${{ $policy_manual_item->price }}</td>
										<td>${{ $policy_manual_item->tax }}</td>
										<td class="text-right">${{ $policy_manual_item->price + $policy_manual_item->tax }}</td>
									</tr>
								@empty
								@endforelse
							@endif
						@endforelse
						<tr>
							<td class="text-right pb-0" width="94%" colspan="5"> Sub Total : </td>
							<td class="text-right pb-0" width="6%"> ${{ $order->sub_total }} </td>
						</tr>
						<tr>
							<td class="text-right py-0 border border-white" width="94%" colspan="5"> Tax : </td>
							<td class="text-right py-0 border border-white" width="6%"> ${{ $order->tax }} </td>
						</tr>
						@if ($order->discount > 0)
							<tr>
								<td class="text-right py-0 border border-white" width="94%" colspan="5"> Discount : </td>
								<td class="text-right py-0 border border-white" width="6%"> <span>- ${{ $order->discount }}</span> </td>
							</tr>
						@endif
						<tr>
							<td class="text-right py-0 border border-white" width="94%" colspan="5"> <b>Total :</b> </td>
							<td class="text-right py-0" width="6%"> <b>${{ $order->total_amount }}</b> </td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
</div>
