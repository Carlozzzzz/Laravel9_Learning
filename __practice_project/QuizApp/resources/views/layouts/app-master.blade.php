<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teacher</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" integrity="sha512-oAvZuuYVzkcTc2dH5z1ZJup5OmSQ000qlfRvuoTTiyTBjwX1faoyearj8KdMq0LgsBTHMrRuMek7s+CxF8yE+w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Custon Styles --}}
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
</head>
<body>
    <header id="pageHeader" class="header">
        <div class="d-flex align-items-center h-100 px-2 px-lg-4">
            <span class="toggle-sidenav-btn d-md-none"><i class="bi bi-list main-text-color"></i></span>
            <h3 class="page-title main-text-color fs-4 ms-1 ms-md-0 mb-0" id="pageTitle">Dashboard</h3>

            {{-- <a href=""><img src="{{ asset('/image/logo.png') }}" alt="logo" width="60"></a> --}}
            {{-- <ul class="nav ms-auto">
                <li class="ms-2"><i class="bi bi-bell"></i></li>
                <li class="ms-2"><i class="bi bi-chat-square"></i></li>
            </ul> --}}

            <button class="btn btn-success ms-auto px-3 py-2">Create Quiz</button>
        </div>
    </header>

    <aside id="sideNav" class="sideNav">
        <div class="d-flex flex-column justify-content-between bg-light h-100">
            <a href="{{ route('home') }}" class="d-block link-dark text-decoration-none text-center py-3" title="Exam" data-bs-toggle="tooltip"
                data-bs-placement="left" data-bs-original-title="Icon-only">
                <img src="{{ asset('/image/logo.png') }}" alt="logo" width="60">
            </a>
            <ul class="nav nav-pills nav-flush flex-column text-center mt-3 px-1">
                <li class="nav-item">
                    <a href="#" class="nav-link active py-3 border-bottom" aria-current="page" title="" data-bs-toggle="tooltip"
                        data-bs-placement="right" data-bs-original-title="Home">
                        <i class="bi bi-house"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link py-3 border-bottom" title="" data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-original-title="Dashboard">
                        <i class="bi bi-reception-4"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link py-3 border-bottom" title="" data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-original-title="Orders">
                        <i class="bi bi-info-circle"></i>
                    </a>
                </li>
            </ul>
            <div class="logout border-top mt-auto py-2">
                <a href="#"
                    class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </aside>

    <main id="mainContent"  class="container-fluid main-text-color px-2 px-lg-4 py-4">
        @yield('content')
    </main>

    <div id="bannerNav" class="sidebar">
        <div class="banner-content d-flex flex-column justify-content-between main-text-color p-3 h-100">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nulla quisquam dolores ipsam quod. Eveniet, officiis veniam non voluptatibus obcaecati iure cum, aperiam numquam vel neque similique, harum delectus porro laudantium.
        </div>
    </div>

    <span class="bg-sub-color text-white rounded position-fixed bottom-0 end-0 z-990 p-2 m-2 togger-margin"><i class="toggle-sidebar-btn bi bi-arrow-bar-left fs-5"></i></span>


    <footer id="pageFooter" class="px-3">Footer</footer>
    

    {{-- Bootstrap Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    {{-- JS Libraries --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('/js/main.js') }}"></script>

    {{-- Custon Scripts --}}
    @yield('custom-script')
</body>
</html>