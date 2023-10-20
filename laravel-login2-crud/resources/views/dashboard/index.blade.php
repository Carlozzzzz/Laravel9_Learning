@include('dashboard.partials.header')
<section class="p-4 ">
    <h1 class="text-xl">Welcome, <span class="font-bold">{{ $user->name }}</span></h1>

    <p>User ID: {{ $user->id }}</p>

    <a href="/logout" class="inline-block bg-green-200 text-green-900 font-bold rounded px-4 py-2 mt-10">Logout</a>
</section>
@include('dashboard.partials.footer')
