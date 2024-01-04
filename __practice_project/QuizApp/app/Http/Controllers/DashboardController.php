<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;


class DashboardController extends Controller
{
    public function index()
    {
        $data = [];
        $xdata = [];
        $page = "";

        $user_type = Auth::user()->user_type;

        if ($user_type == "teacher") {
            $xdata = Quiz::where('user_id', Auth::user()->id)->get();
            $page = "teacher.index";
        } elseif ($user_type == "student") {
            return redirect()->route('student.quiz.index');
        } else {
            abort(404);
        }

        $data['title'] = "QuizApp";
        $data['page'] = "Dashboard";
        $data["data_datarecordfile"] = $xdata;
        $data["data_dataactivepage"] = "dashboard";

        return view($page, $data);
    }
}
