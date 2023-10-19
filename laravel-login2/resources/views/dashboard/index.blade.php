@include('dashboard.partials.header')
    <h1 class="p-4 text-xl">Welcome, <span class="font-bold">{{ $user->name }}</span></h1>

    <h5> name: {{ session('name') }}</h5>

    <a href="/logout" class="inline-block bg-green-200 text-green-900 font-bold rounded mx-4 px-4 py-2">Logout</a>
@include('dashboard.partials.footer')
