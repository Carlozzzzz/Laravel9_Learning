@include('partials.header')
    <header class="max-w-lg mx-auto">
        <a href="#">
            <h1 class="text-3xl font-bold text-white text-center">Admin Login</h1>
        </a>
    </header>

    <main class="bg-white max-w-lg mx-auto p-8 my-10 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl">Welcome to Student System</h3>
            <p class="text-gray-600 pt-2"> Sign in to your account <a href="/login" class="text-purple-300 text-bold">here</a></p>
        </section>
        <section class="mt-10">
            <form action="/store" method="POST" class="flex flex-col">
                {{-- Cross site forgery attack --}}
                @csrf 
                <div class=" pt-6 rounded bg-gray-200">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">
                    Name</label>
                    <input type="name" name="name" id="name" class="bg-gray-200 rounded w-full focus:outline-none border-b-4 border-gray-400 px-3" value="{{ old('name') }}">
                </div>
                @error('name')
                    <p class="text-red-500 text-bold"> {{ $message }} </p>
                @enderror

                <div class="mt-6 pt-6 rounded bg-gray-200">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2 ml-3">
                    Email</label>
                    <input type="email" name="email" id="email" class="bg-gray-200 rounded w-full focus:outline-none border-b-4 border-gray-400 px-3" value="{{ old('name') }}">
                </div>
                @error('email')
                    <p class="text-red-500 text-bold"> {{ $message }} </p>
                @enderror

                <div class="mt-6 pt-6 rounded bg-gray-200">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2 ml-3">
                    Password</label>
                    <input type="password" name="password" id="password" class="bg-gray-200 rounded w-full focus:outline-none border-b-4 border-gray-400 px-3">
                </div>
                @error('password')
                    <p class="text-red-500 text-bold"> {{ $message }} </p>
                @enderror
                <div class="mt-6 pt-6 rounded bg-gray-200">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2 ml-3">
                    Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="bg-gray-200 rounded w-full focus:outline-none border-b-4 border-gray-400 px-3">
                </div>
                @error('password_confirmation')
                    <p class="text-red-500 text-bold"> {{ $message }} </p>
                @enderror

                <button class="mt-6 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition-duration-200" type="submit">Login</button>
            </form>
        </section>
    </main>
@include('partials.footer')