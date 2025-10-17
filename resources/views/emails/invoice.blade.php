@component('mail::message')

Hi {{ $mail_data['name'] }},<br>
Your payment has been successful, <br>
You can find attached PDF file of the payment invoice.

<br>

<table style="font-size: 11px;width: 100%;">
    <thead>
        <tr>
            <th>Certificate Name</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr style="">
            <td colspan="4" style="border-top: 1px solid black;"></td>
        </tr>
        @foreach ($mail_data['stripe_response'] as $stripe_response)
            <tr>
                <td class="service">
                    @isset ($stripe_response->certificate_details)
                        @foreach (json_decode($stripe_response->certificate_details)->names as $certificate_detail)
                            <span>{{ $certificate_detail->first_name }} {{ $certificate_detail->last_name }}</span>@if (!$loop->last),<br> @endif
                        @endforeach
                    @endisset
                </td>
                @if (isset($stripe_response->course))
                    <td class="desc">{{ $stripe_response->course->title }}</td>
                    <td class="unit">${{ $stripe_response->course->price }}</td>
                    <td class="total">${{ $stripe_response->course->price * $stripe_response->quantity }}</td>
                @elseif(isset($stripe_response->policy_manual))
                    <td class="desc">{{ $stripe_response->policy_manual->title }}</td>
                    <td class="unit">${{ $stripe_response->policy_manual->price }}</td>
                    <td class="total">${{ $stripe_response->policy_manual->price * $stripe_response->quantity }}</td>
                @else
                    <td class="desc">-</td>
                    <td class="unit">-</td>
                    <td class="total">-</td>
                @endif
            </tr>
        @endforeach
        <tr style="">
            <td colspan="4" style="border-top: 1px solid black;"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">SUBTOTAL</td>
            <td class="total">${{ $mail_data['sub_total'] }}</td>
        </tr>
        @if ($mail_data['tax'])
            <tr>
                <td colspan="3" style="text-align: right;">TAX</td>
                <td class="total">${{ $mail_data['tax'] }}</td>
            </tr>
        @endif
        @if ($mail_data['discount'])
            <tr>
                <td colspan="3" style="text-align: right;">DISCOUNT</td>
                <td class="total">${{ $mail_data['discount'] }}</td>
            </tr>
        @endif
        <tr>
            <td colspan="3" class="grand total" style="text-align: right;">GRAND TOTAL</td>
            <td class="grand total">${{ $mail_data['total_amount'] }}</td>
        </tr>
    </tbody>
</table>

<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
