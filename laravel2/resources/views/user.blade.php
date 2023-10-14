{{-- @dd($data); --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $name }} Document</title>
</head>
<body>
    <h2>{{ $name }}</h2>
    <span>{{ $age }}</span><br>
    <span>{{ $email }}</span><br>
    <span>{{ $id }}</span>

    <p>{{ print_r($data) }}</p>

</body>
</html>