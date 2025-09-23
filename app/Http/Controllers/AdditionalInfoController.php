<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\AdditionalInfoRequest;
use Illuminate\Http\Request;
use App\Notifications\AdditionalInfoNotification;

class AdditionalInfoController extends Controller
{
    // Admin requests additional info from applicant
public function requestInfo(Request $request, Application $application)
{
    $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    $infoRequest = AdditionalInfoRequest::create([
        'application_id' => $application->id,
        'requested_by'   => auth()->id(),
        'message'        => $request->message,
        'status'         => 'pending'
    ]);

    // Return just the HTML for the new message
    $messageHtml = view('partials.additional-info-message', ['req' => $infoRequest])->render();

    return response()->json([
        'success' => true,
        'message_html' => $messageHtml
    ]);
}




    // User responds to info request
    public function respondInfo(Request $request, AdditionalInfoRequest $infoRequest)
    {
        $request->validate([
            'response' => 'required|string|max:1000',
            'response_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = $infoRequest->response_file_path;
        if ($request->hasFile('response_file')) {
            $filePath = $request->file('response_file')->store('responses', 'public');
        }

        $infoRequest->update([
            'response'           => $request->response,
            'response_file_path' => $filePath,
            'status'             => 'responded',
        ]);

        $application = $infoRequest->application;
        $url = route('admin.applicants.viewApplication', [
            'user' => $application->user_id,
            'application' => $application->id
        ]);

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new AdditionalInfoNotification(
                "User has responded to your request for additional info.",
                $url
            ));
        }

        \Log::info("Additional info response submitted for application ID {$application->id} by user ID {$application->user_id}");

        return back()->with('success', 'Response submitted successfully and admins have been notified.');
    }

    // Admin view: chat interface for a single application
    public function chat(Application $application)
    {
        $messages = AdditionalInfoRequest::where('application_id', $application->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.additional-info-chat', compact('application', 'messages'));
    }
}
