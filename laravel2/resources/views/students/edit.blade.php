@include('partials.header', [$title])

    <header class="max-w-lg mx-auto">
        <a href="">
            <h1 class="text-4xl font-bold text-white text-center">Edit Student</h1>
        </a>
    </header>
    <main class="bg-white max-w-lg mx-auto p-8 my-10 rounded-md shadow-2xl">
        <section class="mt-10">
            <form action="/student/{{$student->id}}" method="POST" class="flex flex-col" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="flex justify-center items-center my-4">
                    @php $default_prifile = "https://api.dicebear.com/avatar.svg" @endphp
                    <img class="w-[200px] h-[200px] object-cover rounded-full bg-gray-100" src="{{ $student->student_image ? asset("storage/student/".$student->student_image) : $default_prifile}}" alt="">
                </div>
                <div class="mb-6 pt-4 rounded bg-gray-200">
                    <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">First Name</label>
                    <input type="name" name="first_name" id="first_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3"  autocomplete="off" value={{ $student->first_name }}>
                    @error('first_name')
                        <p class="text-red-500 text-xs p-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6 pt-4 rounded bg-gray-200">
                    <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Last Name</label>
                    <input type="name" name="last_name" id="last_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3"  autocomplete="off" value={{ $student->last_name }}>
                    @error('last_name')
                        <p class="text-red-500 text-xs p-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6 pt-4 rounded bg-gray-200">
                    <label for="gender" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Gender</label>
                    <select type="gender" name="gender" id="gender" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3">
                        <option value="" {{ $student->gender == "" ? 'selected' : ''}}></option>
                        <option value="Male" {{$student->gender == "Male" ? 'selected' : ''}}>Male</option>
                        <option value="Female" {{$student->gender == "Female" ? 'selected' : ''}}>Female</option>
                    </select>

                    @error('gender')
                        <p class="text-red-500 text-xs p-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6 pt-4 rounded bg-gray-200">
                    <label for="age" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Age</label>
                    <input type="number" name="age" id="age" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" autocomplete="off" value={{$student->age}}>
                    @error('age')
                        <p class="text-red-500 text-xs p-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <div class="mb-6 pt-4 rounded bg-gray-200">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Email</label>
                    <input type="email" name="email" id="email" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" autocomplete="off" value={{$student->email}}>
                    @error('email')
                        <p class="text-red-500 text-xs p-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6 pt-4 rounded bg-gray-200">
                    <label for="student_image" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Student Image</label>
                    <input type="file" name="student_image" id="student_image" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" autocomplete="off" value={{$student->email}}>
                    @error('student_image')
                        <p class="text-red-500 text-xs p-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-700">Update</button>
            </form>
            <form action="/student/{{$student->id}}" method="POST">
                @method('delete')
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold rounded shadow-lg hover:shadow-xl transition duration-700  py-2 mt-2">Delete</button>
            </form>
            <a href="/" class="block w-full bg-gray-600 hover:bg-gray-700 text-white text-center font-bold rounded shadow-lg hover:shadow-xl transition duration-700  py-2 mt-2">Cancel</a>

        </section>
    </main>

@include('partials.footer')