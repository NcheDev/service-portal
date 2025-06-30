<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 use App\Models\Application;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
 //
    class AdminController extends Controller
{
    public function index()
    {

          
        return view('index'); // Make sure this view exists
    }

   
public function dashboard()
{
    $startOfWeek = Carbon::now()->startOfWeek();
    $startOfMonth = Carbon::now()->startOfMonth();

    $newApplications = Application::where('created_at', '>=', $startOfWeek)->count();

    // You can define "completed" how you want — example: applications with non-null 'processed_at' or status updated
    $completedApplications = Application::whereNotNull('processed_at')->count();

    $approvedApplications = Application::where('status', 'valid')
        ->where('created_at', '>=', $startOfMonth)
        ->count();

    $rejectedApplications = Application::where('status', 'invalid')
        ->where('created_at', '>=', $startOfMonth)
        ->count();

    return view('admin-dashboard', compact(
        'newApplications',
        'completedApplications',
        'approvedApplications',
        'rejectedApplications'
    ));

}
}