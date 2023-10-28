@props(['data'])

{{-- <div class="container overflow-hidden">
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
                <a href="/user/post/{{ $data->id }}" class="fs-5">View post</a>
            </div>
        </div>

        @endforeach
    </div>
</div> --}}

<div class="container overflow-hidden">
    <div class="row g-3" id="dataContainer">
        @foreach ($data as $row)
        
        <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
            <div class="cust-header">
                <img src="{{ $row->post_image}}" class="card-img-top object-fit-cover" alt="..." height="250px">
                
                <div class="cust-body mb-3">
                    <h5 class="fw-bold mt-3">{{ $row->title }}</h5>
                </div>
            </div>
            <div class="cust-footer">
                <a href="/post/{{ $row->id }}" class="fs-5">View post</a>
            </div>
        </div>

        @endforeach

    </div>
    <div class="row">
        <div class="col-md-12 text-center" id="loadButtonCol">
            <div class="btn btn-primary m-4 w-50" id="load_more_button">See More</div>
        </div>
    </div>
</div>
@php
    $test = "testURL"; 
    
@endphp

@section('script')
    <script>
        $(function() {
            let dataContainer = $('#dataContainer');
            function loadMoreData(id=0){
                axios.post('{{ route("/user/load-data") }}',{ id : id})
                .then(res => {
                    $('#load_more_button').remove();
                    $('#dataContainer').append(res.data.output);
                    $('#loadButtonCol').append(res.data.loadButton);


                    window.scrollTo(0, document.body.scrollHeight);
                })
            }

            $('body').on('click', '#load_more_button', function(){
                var id = $(this).data('id');
                $('#load_more_button').html('<b>Loading...</b>');

                console.log(id);
                
                loadMoreData(id);
                
            });
        });
    </script>
@endsection