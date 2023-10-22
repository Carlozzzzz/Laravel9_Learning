<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductControler extends Controller
{
    public function index() 
    {
        $products = Product::with('category')->get();

        return view("products.index", compact("products"));
    }
}
