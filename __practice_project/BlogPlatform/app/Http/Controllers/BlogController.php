<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $page = "blog.index";

        if(View::exists($page)) {
            $data['data_datatablefile'] = Post::orderBy('created_at')->get();

                $data['data_datatablefile'] = DB::table('posts')
                    ->orderBy('created_at', 'desc')
                    ->simplePaginate(10);
            
                // Handle the image src
                foreach ($data['data_datatablefile'] as $key => $value) {
                    $value->post_image = $this->validateImageSrc($value->post_image);
                }
                
            return view($page, $data);
        } return abort(404);
    }

    public function show($id) 
    {
        $page = "blog.post";

        if(View::exists($page)) {

            $data["data_datarecordfile"] = Post::find($id);

            $post_image = isset($data['data_datarecordfile']->post_image) ? $data['data_datarecordfile']->post_image : "";

            $post_image = $this->validateImageSrc($post_image);

            $data['data_datarecordfile']->post_image = $post_image;
            
            return view($page, $data);
        } return abort(404);
    }

    public function validateImageSrc($image)
    {
        if(isset($image)) {
            if (! str_contains($image, "http")) {
                $image = asset("storage/post/" . $image);
            }
        } else {
            $image = "https://api.dicebear.com/avatar.svg";
        }

        return $image;
    }
}
