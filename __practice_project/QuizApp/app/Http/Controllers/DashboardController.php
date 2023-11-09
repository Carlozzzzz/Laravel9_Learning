<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index()
    {
        $page = "index";
        if(View::exists($page)) {
            $data = array();

            $data['title'] = "Quiz";
            $data['page'] = "Dashboard";

            $xdata = Quiz::where('user_id', Auth::user()->id)->get();

            $data["data_datarecordfile"] = $xdata;
            $data["data_dataactivepage"] = "dashboard";

            return view($page, $data);

        } return abort(404);
    }
}
