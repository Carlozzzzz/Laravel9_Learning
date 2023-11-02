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

    {{-- Custom Style --}}
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    
</head>
<body class="bg-gray-body">
    <x-message />

    <div id="app">
        <header class="bg-dark position-relative" >
            <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top custom-height">
                <div class="container">
                    <a class="navbar-brand fs-2" href="{{ url('/blogs') }}">
                        <img src="{{ asset("storage/blogerz_logo.png") }}" alt="" width="150px">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#headerNav" aria-controls="headerNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="userAccessDiv">
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
                                <li class="nav-item dropdown">
                                    @php
                                        $userProfileImage = Auth::user()->user_image;
                                        $userProfileImage = !($userProfileImage == "" || $userProfileImage == NULL) ?  $userProfileImage : "https://api.dicebear.com/avatar.svg";
                                        $userProfileImage = str_contains($userProfileImage, "https") ? $userProfileImage : asset("storage/user/image/thumbnail/" . $userProfileImage);
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
            <div class="custom-margin">
                @guest
                @else
                <nav class="navbar navbar-expand-md p-0 p-md-2 mb-2">
                    <div class="container">
                        <div class="header-nav collapse navbar-collapse navbar-dark justify-content-center" id="headerNav">
                            <div class="navbar-nav">
                                <li class="nav-item ">
                                    <a href="/blogs" class="nav-link fs-5 py-2 py-md-3">Blogs</a>
                                </li>
                                <li class="nav-item ">
                                    <a href="{{ url('/user/post/create') }}" class="nav-link fs-5 py-2 py-md-3">Create Post</a>
                                </li>
                                <li class="nav-item ">
                                    <a href="/user/posts" class="nav-link fs-5 py-2 py-md-3">My Blog</a>
                                </li>
                                <li class="nav-item ">
                                    <a href="/user/profile" class="nav-link fs-5 py-2 py-md-3"><img src="" alt="">{{ _('Profile') }}</a>
                                </li>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="container featured-posts pb-3 {{ !(isset($data_dataactivepage) && $data_dataactivepage == "blog") ? "d-none" : "" }}">
                    <div class="row gy-4 gy-xl-0">
                        <div class="col-xl-8 mx-auto pe-lg-1 " >
                            <div class="card text-bg-dark ">
                                <img src="{{ asset("storage/feature-img-main.jpg") }}" class="card-img feature-image-thumb object-fit-cover" alt="...">
                                <div class="card-img-overlay overlay-bg top-post-details text-color-white d-flex flex-column justify-content-end">
                                    <ul class="tags d-flex list-inline">
                                        <li><a href="#" class="btn btn-danger rounded-0 px-3">Sample Tag</a></li>
                                    </ul>
                                    <a href="image-post.html" class="inline-block">
                                        <h3 class="fs-2 fw-bold my-2">A Discount Toner Cartridge Is Better Than Ever.</h3>
                                    </a>
                                    <ul class="meta d-flex list-inline mt-3">
                                        <li class=""><a href="#" class=""><i class='bx bx-user'></i> Carlos Maralit</a></li>
                                        <li class=""><a href="#" class="ms-3"><i class='bx bx-calendar'></i> 21 September, 2023</a></li>
                                        <li class=""><a href="#" class="ms-4"><i class='bx bx-message-rounded'></i></span> 06 Comments</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col col-xl-4">
                            <div class="row gy-3">

                                <div class="col-md-6 col-xl-12">
                                    <div class="blog-feature position-relative card shadow-lg ">
                                        <img src="{{ asset("storage/feature-img-sub1.jpg") }}" class=" feature-image-sub object-fit-cover" alt="...">
                                        <div class="feature-content  text-white d-flex flex-column justify-content-lg-end p-3 overlay-bg">
                                            <ul class="tags d-flex list-inline pt-sm-3">
                                                <li><a href="#" class="btn btn-danger rounded-0 px-3">Development</a></li>
                                            </ul>
                                            <a href="image-post.html" class="inline-block">
                                                <h3 class="fs-5 fw-bold my-2">Navigating the World of Development.</h3>
                                            </a>
                                            <ul class="meta d-flex list-inline mt-3 mb-0">
                                                <li class=""><a href="#" class=""><i class='bx bx-user'></i> Mark Winston</a></li>
                                                <li class="ms-3"><a href="#"><i class='bx bx-calendar'></i> 04 August, 2023</a></li>
                                                <li class="ms-3"><a href="#"><i class='bx bx-message-rounded'></i></span> 26 Comments</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-12">
                                    <div class="blog-feature position-relative card shadow-lg ">
                                        <img src="{{ asset("storage/feature-img-sub2.jpg") }}" class="feature-image-sub object-fit-cover" alt="...">
                                        <div class="feature-content  text-white d-flex flex-column justify-content-lg-end p-3 overlay-bg">
                                            <ul class="tags d-flex list-inline pt-sm-3">
                                                <li><a href="#" class="btn btn-danger rounded-0 px-3">Travel</a></li>
                                            </ul>
                                            <a href="image-post.html" class="inline-block">
                                                <h3 class="fs-5 fw-bold my-2">Journey Beyond: Explore the World's Wonders</h3>
                                            </a>
                                            <ul class="meta d-flex list-inline mt-3 mb-0">
                                                <li class=""><a href="#" class=""><i class='bx bx-user'></i> Jerik Agasi</a></li>
                                                <li class="ms-3"><a href="#" ><i class='bx bx-calendar'></i> 16 May, 2023</a></li>
                                                <li class="ms-3"><a href="#"><i class='bx bx-message-rounded'></i></span> 09 Comments</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        
                    </div>
                </div>
                @endguest
                
            </div>
        </header>

        <main>
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
    @elseif($errors->has('gender') || $errors->has('industry') || $errors->has('occupation') || $errors->has('country'))
        <script type="text/javascript">
            $(document).ready(function() {
                $('#updateProfileAboutModal').modal('show');
            });
        </script>
    @endif

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

    @yield('script')

</body>
</html>