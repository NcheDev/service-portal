<?php

namespace App\Http\Controllers;

use App\Models\Verification;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function showForm()
    {
        return view('user.register');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|regex:/^[0-9]{10,15}$/',
            'address' => 'required|string',
            'school' => 'required|string',
            'qualification_level' => 'required|string',
            'other_qualification' => 'nullable|string',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'certificates.*' => 'file|mimes:jpg,jpeg,png,pdf',
        ]);

        // Store files
        $paymentPath = $request->file('payment_proof')->store('payments', 'public');

        $certificatePaths = [];
        if ($request->hasFile('certificates')) {
            foreach ($request->file('certificates') as $file) {
                $certificatePaths[] = $file->store('certificates', 'public');
            }
        }

        // Save to database
        Verification::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'school' => $request->school,
            'qualification_level' => $request->qualification_level,
            'other_qualification' => $request->other_qualification,
            'payment_proof' => $paymentPath,
            'certificates' => json_encode($certificatePaths),
        ]);

        return back()->with('success', 'Your form was submitted successfully!');
    }
}
