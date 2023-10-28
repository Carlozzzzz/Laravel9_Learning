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
        $page = "blog.blog";

        if(View::exists($page)) {
            
            $data['data_datatablefile'] = DB::table('posts')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

            // $data['data_datatablefile'] = Post::orderBy('created_at')->simplepaginate(5);
            
                // Handle the image src
                foreach ($data['data_datatablefile'] as $key => $value) {
                    $filename = $value->post_image;
                    $value->post_image =  $this->imageLinkService->imageStorageLocation($filename, "post");
                }
                
            return view($page, $data);
        } return abort(404);
    }

    public function loadMoreData(Request $request)
    {
        if ($request->id > 0) {
            $data = Post::where('id','<',$request->id)
                    ->orderBy('id','DESC')
                    ->limit(10)
                    ->get();
        } else {
            $data = Post::limit(10)->orderBy('id', 'DESC')->get();
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
