<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class PagesController extends Controller
{
   
    public function showabout()
    {
        return view('about');
    }

    public function contactus()
    {
        return view('contactus');
    }
}
