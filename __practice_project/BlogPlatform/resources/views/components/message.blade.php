@if(session()->has('message'))
    <div x-data="{show : true}" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="alert alert-dismissible alert-teal fixed-bottom m-2" role="alert">
        <div class="d-flex">
            <div class="py-1">
                <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                </svg>
            </div>
            <div>
                <p class="font-weight-bold">Alert Message</p>
                <p class="small">{{ session('message') }}</p>
            </div>
        </div>
    </div>
@endif



