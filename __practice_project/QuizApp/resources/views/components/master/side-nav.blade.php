<aside id="sideNav" class="sideNav">
    <div class="d-flex flex-column justify-content-between bg-light h-100">
        <a href="{{ route('home') }}" class="d-block link-dark text-decoration-none text-center py-3" title="Exam" data-bs-toggle="tooltip"
            data-bs-placement="left" data-bs-original-title="Icon-only">
            <img src="{{ asset('/image/logo.png') }}" alt="logo" width="60">
        </a>
        <ul class="nav nav-pills nav-flush flex-column text-center mt-3 px-1">
            <li class="nav-item">
                <a href=" {{ route('home') }} " class="nav-link active py-3 border-bottom" aria-current="page" title="" data-bs-toggle="tooltip"
                    data-bs-placement="right" data-bs-original-title="Home">
                    <i class="bi bi-house"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href=" {{ route('home') }} " class="nav-link py-3 border-bottom" aria-current="page" title="" data-bs-toggle="tooltip"
                    data-bs-placement="right" data-bs-original-title="Quiz">
                    <i class="bi bi-pen"></i>
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
            <form action="{{ route('logout.perform') }}"  method="POST">
                @csrf
                <button type="submit"
                    class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</aside>