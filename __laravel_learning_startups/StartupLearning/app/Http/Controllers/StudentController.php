<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(){

        $data = Students::all();
        $data = Students::where('id', 140)->get();
        $data = Students::where('first_name', 'like', '%hun%')->get();
        $data = Students::where('age', '!=', 21)->orderBy('last_name', 'desc')->limit(10)->get();

        $gender = DB::table('students')
                ->select(DB::raw('count(*) as gender_count, gender'))
                ->groupBy('gender')
                ->get();

        /** Exemption */
        $single_data = Students::where('id', 100)->firstOrFail();
        // dd($single_data);
        
        return view('students.index', ['data' => $data, 'gender' => $gender]);
    }

    public function show($id) {
        /** Exemption */
        $data = Students::where('id', $id)->firstOrFail();
        dd($data);

        return view('students.index', ['data' => $data]);
    }
}
