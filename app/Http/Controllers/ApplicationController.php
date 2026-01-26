<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApplicationController extends Controller
{
     use AuthorizesRequests;
    /**
     * Show application type selection
     */
   public function create()
{
    return view('applications.create');
}

public function store(Request $request)
{
    $request->validate([
        'application_type' => 'required|in:individual,institution',
        'processing_type'  => 'required|in:normal,express',
    ]);

    $application = Application::create([
        'user_id'          => Auth::id(),
        'application_type' => $request->application_type,
        'processing_type'  => $request->processing_type,
        'status'           => 'draft',
        'current_step'     => 'details', // ✅ Add this to start tracking
    ]);

    if ($application->application_type === 'individual') {
        return redirect()->route('applications.individual.create', $application);
    }

    return redirect()->route('applications.institution.create', $application);
}

    /**
     * Store application and redirect
     */
    

    /**
     * List all individual applications for current user
     */
    public function individualIndex()
{
    $applications = Application::where('user_id', Auth::id())
        ->where('application_type', 'individual')
        ->with(['individualApplication', 'documents', 'individualApplication.nationality'])
        ->get();

    return view('applications.individual.index', compact('applications'));
}

public function institutionIndex()
{
    $applications = Application::where('user_id', Auth::id())
        ->where('application_type', 'institution')
        ->with([
            'institutionApplication.contacts.nationality',
            'institutionApplication.country',
            'documents'
        ])
        ->get();

    return view('applications.institution.index', compact('applications'));
}


    /**
     * Show a single application (optional generic, or can use separate controllers)
     */
    public function show(Application $application)
    {
        $this->authorize('view', $application); // make sure you have a policy
        return view('applications.show', compact('application'));
    }

   

public function preview(Application $application)
{
    if ($application->user_id !== Auth::id()) {
        abort(403);
    }

    $application->load([
        'individualApplication.nationality',
        'institutionApplication.country',
        'institutionApplication.contacts.nationality',
        'documents'
    ]);

    return view('applications.preview', compact('application'));
}


public function submit(Application $application)
{
    if ($application->user_id !== Auth::id()) {
        abort(403);
    }

    if ($application->documents()->count() === 0) {
        return back()->with('error', 'You must upload at least one document.');
    }

    $application->update([
        'current_step' => 'submitted', // ✅ track step
        'status' => 'submitted',
        'submitted' => true,           // ✅ optional boolean
    ]);

    return redirect()
    ->route('applications.preview', $application)
    ->with('success', 'Application submitted successfully. You will be notified after review.');

}

public function resume(Application $application)
{
    if ($application->user_id !== auth()->id()) {
        abort(403);
    }

    return match ($application->current_step) {
        'profile'   => redirect()->route('profile.create'),
        'details'   => $application->application_type === 'individual'
                        ? redirect()->route('applications.individual.create', $application)
                        : redirect()->route('applications.institution.create', $application),
        'documents' => redirect()->route('applications.documents.create', $application),
        'preview'   => redirect()->route('applications.preview', $application),
        default     => redirect()->route('dashboard'),
    };
}


}
