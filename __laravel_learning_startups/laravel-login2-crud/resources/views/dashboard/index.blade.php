@include('dashboard.partials.header')
<section class="p-4 ">
    <div class="content-header">
        <h1 class="text-xl">Welcome, <span class="font-bold">{{ $user->name }}</span></h1>
    </div>
    <div class="content-body">
        <p>User ID: {{ $user->id }}</p>
        <a href="/users" class="inline-block font-bold text-blue-800 underline my-3">Users</a>
    </div>
    <div class="content-footer">
        <a href="/logout" class="inline-block bg-green-200 text-green-900 font-bold rounded px-4 py-2 mt-10">Logout</a>
    </div>
</section>
@include('dashboard.partials.footer')
