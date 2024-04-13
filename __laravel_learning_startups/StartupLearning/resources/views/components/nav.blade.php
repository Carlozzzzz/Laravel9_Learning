<nav class="bg-gray-800 fixed w-full z-20 top-0 left-0 border-gray-200 px-2 sm:px-4 py-2.5 text-white">
    <div class="container flex flex-wrap justify-between items-center mx-auto">
        <a href="/">
            <span class="self-center text-xl font-semibold whitespace-nowrap">
                {{ $data['title'] }}
            </span>
        </a>
        <button id="navbar-toggle" class="md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-main">
            {{-- Item Components --}}
            <x-items />
        </div>
    </div>
</nav>