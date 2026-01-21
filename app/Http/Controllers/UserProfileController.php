<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Gender;
use App\Models\Title;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function create()
    {
        // prevent duplicate profile
        if (Auth::user()->profile) {
            return redirect()->route('dashboard');
        }

        return view('profile.create', [
            'countries' => Country::orderBy('name')->get(),
            'genders'   => Gender::all(),
            'titles'    => Title::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_id'          => 'required|exists:titles,id',
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'previous_names'    => 'nullable|string|max:255',
            'primary_contact'   => 'required|string|max:50',
            'secondary_contact' => 'nullable|string|max:50',
            'gender_id'         => 'required|exists:genders,id',
            'nationality_id'    => 'required|exists:countries,id',
            'country_id'        => 'required|exists:countries,id',
            'national_id_number'=> 'nullable|string|max:50',
        ]);

        UserProfile::create([
            'user_id'           => Auth::id(),
            'title_id'          => $request->title_id,
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'previous_names'    => $request->previous_names,
            'primary_contact'   => $request->primary_contact,
            'secondary_contact' => $request->secondary_contact,
            'gender_id'         => $request->gender_id,
            'nationality_id'    => $request->nationality_id,
            'country_id'        => $request->country_id,
            'national_id_number'=> $request->national_id_number,
        ]);

         Auth::user()->application->update([
        'current_step' => 'details'
    ]);

        return redirect()->route('dashboard')
            ->with('success', 'Profile completed successfully.');
    }
}
