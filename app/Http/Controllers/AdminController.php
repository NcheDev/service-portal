<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

 //
    class AdminController extends Controller
{
    public function index()
    {

          
        return view('index'); // Make sure this view exists
    }
}
