<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Country;
use App\Models\InstitutionApplication;
use App\Models\InstitutionContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstitutionApplicationController extends Controller
{
    /**
     * Show institution application form
     */
    public function create(Application $application)
    {
        if ($application->application_type !== 'institution') {
            abort(403);
        }

        return view('applications.institution.create', [
            'application' => $application,
            'countries'   => Country::orderBy('name')->get(),
        ]);
    }

    /**
     * Store institution application and contacts
     */
    public function store(Request $request, Application $application)
    {
        if ($application->application_type !== 'institution') {
            abort(403);
        }

        $request->validate([
            'institution_name'      => 'required|string|max:255',
            'registration_number'   => 'nullable|string|max:100',
            'country_id'            => 'required|exists:countries,id',
            'contacts.*.first_name' => 'required|string|max:255',
            'contacts.*.last_name'  => 'required|string|max:255',
            'contacts.*.phone'      => 'required|string|max:50',
            'contacts.*.nationality_id' => 'required|exists:countries,id',
        ]);

        // Create institution record
        $institution = InstitutionApplication::create([
            'application_id'      => $application->id,
            'institution_name'    => $request->institution_name,
            'registration_number' => $request->registration_number,
            'country_id'          => $request->country_id,
        ]);

        // Create contacts
        foreach ($request->contacts as $contact) {
            InstitutionContact::create([
                'institution_application_id' => $institution->id,
                'first_name'                 => $contact['first_name'],
                'last_name'                  => $contact['last_name'],
                'phone'                      => $contact['phone'],
                'nationality_id'             => $contact['nationality_id'],
            ]);
        }

        // Keep application draft for document upload
        $application->update(['status' => 'draft']);

        return redirect()->route('applications.documents.create', $application)
                         ->with('success', 'Institution details saved. Upload documents next.');
    }
    public function show(Application $application)
    {
        // Security: user can only view own application
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        // Ensure it's an institution application
        if ($application->application_type !== 'institution') {
            abort(404);
        }

        $application->load([
            'institutionApplication.country',
            'institutionApplication.contacts.nationality',
            'documents'
        ]);
         $application->update([
        'current_step' => 'documents'
    ]);


        return view('applications.institution.show', compact('application'));
    }
}
