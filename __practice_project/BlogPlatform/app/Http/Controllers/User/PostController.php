<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Services\ImageLinkService;
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
        $page = 'user.blogs';

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
        
                $filenameToStore = $filename . '_' . time() . '_' . $extension;
        
                $request->file('post_image')->storeAs('public/post/', $filenameToStore);
        
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