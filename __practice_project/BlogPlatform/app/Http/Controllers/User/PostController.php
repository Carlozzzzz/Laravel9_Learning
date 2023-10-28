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
                        ->get();

            foreach ($data['data_datatablefile'] as $key => $value) {
                $filename = $value->post_image;
                
                $value->post_image = $this->imageLinkService->imageStorageLocation($filename, "post");
            }

            return view($page, $data);
        }
    }

    public function loadMoreData(Request $request)
    {
        if ($request->id > 0) {
            $data =  User::find(Auth::id())->posts()
                        ->where('id','<',$request->id)
                        ->orderBy('id','DESC')
                        ->limit(10)
                        ->get();
        } else {
            $data = User::find(Auth::id())->posts()
                        ->limit(10)
                        ->orderBy('id', 'DESC')
                        ->get();
        }

            $output = '';
            $button = '';
            $last_id = '';

            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $output .= '
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
                            <div class="cust-header">
                                <img src='. $row->post_image . ' class="card-img-top object-fit-cover" alt="..." height="250px">
                                
                                <div class="cust-body mb-3">
                                    <h5 class="fw-bold mt-3">'. $row->title .'</h5>
                                </div>
                            </div>
                            <div class="cust-footer">
                                <a href="/post/'.$row->id.'" class="fs-5">View post</a>
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
}