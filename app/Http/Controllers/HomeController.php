<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }
    public function check(Request $request)
    {
        $data = $request->all();
        // Process the data as needed
        return view('home.result', compact('data'));
    }
}
