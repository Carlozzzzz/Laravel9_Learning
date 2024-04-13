@if(session()->has('message'))
    @php
        $colorClass = session('color') == 'green' ? 'green' : 'red';
    @endphp
    <div class="mb-2 bg-{{ $colorClass }}-100 border border-{{ $colorClass }}-400 text-{{ $colorClass }}-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">{{ session('message') }}</strong>
    </div>
@endif
