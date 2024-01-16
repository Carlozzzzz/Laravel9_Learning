@props(['image'])

@php
    $default_image = "https://api.dicebear.com/avatar.svg";
    $path = isset($image) ? asset("storage/user/image/" . $image) : $default_image;

@endphp
<img class="w-[150px] rounded-full bg-gray-100" src="{{ $path }}" alt="User IMG">