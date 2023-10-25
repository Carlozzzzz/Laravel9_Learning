<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Libraries --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .custom-margin {
            margin-top: 40px !important;
        }
    </style>
</head>
<body class="position-relative">
    <x-message2 />

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/blogs') }}">
                    Bloger 'z
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a href="/blogs" class="nav-link">Blogs</a>
                            </li>
                            <li class="nav-item">
                                <a href="/user/create" class="nav-link">Create Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="/user/profile" class="nav-link"><img src="" alt=""> {{ _('Profile') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                @php
                                    $userProfileImage = Auth::user()->user_image;
                                    $userProfileImage = !($userProfileImage == "" || $userProfileImage == NULL) ?  $userProfileImage : "https://api.dicebear.com/avatar.svg";
                                    $userProfileImage = str_contains($userProfileImage, "https") ? $userProfileImage : asset("storage/user/thumbnail/image/" . $userProfileImage);
                                @endphp
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    <img src="{{ $userProfileImage }}" alt="" class="inline-block rounded-circle object-fit-cover bg-dark" width="30px" height="30px">
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="custom-margin py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Scripts --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    {{-- PHP -> Modal Opener Scripts --}}
    @if ($errors->has('user_image'))
        <script type="text/javascript">
            $(document).ready(function() {
                $('#updateProfileModal').modal('show');
            });
        </script>
    @elseif($errors->has('user_cover_image'))
        <script type="text/javascript">
            $(document).ready(function() {
                $('#updateProfileCoverModal').modal('show');
            });
        </script>
    @elseif($errors->has('email') || $errors->has('contact_number'))
        <script type="text/javascript">
            $(document).ready(function() {
                $('#updateProfileContactModal').modal('show');
            });
        </script>
    @endif

    {{-- Events --}}
    <script>
        
    </script>

    {{-- Custom Scripts --}}
    <script>
        function previewUpload(that){
            console.log(that)
            console.log(that.getAttribute('previewImage'))
            if (that.files && that.files[0]) {
                var reader = new FileReader();
    
                reader.onload = function (e) {
                    $('#'+that.getAttribute('previewImage')).attr('src', e.target.result);
                }
    
                reader.readAsDataURL(that.files[0]);
            }
        }
    </script>
</body>
</html>