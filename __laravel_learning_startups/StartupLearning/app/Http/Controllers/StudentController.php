<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index1(){

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

        // return view('students.index');
    }

    public function index(){

        $data = array("data" => DB::table('students')
                    ->orderBy('created_at', 'desc')->simplePaginate(10));
        
        return view('students.index', $data);

        // return view('students.index');
    }

   

    public function show($id) {
        /** Exemption */
        $data = Students::where('id', $id)->firstOrFail();

        return view('students.edit', ['data' => $data]);
    }

    

    public function create() {
        return view('students.create')->with('title', 'Add New');

    }

    public function store(Request $request) {

        $validated = $request->validate([
            "first_name" => ['required', 'min:4'],
            "last_name" => ['required', 'min:4'],
            "email" => ['required', 'email', Rule::unique('students', 'email')],
            "gender" => ['required'],
            "age" => ['required'],

        ]);

        Students::create($validated);

        return redirect('/')->with('message', 'New student has been added.')->with('color', 'green');

    }

    public function update(Request $request, Students $student) {

        try {
            
            $validated = $request->validate([
                "first_name" => ['required', 'min:4'],
                "last_name" => ['required', 'min:4'],
                "email" => ['required', 'email'],
                "gender" => ['required'],
                "age" => ['required'],
    
            ]);
    
            $student->update($validated);
    
            return back()->with('message', 'Data has been updated.')->with('color', 'green');
            //code...
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
