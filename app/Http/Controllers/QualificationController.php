<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Add this
use App\Models\Application; 

class QualificationController extends Controller
{
    public function create()
{
    return view('user.applicationform'); // update with your actual view path
}


    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email',
            'nationality' => 'required|in:local,foreigner',
            'qualification_type' => 'required',
            'processing_type' => 'required|in:normal,express',
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'document_descriptions.*' => 'required|string'
        ]);

        $application = Application::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'nationality' => $request->nationality,
            'qualification_type' => $request->qualification_type,
            'processing_type' => $request->processing_type,
        ]);

        foreach ($request->file('documents') as $index => $file) {
            $path = $file->store('applications/documents', 'public');
            $description = $request->document_descriptions[$index];

            $application->documents()->create([
                'file_path' => $path,
                'description' => $description,
            ]);
        }

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }
}
