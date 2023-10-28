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
                <h3 class="mt-4">Blogs</h3>
                <hr class="px-2">
            </div>
            {{-- Posts component --}}
            <x-blog-postcard :data="$data_datatablefile"/>
        </div>
    </div>
</section>
@endsection