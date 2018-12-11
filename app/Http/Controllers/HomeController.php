<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * HomeController Class handle requesting user home page.
 * @package App\Http\Controllers
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
