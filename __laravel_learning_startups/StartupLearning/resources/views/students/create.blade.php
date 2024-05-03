@include('partials.header')
    <header class="max-w-lg mx-auto">
        <a href="#">
            <h1 class="text-3xl font-bold text-white text-center">Add new student</h1>
        </a>
    </header>

    <main class="bg-white max-w-lg mx-auto p-8 my-10 rounded-lg shadow-2xl">
        
        <section class="mt-5">
            <form action="/add/student" method="POST" class="flex flex-col">
                {{-- Cross site forgery attack --}}
                @csrf 
                <div class=" pt-6 rounded bg-gray-200">
                    <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">
                    First name</label>
                    <input type="text" name="first_name" id="first_name" class="bg-gray-200 rounded w-full focus:outline-none border-b-4 border-gray-400 px-3" value="{{ old('name') }}">
                </div>
                @error('first_name')
                    <p class="text-red-500 text-bold"> {{ $message }} </p>
                @enderror

                <div class="mt-6 pt-6 rounded bg-gray-200">
                    <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">
                    Last name</label>
                    <input type="text" name="last_name" id="last_name" class="bg-gray-200 rounded w-full focus:outline-none border-b-4 border-gray-400 px-3" value="{{ old('first_name') }}">
                </div>
                @error('last_name')
                    <p class="text-red-500 text-bold"> {{ $message }} </p>
                @enderror

                <div class="mt-6 pt-6 rounded bg-gray-200">
                    <label for="gender" class="block text-gray-700 text-sm font-bold mb-2 ml-3">
                    Gender</label>
                    <select name="gender" id="gender" class="bg-gray-200 rounded w-full focus:outline-none border-b-4 border-gray-400 px-3" value="{{ old('last_name') }}">
                        <option value="" {{ old('gender') == "" ? 'selected' : '' }}></option>
                        <option value="Male" {{ old('gender') == "Male" ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == "Female" ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                @error('gender')
                    <p class="text-red-500 text-bold"> {{ $message }} </p>
                @enderror
                <div class="mt-6 pt-6 rounded bg-gray-200">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2 ml-3">
                    Email</label>
                    <input type="email" name="email" id="email" class="bg-gray-200 rounded w-full focus:outline-none border-b-4 border-gray-400 px-3" value="{{ old('email') }}">
                </div>
                @error('email')
                    <p class="text-red-500 text-bold"> {{ $message }} </p>
                @enderror

                <div class="mt-6 pt-6 rounded bg-gray-200">
                    <label for="age" class="block text-gray-700 text-sm font-bold mb-2 ml-3">
                    Age</label>
                    <input type="number" name="age" id="age" class="bg-gray-200 rounded w-full focus:outline-none border-b-4 border-gray-400 px-3" value="{{ old('age') }}">
                </div>
                @error('age')
                    <p class="text-red-500 text-bold"> {{ $message }} </p>
                @enderror

                <button class="mt-6 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition-duration-200" type="submit">Add new</button>
                <a href="/" class="mt-6 bg-gray-600 hover:bg-gray-700 text-white text-center font-bold py-2 rounded shadow-lg hover:shadow-xl transition-duration-200" >Cancel</a>
            </form>
        </section>
    </main>
@include('partials.footer')