<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PersonalInformation;
use Illuminate\Database\QueryException;

class PersonalInformationController extends Controller
{
    public function show()
{
    $user = auth()->user();
    return view('users.profile', compact('user'));
}

    public function showForm()
    {
        $user = Auth::user();
        $personalInfo = PersonalInformation::where('user_id', $user->id)->first();

        return view('user.personal-information', [
            'personalInfo' => $personalInfo,
        ]);
    }

public function storeOrUpdate(Request $request)
{
    try {

        $user = Auth::user();

        // Validate all input
        $validated = $request->validate([
            // USER FIELDS
            'first_name'         => 'required|string|max:255',
            'surname'            => 'required|string|max:255',
            'email'              => 'required|email|max:255',

            // PERSONAL INFO FIELDS
            'physical_address'   => 'required|string|max:255',
            'contact_address'    => 'required|string|max:255',
            'gender'             => 'required|string|in:Male,Female',
            'profile_picture'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cover_photo'        => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'country'            => 'nullable|string|max:100',
            'date_of_birth'      => 'nullable|date',
            'title'              => 'nullable|string|max:100',
            'national_id_number' => 'nullable|string|max:100',
            'application_type'   => 'required|in:Individual,Institution',

            'institution_name'   => 'nullable|required_if:application_type,Institution|string|max:255',

            'primary_phone'        => ['required','regex:/^\+?[0-9]{8,15}$/'],
            'secondary_phone'      => 'nullable|string|regex:/^\+?[0-9]{8,15}$/',
            'primary_country_code' => 'required|string',

            'institution_position' => 'required_if:application_type,Institution|string|max:255|nullable',
            'nationality'          => 'required|string|max:100',
        ]);

        /* --------------------------
         * UPDATE USER TABLE
         * -------------------------- */

        $user->update([
            'first_name' => $validated['first_name'],
            'surname'    => $validated['surname'],
            'email'      => $validated['email'],
        ]);

        /* --------------------------
         * PREPARE PERSONAL INFO DATA
         * (ONLY the fields that belong here)
         * -------------------------- */
        $personalData = collect($validated)->except([
            'first_name',
            'surname',
            'email',
        ])->toArray();

        $personalInfo = PersonalInformation::updateOrCreate(
            ['user_id' => $user->id],
            $personalData
        );

        /* --------------------------
         * FILE UPLOADS
         * -------------------------- */
        if ($request->hasFile('profile_picture')) {
            $personalInfo->profile_picture = $request->file('profile_picture')
                ->store('profile_pictures', 'public');
        }

        if ($request->hasFile('cover_photo')) {
            $personalInfo->cover_photo = $request->file('cover_photo')
                ->store('cover_photos', 'public');
        }

        $personalInfo->save();

        return redirect()->back()->with('success', 'Personal information saved successfully!');

    } catch (\Throwable $e) {
        // Log the error (optional)
        \Log::error("Personal Info Save Error", ['error' => $e->getMessage()]);

        return redirect()->route('error.database')
            ->with('error', 'A database error occurred while saving your information.');
    }
}





 

}
