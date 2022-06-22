<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        return view('index');
    }
}
