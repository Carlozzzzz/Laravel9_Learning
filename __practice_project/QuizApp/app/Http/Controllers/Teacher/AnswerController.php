<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function delete(Answer $answer)
    {
        $answerData = $answer->delete();

        $xretobj["message"] = "Choice answer deleted successfully!";

        return response()->json($xretobj, 200);
    }
}
