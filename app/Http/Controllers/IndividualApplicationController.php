<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Country;
use App\Models\IndividualApplication;
use Illuminate\Http\Request;

class IndividualApplicationController extends Controller
{
    /**
     * Show individual application form
     */
    public function create(Application $application)
    {
        // safety: ensure correct type
        if ($application->application_type !== 'individual') {
            abort(403);
        }

        return view('applications.individual.create', [
            'application' => $application,
            'countries'   => Country::orderBy('name')->get(),
        ]);
    }

    /**
     * Store individual application
     */
    public function store(Request $request, Application $application)
    {
        if ($application->application_type !== 'individual') {
            abort(403);
        }

        $request->validate([
            'studied_at'        => 'required|string|max:255',
            'qualification_name'=> 'required|string|max:255',
            'award'             => 'required|string|max:255',
            'nationality_id'    => 'required|exists:countries,id',
        ]);

        IndividualApplication::create([
            'application_id'     => $application->id,
            'studied_at'         => $request->studied_at,
            'qualification_name' => $request->qualification_name,
            'award'              => $request->award,
            'nationality_id'     => $request->nationality_id,
        ]);
 $application->update([
        'current_step' => 'documents'
    ]);

        return redirect()
            ->route('applications.documents.create', $application)
            ->with('success', 'Individual application details saved.');
    }
}
