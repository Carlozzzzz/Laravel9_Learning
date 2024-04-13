@include('partials.header', ['title' => 'Student System'])

    {{-- navigation bar --}}
    @php $array = array('title' => 'Students Custom System'); @endphp
    <x-nav :data="$array"/>

    <header class="max-w-lg mx-auto  mt-5">
        <x-messages />
        <a href="#">
            <h1 class="text-3xl font-bold text-white text-center">Student List</h1>
        </a>
    </header>

    <section class="mt-10">
        <div class="overflow-x-auto relative">
            <table class="w-96 mx-auto text-sm text-left text-gray-500">
                <thead class="text-xs text gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            First Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Last Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Age
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Email
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $student)
                        <tr class="bg-gray-800 border-b text-white">
                            <td class="py-4 px-6">
                                {{ $student->first_name }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $student->last_name }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $student->age }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $student->email }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the navbar toggle button and the navbar main div
            var navbarToggle = document.getElementById('navbar-toggle');
            var navbarMain = document.getElementById('navbar-main');

            // Add click event listener to the toggle button
            navbarToggle.addEventListener('click', function() {
                // Toggle the visibility of the navbar main div
                navbarMain.classList.toggle('hidden');
            });
        });
    </script>

@include('partials.footer')

{{-- <table border=1>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Age</th>
        <th>Email</th>
    </tr>
    @foreach ($data as $student)
    <tr>
        <td>{{ $student->first_name }}</td>
        <td>{{ $student->last_name }}</td>
        <td>{{ $student->age }}</td>
        <td>{{ $student->email }}</td>
    </tr>
    @endforeach
</table>

<br>

<table border=1>
    <tr>
        <th>Gender</th>
        <th>Count</th>
    </tr>
    @foreach ($gender as $item)
        <tr>
            <td>{{ $item->gender }}</td>
            <td>{{ $item->gender_count }}</td>
        </tr>
    @endforeach
</table> --}}