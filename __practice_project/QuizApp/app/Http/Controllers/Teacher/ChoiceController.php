<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    public function delete(Choice $choice)
    {
        $choiceData = $choice->delete();

        $xretobj["message"] = "Choice answer deleted successfully!";

        return response()->json($xretobj, 200);
    }
}
