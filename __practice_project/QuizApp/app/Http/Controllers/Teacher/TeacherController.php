<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class TeacherController extends Controller
{
    public function index()
    {
        $page = "teacher/index";

        if(View::exists($page)) {
            $xdata = array();
            $data = array();

            $data['title'] = "QuizApp";
            $data['page'] = "Dashboard";

            $xdata = Quiz::where('user_id', Auth::user()->id)->get();

            $data["data_datarecordfile"] = $xdata;
            $data["data_dataactivepage"] = "dashboard";

            return view($page, $data);

        } return abort(404);
    }
}
