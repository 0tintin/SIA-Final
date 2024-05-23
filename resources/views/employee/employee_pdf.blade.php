<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
</head>
<body>
    <h1>Employee List</h1>
    <table border="1">
        <thead>
            <tr>
                <th>QR Code</th>
                <th>Fullname</th>
                <th>Position</th>
                <th>Date Of Birth</th>
                <th>Hire Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $emp)
            <tr>
                <td><img src="data:image/png;base64,{{ base64_encode($emp->qrCode) }}" alt="QR Code"></td>
                <td>{{ $emp->firstName . ' ' . $emp->lastName }}</td>
                <td>{{ $emp->position }}</td>
                <td>{{ $emp->dateOfBirth }}</td>
                <td>{{ $emp->hireDate }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
