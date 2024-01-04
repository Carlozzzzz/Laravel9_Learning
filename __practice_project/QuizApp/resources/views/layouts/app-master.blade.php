<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title : "EXAM" }} </title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" integrity="sha512-oAvZuuYVzkcTc2dH5z1ZJup5OmSQ000qlfRvuoTTiyTBjwX1faoyearj8KdMq0LgsBTHMrRuMek7s+CxF8yE+w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Custon Styles --}}
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

</head>
<body>
    {{-- Message Notification --}}
    <x-message />

    {{-- Header --}}
    <header id="pageHeader" class="header d-flex align-items-center">
        <span class="toggle-sidenav-btn d-md-none"><i class="bi bi-list main-text-color"></i></span>

        @include('layouts.partials.header')
        {{-- @yield('header') --}}
        {{-- <x-master.header :page="$page" /> --}}
    </header>

    {{-- Main Navigation - left --}}
    <x-master.side-nav/>

    {{-- Main Content --}}
    <main id="mainContent"  class="container-fluid main-text-color px-2 px-lg-4 py-4">
        @yield('content')
    </main>

    {{-- Profile | Content details - right --}}
    
    {{-- <x-master.side-bar /> --}}
    @include('layouts.partials.side-bar')

    {{-- Right banner toggler --}}
    <span class="bg-sub-color text-white rounded position-fixed bottom-0 end-0 z-990 p-2 m-2 banner-toggler"><i class="toggle-sidebar-btn bi bi-arrow-bar-left fs-5"></i></span>

    {{-- Footer --}}
    <footer id="pageFooter" class="px-3">Footer</footer>

    {{-- Bootstrap Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    {{-- JS Libraries --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="{{ asset('/js/main.js') }}"></script>
    @include('sweetalert::alert')

   
    {{-- Global Custom scripts --}}
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            bootstrapFormValidate();
        });

        function bootstrapFormValidate() {
            const forms = document.querySelectorAll('.needs-validation');
            let ispassvalidation = false;

            Array.prototype.slice.call(forms).forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (!form.checkValidity()) {
                        ispassvalidation = false;
                    } else {
                        ispassvalidation = true;
                    }

                    form.classList.add('was-validated');
                    event.preventDefault();
                    event.stopPropagation();


                    if (ispassvalidation == true) {
                        if(form.classList.contains("questionnaire-input")) {
                            saveQuestionnaireHTML(form);
                            // console.log("Form is validated successfully.");
                        } else {
                            console.log("Class was not found.", form.classList);
                        }
                    } else {
                        console.log("Needs further validation.");
                    }
                }, false);
                form.addEventListener('reset', (event) => {
                    form.classList.remove('was-validated');
                }, false);
            });

        }
        function toggleActiveContent(className, activeNav) {
            
            $(className).removeClass('active');

            activeNav.addClass('active');
        }

        function toggleActiveDisplay(className, obj) {
            const target = obj.data('target');
            const activeContent = $('.' + target);
            
            $(className).removeClass('d-none');

            $(className).hide();

            activeContent.show();

            toggleActiveContent(className, activeContent);
        }

        function contentScrollFocus(element) {
            const buttonsContainer = document.querySelector(element);
            if (buttonsContainer) {
                buttonsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    </script>

    {{-- Custon Scripts --}}
    @yield('custom-script')

</body>
</html>