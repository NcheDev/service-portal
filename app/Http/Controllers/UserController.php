<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function dashboard()
    {
        return view('dashboard'); // Make sure this view exists
    }
    //
}
