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
        $application->qualifications()->create($qualificationData);
    }
}


// Save Education Histories
 

if ($request->has('education_histories') && is_array($request->education_histories)) {
    foreach ($request->education_histories as $edu) {
        $application->educationHistories()->create($edu);
    }
}
//save documents
       $documentTypes = ['certificates', 'academic_records', 'previous_evaluations', 'syllabi'];

foreach ($documentTypes as $type) {
    if ($request->hasFile($type)) {
        foreach ($request->file($type) as $file) {
            $path = $file->store('documents');
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

}
