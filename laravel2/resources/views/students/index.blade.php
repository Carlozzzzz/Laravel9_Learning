{{-- @dd(auth()->user()->email); --}}
@include('partials.header')
    <?php $array = array('title' => 'Student System') ;?>
    <x-nav :data="$array"/>

    <header class="max-w-lg mx-auto mt-5" >
        <a href="">
            <h1 class="text-4xl font-bold text-white text-center ">Student List</h1>

        </a>
    </header>

    <section class="mt-10">
        <div class="overflox-x-auto relative">
            <table class="w-96 mx-auto text-sm text-left text-gray-500">
                <thead class="text-xs text gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                        </th>
                        <th scope="col" class="py-3 px-6">
                            First Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Last Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            email
                        </th>
                        <th scope="col" class="py-3 px-6">
                            age
                        </th>
                        <th scope="col">

                        </th>
                    </tr>
                </thead>

                <tbody class="">
                    @foreach ($students as $student)
                    <tr class="bg-gray-800 border-b text-white">
                        {{-- @php $default_prifile = "https://avatars.dicebear.com/api/initials/:".$student->first_name."-".$student->last_name."/svg" @endphp --}}
                        @php $default_prifile = "https://api.dicebear.com/avatar.svg" @endphp
                        <td class="p-1 ">
                            <img class="w-[3.5rem] h-[2.5rem] object-cover bg-gray-200" src="{{ $student->student_image ? asset("storage/student/thumbnail/".$student->student_image) : $default_prifile}}" alt="">
                        </td>
                        <td class="py-3 px-6">
                            {{ $student->first_name }}
                        </td>
                        <td class="py-3 px-6">
                            {{ $student->last_name }}
                        </td>
                        <td class="py-3 px-6">
                            {{ $student->email }}
                        </td>
                        <td class="py-3 px-6">
                            {{ $student->age }}
                        </td>
                        <td class="py-3 px-6">
                            <a href="/student/{{ $student->id }}" class="bg-sky-600 px-3 py-2 rounded">view</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
            <div class="max-w-lg mx-auto pt-6 p-4 ">
                {{ $students->links()}}
            </div>
        </div>
    </section>

@include('partials.footer')




{{-- <ul>
    @foreach ($students as $student)
        <li>{{ $student->gender }} - {{$student->gender_count}}</li>
    @endforeach
</ul> --}}
