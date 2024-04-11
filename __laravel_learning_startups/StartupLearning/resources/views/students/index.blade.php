<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Students</title>
</head>
<body>
    <table border=1>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Email</th>
        </tr>
        @foreach ($data as $student)
        <tr>
            <td>{{ $student->first_name }}</td>
            <td>{{ $student->last_name }}</td>
            <td>{{ $student->age }}</td>
            <td>{{ $student->email }}</td>
        </tr>
        @endforeach
    </table>

    <br>

    <table border=1>
        <tr>
            <th>Gender</th>
            <th>Count</th>
        </tr>
        @foreach ($gender as $item)
            <tr>
                <td>{{ $item->gender }}</td>
                <td>{{ $item->gender_count }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>