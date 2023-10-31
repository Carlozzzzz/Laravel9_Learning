<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Services\ImageLinkService;
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
        // user blogs
        $page = 'user.blog';

        if(View::exists($page)) {
            
            $data['data_datatablefile'] = User::find(Auth::id())->posts()
                        ->orderBy('created_at','desc')
                        ->orderBy('id','desc')
                        ->limit(3)
                        ->get();


            $data['data_datatablefile'] = $this->formatPostObj($data['data_datatablefile']);

            $index = count($data['data_datatablefile']) -1;

            // $this->foreachDisplay($data['data_datatablefile']);

            $last_id = $data['data_datatablefile'][($index)]->id;

            $data['last_id'] = $last_id;

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
                    // $output .= '
                    //     <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
                    //         <div class="cust-header">
                    //             <img src='. $row->post_image . ' class="card-img-top object-fit-cover" alt="..." height="250px">
                                
                    //             <div class="cust-body mb-3">
                    //                 <h5 class="fw-bold mt-3">'. $row->title .'</h5>
                    //             </div>
                    //         </div>
                    //         <div class="cust-footer">
                    //             <a href="/post/'.$row->id.'" class="fs-5">View post</a>
                    //         </div>
                    //     </div>
                    // ';

                    $output .= '
                        <div class="col-md-6 col-lg-12 d-flex align-items-stretch">
                            <div class="card flex-lg-row position-relative w-100">
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


    public function show($id) {
        $page = "user.post";

        if(View::exists($page)) {

            $data['data_datarecordfile'] = Post::find($id);

            $filename = isset($data['data_datarecordfile']->post_image) ? $data['data_datarecordfile']->post_image : "";

            $post_image = $this->imageLinkService->imageStorageLocation($filename, "post");

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

    public function store(Request $request) {
        // try {
            $validated = $request->validate([
                "title" => "required|min:3",
                "content" => "required|min:3"
            ]);
  
            if ($request->hasFile("post_image")) {
                $request->validate([
                    "post_image" => "mimes:jpeg,png,bmp,tiff|max:4096",
                ]);
        
                $fileNameWithExtension = $request->file('post_image');
        
                $filename = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
        
                $extension = $request->file('post_image')->getClientOriginalExtension();
        
                $filenameToStore = $filename . '_' . time() . '.' . $extension;
        
                $request->file('post_image')->storeAs('public/post/image/', $filenameToStore);

                $request->file('post_image')->storeAs('public/post/image/thumbnail/', $filenameToStore);

                $thumbnail = "storage/post/image/thumbnail/" . $filenameToStore;

                ThumbnailService::createThumbnail($thumbnail, 600, 200);

                $validated['post_image'] = $filenameToStore;
            }

            $user = User::find(Auth::id());

            $user->posts()->createQuietly($validated);

            return redirect('/blogs')->with('message','Post has been publish');

        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     // If validation fails, dump the validation errors
        //     dd($e->errors());
        // }
    }
    
    function formatPostObj($row) {


        foreach ($row as $key => $value) {
            $filename = $value->post_image;
            $value->content = Str::limit($value->content, 100);

            $dateJoined = \Carbon\Carbon::parse($value->created_at)->format('F Y');
            $value->date_joined = $dateJoined; 
            $value->post_image =  $this->imageLinkService->imageStorageLocation($filename, "post");

            // Profile image thumbnail
            $filename = $value->user->user_image;
            $value->user->user_image = $this->imageLinkService->imageStorageLocation($filename, "profile", true);


        }


        return $row;
    }

    function foreachDisplay($data) {
        foreach($data as $row) {
            echo $row->id."<br>";
        }

        die();
    }
}