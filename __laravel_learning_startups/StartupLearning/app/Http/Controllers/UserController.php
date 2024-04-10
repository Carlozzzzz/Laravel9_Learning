<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return 'Hello from user controller.';
    }

    public function show($id) {

        $data = array(
            "id" => $id,
            "name" => 'CarlosDev1',
            "age" => 23,
            "email" => "echibot1@gmail.com"
        );

        // return view('user', $data);
        return view('user')
            ->with('data', $data)
            ->with('name', 'CarlosDev')
            ->with('age', 22)
            ->with('email', 'carlos@gmail.com');
    }
}
