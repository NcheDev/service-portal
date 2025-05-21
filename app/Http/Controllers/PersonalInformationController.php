<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PersonalInformation;

class PersonalInformationController extends Controller
{
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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'physical_address' => 'required|string|max:255',
            'contact_address' => 'required|string|max:255',
            'gender' => 'required|string',
            'personal_statement' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'national_id' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        $personalInfo = PersonalInformation::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // Handle file uploads
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $personalInfo->profile_picture = $path;
        }

        if ($request->hasFile('cover_photo')) {
            $path = $request->file('cover_photo')->store('cover_photos', 'public');
            $personalInfo->cover_photo = $path;
        }

       if ($request->hasFile('national_id')) {
    $path = $request->file('national_id')->store('national_ids', 'public');
    $personalInfo->national_id_path = $path; // ✅ Save to the correct DB column
}


        $personalInfo->save();


    // ✅ Add success flash message and redirect back
    

   return response()->json([
    'message' => 'Personal information saved successfully!'
]);

}

}
