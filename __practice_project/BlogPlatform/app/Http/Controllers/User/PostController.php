<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostImageRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\ImageLinkService;
use App\Services\StoreImageService;
use App\Services\ThumbnailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;


class PostController extends Controller
{
    private $imageLinkService;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->imageLinkService = app(ImageLinkService::class);
    }

    public function index()
    {
        $page = 'user.blog';

        if(View::exists($page)) {
            
            $data['data_datatablefile'] = User::find(Auth::id())->posts()
                        ->orderBy('created_at','desc')
                        ->orderBy('id','desc')
                        ->limit(3)
                        ->get();

            $data['data_datatablefile'] = $this->formatPostObj($data['data_datatablefile']);

            $lastIndex = count($data['data_datatablefile']) -1;

            $lastId = $data['data_datatablefile'][($lastIndex)]->id;

            $data['last_id'] = $lastId;

            return view($page, $data);
        }
    }

    public function loadMoreData(Request $request)
    {
        if ($request->id > 0) {
            $data =  User::find(Auth::id())->posts()
                        ->where('id','<',$request->id)
                        ->orderBy('created_at','desc')
                        ->orderBy('id','DESC')
                        ->limit(5)
                        ->get();
        } else {
            $data = User::find(Auth::id())->posts()
                        ->orderBy('created_at','desc')
                        ->orderBy('id', 'DESC')
                        ->limit(5)
                        ->get();
        }

            $output = '';
            $button = '';
            $last_id = '';

            if (!$data->isEmpty()) {

                $data = $this->formatPostObj($data);

                foreach ($data as $row) {
                    
                    $output .= '
                        <div class="col-md-6 col-lg-12 d-flex align-items-stretch">
                            <div class="card flex-lg-row position-relative w-100">
                                <div class="position-absolute d-flex top-0 end-0 p-2">
                                    <form class="me-1" action="'.url('user/post/delete/'.$row->id.'').'" method="POST">
                                        @method("delete")
                                        @csrf
                                        <button type="submit" class="btn btn-danger border-0 text-decoration-underline"><i class="bx bxs-trash"></i></button>
                                    </form>
                                    <a href="'.url('user/post/edit/'.$row->id.'').'" class="btn btn-secondary  border-0 text-decoration-underline ps-2"><i class="bx bxs-pencil"></i></a>
                                </div>
                                <img src="'.$row->post_image.'" class="blog-image object-fit-cover " alt="...">
                                <div class="blog-body flex-fill d-flex flex-column justify-content-between  p-2">
                                    <div class="story mt-1">
                                        <h5 class="fw-bold fs-4 ">'.$row->title.'</h5>
                                        <p class="">'.$row->content.'</p>
                                    </div>
                                    <a href="/post/{{ $row->id }}" class="text-decoration-none">
                                        <div class="cust-footer d-flex flex-column ">
                                            <div class="details">
                                                <div class="blog-creator d-flex align-items-center">
                                                    <img src="'.$row->user->user_image.'" class="rounded-circle border border-2 border-secondary border-opacity-25" alt="" width="25px" height="25px">
                                                    <h5 class="fs-6 fw-bold text-muted mb-0 ms-1"> '.$row->user->name.'</h5>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <span class="text-muted"><i class="bx bx-calendar"></i> '.$row->date_joined.'</span>
                                                <span class="text-muted ms-2"><i class="bx bx-message-rounded"></i></span> 09 Comments</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    ';
                    $last_id = $row->id ;
                }

                $button = '
                        <button type="button" name="load_more_button" class="btn btn-primary m-4 w-50" data-id="' . $last_id . '" id="load_more_button">Load More</button>
                    ';
            } else {
                $button = '
                        <button type="button" name="load_more_button" class="btn btn-info m-4 w-50">No Data Found</button>
                    ';
            }
        $xpostdata = array();

        $xpostdata['output'] = $output;
        $xpostdata['loadButton'] = $button;
        return $xpostdata;
    }

    public function show($id)
    {
        $page = "user.post";

        if(View::exists($page)) {

            $data['data_datarecordfile'] = Post::find($id);

            $filename = isset($data['data_datarecordfile']->post_image) ? $data['data_datarecordfile']->post_image : "";

            $imageUsage = "post";

            $post_image = $this->imageLinkService->imageStorageLocation($filename, $imageUsage);

            $data['data_datarecordfile']->post_image = $post_image;
            
            return view($page, $data);

        } return abort(404);
    }

    public function create()
    {
        $page = "user.create";

        if(View::exists($page)) {

            return view($page);
        } return abort(404);
    }

    public function store(StorePostRequest  $request, PostImageRequest $imageRequest)
    {
        $validated = $request->validated();

        if ($imageRequest->hasFile("post_image")){

            $imageRequest->validated();
    
            $requestFile = $imageRequest->file('post_image');

            $validated['post_image'] = StoreImageService::saveImageTo($requestFile, "post/image", true, 600, 200);
        }

        $user = User::find(Auth::id());

        $user->posts()->createQuietly($validated);

        return redirect('/blogs')->with('message','Post has been publish');
    }

    public function edit($id)
    {
        $page = "user.edit";
        if(View::exists($page)) {

            $data['data_datarecordfile'] = Post::findOrFail($id);

            $filename = isset($data['data_datarecordfile']->post_image) ? $data['data_datarecordfile']->post_image : "";

            $post_image = $this->imageLinkService->imageStorageLocation($filename, "post");

            $data['data_datarecordfile']->post_image = $post_image;

            return view($page, $data);
        } return abort(404);
    }

    public function update(Post $post, StorePostRequest  $request, PostImageRequest $imageRequest)
    {

        $validated = $request->validated();

        if ($imageRequest->hasFile("post_image")){

            $imageRequest->validated();
    
            $requestFile = $imageRequest->file('post_image');

            $validated['post_image'] = StoreImageService::saveImageTo($requestFile, "post/image", true, 600, 200);
        }

        $post->updateQuietly($validated);

        return redirect('user/posts')->with(['message' => 'Post has been updated.']);

    }

    function destroy(Post $post)
    {
        $post->delete();

        return redirect('user/posts')->with(['message' => 'Post has been deleted.']);
    }
    
    function formatPostObj($row)
    {
        foreach ($row as $key => $value) {
            $value->content = Str::limit($value->content, 100);
            
            $value->date_joined = $this->formatDate($value->created_at);

            $filename = $value->post_image;
            $value->post_image =  $this->imageLinkService->imageStorageLocation($filename, "post");

            $filename = $value->user->user_image;
            $value->user->user_image = $this->imageLinkService->imageStorageLocation($filename, "profile", true);
        }
        return $row;
    }

    function formatDate($date) {
        return \Carbon\Carbon::parse($date)->format('F Y');
    }

    function foreachDisplay($data)
    {
        foreach($data as $row) {
            echo $row->id."<br>";
        }
        die();
    }
}