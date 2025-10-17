<!DOCTYPE html>
<html>

<head>
    <title>Certificate</title>
    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            background-image: url("{{ public_path('images/certificate/' . $certificate->image) }}");
            /* background-size: 100%; */
            background-position: center;
            background-repeat: no-repeat;
            margin: 0px;
            background-size: auto 100%;
        }

        .center {
            text-align: center;
        }

        .details {
            margin-top: 210px;
            font-family: sans-serif;
        }

        .details p {
            line-height: 20px;
        }

        .user-name {
            font-size: 30px;
            font-style: bold;
        }

        .line1 {
            font-size: 20px;
        }

        .line2 {
            font-size: 20px;
        }

        .class-name {
            font-size: 22px;
            font-style: bold;
        }

        .certificate-granted {
            padding-top: 50px;
            font-size: 22px;
        }
    </style>
</head>

<body>
    <div class="center">
        <div class="details">
            <p class="user-name">{{ $name }}</p>
            <p class="line1">{{ $certificate->line1 }}</p>
            <p class="class-name">{{ $course_name }}</p>
            <p class="line2">{{ $certificate->line2 }}</p>
            <div class="description">
                {!! $certificate->description !!}
            </div>
            <p class="certificate-granted">Certificate Granted: {{ $date }}</p>
        </div>
    </div>
</body>

</html>
