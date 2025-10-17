<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style data-merge-styles="true"></style>
    <style data-merge-styles="true"></style>
    <style data-merge-styles="true"></style>
    <title>Invoice</title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 150px;
        }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: right;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>

<body data-new-gr-c-s-check-loaded="14.1102.0" data-gr-ext-installed="">
    <header class="clearfix">
        <div id="logo">
            @if(get_setting_value('logo') && file_exists(public_path('images/settings/' . get_setting_value('logo'))))
                <img src="{{ public_path('images/settings/' . get_setting_value('logo')) }}" />
            @endif
        </div>
        <h1>{{ env('APP_NAME') }}</h1>
        <div id="company" class="clearfix">
            <div>{{ env('APP_NAME') }}</div>
            <div><a href="tel:7139043571">(713) 904-3571</a></div>
            <div><a href="mailto:info@123consultingsolutions.com">info@123consultingsolutions.com</a></div>
        </div>
        <div id="project">
            <div><span>CLIENT</span> {{ $data['company_name'] }}</div>
            <div><span>EMAIL</span> <a href="mailto:{{ $data['company_email'] }}">{{ $data['company_email'] }}</a></div>
            <div><span>DATE</span> {{ now()->format('F d, Y') }}</div>
        </div>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th class="service">Certificate Name</th>
                    <th class="desc">Item Name</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['stripe_response'] as $stripe_response)
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
                <tr>
                    <td colspan="3">SUBTOTAL</td>
                    <td class="total">${{ $data['sub_total'] }}</td>
                </tr>
                @if ($data['tax'])
                    <tr>
                        <td colspan="3">TAX</td>
                        <td class="total">${{ $data['tax'] }}</td>
                    </tr>
                @endif
                @if ($data['discount'])
                    <tr>
                        <td colspan="3">DISCOUNT</td>
                        <td class="total">${{ $data['discount'] }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" class="grand total">GRAND TOTAL</td>
                    <td class="grand total">${{ $data['total_amount'] }}</td>
                </tr>
            </tbody>
        </table>
    </main>
    <footer>
        Copyright © {{ date('Y') }} All rights reserved.
    </footer>
</body>
</html>
