<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Services\ImageLinkService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;


class BlogController extends Controller
{
    private $imageLinkService;

    public function __construct()
    {
        $this->middleware("auth");
        $this->imageLinkService = app(ImageLinkService::class);
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
                    $filename = $value->post_image;
                    $value->post_image =  $this->imageLinkService->imageStorageLocation($filename, "post");
                }
                
            return view($page, $data);
        } return abort(404);
    }

    public function show($id) 
    {
        $page = "blog.post";

        if(View::exists($page)) {

            $data["data_datarecordfile"] = Post::find($id);

            $filename = isset($data['data_datarecordfile']->post_image) ? $data['data_datarecordfile']->post_image : "";

            $post_image = $this->imageLinkService->imageStorageLocation($filename, "post");

            $data['data_datarecordfile']->post_image = $post_image;
            
            return view($page, $data);
        } return abort(404);
    }

}
