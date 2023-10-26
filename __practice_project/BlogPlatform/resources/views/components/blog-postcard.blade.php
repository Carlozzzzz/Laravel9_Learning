@props(['data'])

<div class="container overflow-hidden">
    <div class="row g-3">
        @foreach ($data as $data)
        
        <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
            <div class="cust-header">
                <img src="{{ $data->post_image}}" class="card-img-top object-fit-cover" alt="..." height="250px">
                
                <div class="cust-body mb-3">
                    <h5 class="fw-bold mt-3">{{ $data->title }}</h5>
                </div>
            </div>
            <div class="cust-footer">
                <a href="/post/{{ $data->id }}" class="fs-5">View post</a>
            </div>
        </div>

        @endforeach
    </div>
</div>