<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')

    <title>{{ isset($title) ? $title : "Student System"}}</title>

    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="min-h-screen bg-gray-600 pt-12 pb-10 px-2">
    <x-messages />