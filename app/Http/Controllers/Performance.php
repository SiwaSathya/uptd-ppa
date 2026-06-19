<?php

 namespace App\Http\Controllers;
 use App\Http\Controllers\Controller;
 use Illuminate\View\View;

class Performance extends Controller
{
    /**
     * Show the profile for a given user.
     */
    public function index()
    {
        return view('performance');
    }
}
