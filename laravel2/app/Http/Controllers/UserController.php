<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return 'Hello from UserController';
    }

    public function show($id) {

        $data = array(
            "id" => $id,
            "name" => "PinayCode",
            "age" => 23,
            "email" => "echibot1@gmail.com"
        );

        // return view('user', ['data' => $data]);

        return view('user', $data);
    }

    public function show2($id) {

        $data = ['sampleData' => 'data from db'];
        return view('user')
                    ->with('data', $data)
                    ->with('name', 'Carlos Agasi')
                    ->with('age', 22)
                    ->with('email', 'echibot1@gmail.com')
                    ->with('id', $id);
    }
}


