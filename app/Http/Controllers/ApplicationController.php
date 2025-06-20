<?php
// app/Http/Controllers/ApplicationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Qualification;
use App\Models\EducationHistory;
use App\Models\Document;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'processing_type' => 'required',
            'nationality' => 'required',
            'qualifications.*.name' => 'required',
            'qualifications.*.year' => 'required|integer',
            'qualifications.*.institution' => 'required',
            'qualifications.*.country' => 'required',
     'education_histories' => 'required|array|min:1',
    'education_histories.*.name' => 'required|string|max:255',
    'education_histories.*.year' => 'required|digits:4',
    'education_histories.*.institution' => 'required|string|max:255',
    'education_histories.*.country' => 'required|string|max:255',
            'consent_form' => 'required|mimes:pdf|max:2048',

    
 
            'documents.*' => 'file|max:5120', // optional uploads, max 5MB
        ]);

        // Create Application
        $application = Application::create([
            'user_id' => Auth::id(),
            'processing_type' => $request->processing_type,
            'nationality' => $request->nationality,
        ]);
// Save Qualifications
if ($request->has('qualifications') && is_array($request->qualifications)) {
    foreach ($request->qualifications as $qualificationData) {
        Qualification::create([
            'application_id' => $application->id,
            'user_id' => Auth::id(),
            'name' => $qualificationData['name'],
            'year' => $qualificationData['year'],
            'institution' => $qualificationData['institution'],
            'country' => $qualificationData['country'],
        ]);
    }
}


// Save Education Histories
 

if ($request->has('education_histories') && is_array($request->education_histories)) {
    foreach ($request->education_histories as $edu) {
        $application->educationHistories()->create($edu);
    }
}
// Handle consent form
    if ($request->hasFile('consent_form')) {
        $file = $request->file('consent_form');
        $path = $file->store('consent_forms', 'public');

        // Optionally store in DB
        Document::create([
            'application_id' => $application->id,
            'type' => 'consent_form',
            'file_path' => $path,
        ]);
    }

//save documents
       $documentTypes = ['certificates', 'academic_records', 'previous_evaluations', 'syllabi',];

foreach ($documentTypes as $type) {
    if ($request->hasFile($type)) {
        foreach ($request->file($type) as $file) {
            $path = $file->store('documents','public');
            $application->documents()->create([
                'type' => $type,
                'file_path' => $path,
            ]);
        }
    }
}


        // Create Invoice
        $invoice = Invoice::create([
            'application_id' => $application->id,
            'user_id' => Auth::id(),
            'invoice_number' => 'INV-' . now()->timestamp . '-' . rand(1000, 9999),
            'processing_type' => $application->processing_type,
            'fee' => $application->processing_type === 'standard' ? 100 : 200,
        ]);

        return redirect()->route('invoices.show', $invoice->id);
    }
  public function showForm()
{
    return view('application'); // or whatever your Blade file is
}
    public function create()
    {
        return view('application'); // Return the view for creating an application
    }
    public function uploadConsentForm(Request $request)
{
    $request->validate([
        'consent_form' => 'required|mimes:pdf|max:2048',
    ]);

    $user = auth()->user();

    $path = $request->file('consent_form')->store('consent_forms', 'public');

    // Optionally link it to application or user
    Document::create([
'application_id' => $user->application()->latest()->first()?->id,
        'type' => 'consent_form',
        'file_path' => $path,
    ]);

    return back()->with('success', 'Consent form uploaded successfully.');
}

 public function myApplications()
{
    // Get the currently logged-in user
    $user = Auth::user();

    // If user is not logged in, redirect or abort
    if (!$user) {
        return redirect()->route('login')->with('error', 'You must be logged in to view your applications.');
    }

    // Fetch all applications for this user (latest first)
    $applications = Application::where('user_id', $user->id)
                               ->latest()
                               ->get();

    // Count the applications
    $applicationCount = $applications->count();

    // Pass to view
    return view('user.my-applications', compact('applications', 'applicationCount'));
}
public function show($id)
{
    $application = Application::with([
        'documents', // assuming documents table has certificate, proof of payment, consent
        'invoice',   // assuming you linked invoice to application
    ])->findOrFail($id);

    // Optional: Only allow user to view their own application
    if (auth()->id() !== $application->user_id) {
        abort(403, 'Unauthorized action.');
    }
    return view('user.application-details', compact('application'));
}



}
