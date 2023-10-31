@extends('layouts.app')

@section('content')
<style>
    .custom-img {
        width: 150px;
    }
</style>
<section >
    <div class="row justify-content-center">
        
        <div class="col-12 col-lg-8 p-0">
            <div class="px-2">
                <h3 class="m-5 fs-2 fw-bold text-center">Blogs</h3>
            </div>
            {{-- Posts component --}}
            <x-blog-postcard :data="$data_datatablefile" :lastid="$last_id"/>
        </div>
    </div>
</section>
@endsection