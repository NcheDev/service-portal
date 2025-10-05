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

    $data = $request->validate([
        'first_name'         => 'required|string|max:255',
        'surname'            => 'required|string|max:255',
        'email'              => 'required|email|max:255',
        'physical_address'   => 'required|string|max:255',
        'contact_address'    => 'required|string|max:255',
        'gender'             => 'required|string|in:Male,Female',
        'profile_picture'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'cover_photo'        => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
        'country'            => 'nullable|string|max:100',
        'date_of_birth'      => 'nullable|date',
        'next_of_kin'        => 'nullable|string|max:255',
        'title'              => 'nullable|string|max:100',
        'national_id_number' => 'nullable|string|max:100',
        'kin_contact'        => 'nullable|string|max:15',
    ]);

    $personalInfo = PersonalInformation::updateOrCreate(
        ['user_id' => $user->id],
        $data
    );

    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $personalInfo->profile_picture = $path;
    }

    if ($request->hasFile('cover_photo')) {
        $path = $request->file('cover_photo')->store('cover_photos', 'public');
        $personalInfo->cover_photo = $path;
    }

    $personalInfo->save();

   

    // ✅ If normal form submit -> redirect with success message
    return redirect()
        ->back()
        ->with('success', 'Personal information saved successfully!');
}


 

}
