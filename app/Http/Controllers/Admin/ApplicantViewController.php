<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;    

class ApplicantViewController extends Controller
{
    public function all()
    {
        $users = User::paginate(15);
        return view('admin.applicants.all', compact('users'));
    }

    public function validated()
    {
        $users = User::where('status', 'validated')->paginate(15);
        return view('admin.applicants.validated', compact('users'));
    }

    public function pending()
    {
        $users = User::where('status', 'pending')->paginate(15);
        return view('admin.applicants.pending', compact('users'));
    }

    public function rejected()
    {
        $users = User::where('status', 'rejected')->paginate(15);
        return view('admin.applicants.invalid', compact('users'));
    }
}
