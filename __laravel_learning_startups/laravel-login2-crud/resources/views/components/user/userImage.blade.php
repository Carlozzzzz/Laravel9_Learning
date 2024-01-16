@props(['image'])

@php
    $default_image = "https://api.dicebear.com/avatar.svg";
    $path = isset($image) ? asset("storage/user/thumbnail/image/" . $image) : $default_image;

@endphp
<img class="w-10 h-10 rounded-full" src="{{ $path }}" alt="User IMG">