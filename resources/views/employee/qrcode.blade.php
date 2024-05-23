<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR Code</title>
</head>
<body>
    <h1>QR Code</h1>

    @foreach ($data as $d)
        @php
            // Concatenate the desired information into a single string
            $qrData = $d->firstName . ' ' . $d->lastName . '|' . $d->position . '|' . $d->dateOfBirth . '|' . $d->hireDate;
        @endphp
        <div style="width: 400px; display: flex; padding: 12px; margin-bottom: 12px">
            <div>{!! QrCode::size(100)->generate($qrData) !!}</div>
            <div>
                Name: {{ $d->firstName . ' ' . $d->lastName }} <br>
                Position: {{ $d->position }} <br>
                Date Of Birth: {{ $d->dateOfBirth }} <br>
                Hire Date: {{ $d->hireDate }}
            </div>
        </div>
    @endforeach


    {{-- Make sure to import the necessary QR Code class --}}
    {{-- @php use SimpleSoftwareIO\QrCode\Facades\QrCode; @endphp --}}
</body>
</html>
