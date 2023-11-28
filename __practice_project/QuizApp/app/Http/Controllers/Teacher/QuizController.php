<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizStoreRequest;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class QuizController extends Controller
{
    public function index()
    {
        $page = "index";
        
        Alert::alert('Error', 'error');

        if(View::exists($page)) {
            $data = array();
            $data['title'] = "Quiz";
            $data['page'] = "Quiz";

            $xdata = Quiz::where('user_id', Auth::user()->id)->get();

            $data["data_datarecordfile"] = $xdata;
            $data["data_dataactivepage"] = "dashboard";

            return view($page, $data);

        } return abort(404);
    }

    public function create()
    {
        $page = "teacher.quiz.add_edit";
        if(View::exists($page)) {
            $data = array();
            $data['title'] = "Quiz";
            $data['page'] = "Quiz";

            $data["data_dataactivepage"] = "teacher_quiz";
            return view($page, $data);

        } return abort(404);
    }

    public function store(QuizStoreRequest $request)
    {
        $data = array();

        $validated = $request->validated();
        
        $user = User::find(Auth::id());

        $data['title'] = "Quiz";
        $data['page'] = "Quiz";
        
        $data['data_datarecordfile'] = $user->quizzes()->createQuietly($validated);

        $quizId = $data['data_datarecordfile']->id;

        // dd($data);

        return redirect()
                ->route('quiz.edit', $quizId)
                ->with($data)
                ->with("message", "New Quiz has been created.");

    }

    public function edit(Quiz $quiz)
    {
        $page = "teacher.quiz.add_edit";
        if(View::exists($page)) {
            $data = array();
            $data['title'] = "Quiz";
            $data['page'] = "Quiz";
            
            $data["data_dataactivepage"] = "teacher_quiz";
            $data["data_datarecordfile"] =  $quiz;
            return view($page, $data);

        } return abort(404);
    }

    public function update(Quiz $quiz, QuizStoreRequest $request)
    {
        $validated = $request->validated();
        
        $quiz->update($validated);

        $data['data_datarecordfile'] = $quiz;

        $quizId =$data['data_datarecordfile']->id;

        return redirect()
                ->route('quiz.edit', $quizId)
                ->with(compact($data))
                ->with("message", "Quiz has been updated.");

    }
}
