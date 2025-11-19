<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PersonalInformation;

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
    $user = Auth::user();

    // Validate all input
    $data = $request->validate([
        // USER TABLE FIELDS
        'first_name'         => 'required|string|max:255',
        'surname'            => 'required|string|max:255',
        'email'              => 'required|email|max:255',

        // PERSONAL INFO TABLE FIELDS
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
        'primary_phone'      => 'required|string|regex:/^\+?[0-9]{8,15}$/',
        'secondary_phone'    => 'nullable|string|regex:/^\+?[0-9]{8,15}$/',
        'primary_country_code' => 'required|string',
        'institution_position' => 'required_if:application_type,Institution|string|max:255|nullable',
        'nationality'        => 'required|string|max:100',
    ]);

    /* ------------------------------------------------------
     | 1️⃣ UPDATE USER TABLE (first_name, surname, email)
     ------------------------------------------------------ */
    $user->update([
        'first_name' => $data['first_name'],
        'surname'    => $data['surname'],
        'email'      => $data['email'],
    ]);

    /* ------------------------------------------------------
     | 2️⃣ REMOVE user table fields before saving to personal_info
     ------------------------------------------------------ */
    unset($data['first_name'], $data['surname'], $data['email']);

    /* ------------------------------------------------------
     | 3️⃣ UPDATE OR CREATE personal_information RECORD
     ------------------------------------------------------ */
    $personalInfo = PersonalInformation::updateOrCreate(
        ['user_id' => $user->id],
        $data
    );

    /* ------------------------------------------------------
     | 4️⃣ HANDLE FILE UPLOADS
     ------------------------------------------------------ */
    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $personalInfo->profile_picture = $path;
    }

    if ($request->hasFile('cover_photo')) {
        $path = $request->file('cover_photo')->store('cover_photos', 'public');
        $personalInfo->cover_photo = $path;
    }

    $personalInfo->save();

    return redirect()->back()->with('success', 'Personal information saved successfully!');
}



 

}
