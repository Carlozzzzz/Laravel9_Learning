<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index() {

        $data = Students::all();

        return view('students.index', ['students' => $data]);
    }

    public function whereID() {
        // $data = Students::where('id',5)->get();

        # Wildcart etc: startWith 
        $data = Students::where('first_name', 'like', '%bert')->get();
        $data = Students::where('age', '>', 19)
                    ->orderBy('first_name', 'desc')
                    ->limit(10)
                    ->get();
                    
        $data = DB::table('students')
                    ->select(DB::raw('count(*) as gender_count, gender'))
                    ->groupBy('gender')->get();

        # SQL Exception
        $data = Students::where('id', 101)->firstOrFail()->get();

        return view('students.index', ['students' => $data]);
    }

    public function show($id) {
        $data = Students::findOrFail($id);
        dd($data);
        return view('students.index', ['students' => $data]);

    }
}
