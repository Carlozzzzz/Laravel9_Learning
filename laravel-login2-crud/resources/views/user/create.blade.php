@include('user.partials.header')
<div class="relative w-full max-w-2xl max-h-full">
    <!-- Modal content -->
    <form action="/users/store" method="POST" enctype="multipart/form-data" class="relative bg-white rounded-lg shadow dark:bg-gray-700 mx-auto">
        @csrf
        <!-- Modal header -->
        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Add user
            </h3>
        </button>
        </div>
        <!-- Modal body -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" name="name" id="name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your name" value={{ old('name') }}>

                    @error('name')
                        <p class="p-3 text-red-500 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" name="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your email" value=" {{ old('email') }}">

                    @error('email')
                        <p class="p-3 text-red-500 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                    <input type="number" name="age" id="age" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Age" value=" {{ old('age') }}">

                    @error('age')
                        <p class="p-3 text-red-500 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="job" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Job</label>
                    <input type="text" name="job" id="job" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your job" value=" {{ old('job') }}">

                    @error('job')
                        <p class="p-3 text-red-500 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="user_image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User Image</label>
                    <input type="file" name="user_image" id="user_image" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full  dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('user_image')
                        <p class="p-3 text-red-500 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
               
                <div class="col-span-6 sm:col-span-3">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" name="password" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••">
                    @error('password')
                        <p class="p-3 text-red-500 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••">
                    @error('password_confirmation')
                        <p class="p-3 text-red-500 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
            <a href="{{ url('/users'); }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cancel</a>
        </div>
    </form>
</div>

@include('user.partials.footer')