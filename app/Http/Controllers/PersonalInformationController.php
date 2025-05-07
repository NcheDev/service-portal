<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PersonalInformationController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();
        $personalInfo = PersonalInformation::where('user_id', $user->id)->first();
    
        return view('user.personal-information', [
            'personalInfo' => $personalInfo,
            'isEdit' => $personalInfo != null,
            'preview' => false,
        ]);
    }
    
    


public function storeOrUpdate(Request $request)
{
    $user = Auth::user(); // Get the currently logged-in user

    // Define validation rules
    $rules = [
        'full_name' => 'required|string|max:255',
        'contact_address' => 'required|string|max:255',
        'physical_address' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'personal_statement' => 'required|string',
        'national_id' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ];

    // Perform validation
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    try {
        // Retrieve existing record (if any)
        $personalInfo = PersonalInformation::where('user_id', $user->id)->first();

        // Handle file upload
        $nationalIdPath = $personalInfo->national_id_path ?? null;
        if ($request->hasFile('national_id')) {
            $nationalIdPath = $request->file('national_id')->store('national_ids', 'public');
        }

        // Prepare data for update or creation
        $data = [
            'full_name' => $request->input('full_name'),
            'contact_address' => $request->input('contact_address'),
            'physical_address' => $request->input('physical_address'),
            'email' => $request->input('email'),
            'personal_statement' => $request->input('personal_statement'),
            'national_id_path' => $nationalIdPath,
            'user_id' => $user->id,
        ];

        if ($personalInfo) {
            $personalInfo->update($data);
        } else {
            $personalInfo = PersonalInformation::create($data);
        }

        // Return AJAX or redirect response
        if ($request->ajax()) {
            $html = view('user.personal-information', [
                'personalInfo' => $personalInfo,
                'isEdit' => true,
                'preview' => true,
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        return redirect()->route('personal.info')->with('success', 'Information saved successfully.');
    } catch (\Exception $e) {
        Log::error('Error saving personal information: ' . $e->getMessage());

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while saving your information.'
            ], 500);
        } else {
            return redirect()->back()->with('error', 'An unexpected error occurred while saving your information.');
        }
    }
}

    
    
    
}
