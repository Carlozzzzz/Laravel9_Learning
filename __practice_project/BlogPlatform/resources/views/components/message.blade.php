@if(session()->has('message'))
    <div 
        x-data="{show : true}"
        x-show="show"
        x-init="setTimeout(() => show = false, 2000)"
        class="alert alert-success position-fixed bottom-0 end-0  mx-3"
        style="width: 300px;"
        role="alert"
    >
        <h4 class="alert-heading"><i class='bx bxs-check-circle text-success'></i> Alert Message!</h4>
        <p class="mb-0">{{ session('message') }}</p>
    </div>
@endif