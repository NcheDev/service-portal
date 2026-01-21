<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $applications = Application::with([
            'individualApplication',
            'institutionApplication.contacts',
            'documents'
        ])
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

        return view('dashboard.index', compact('applications'));
    }
}
