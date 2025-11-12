<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Document;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Models\EducationHistory;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\Auth;
use App\Models\AdditionalInfoRequest;
use App\Notifications\ResponseReportUploaded;
use App\Notifications\AdditionalInfoNotification;
use Carbon\Carbon;

 

class ApplicationController extends Controller
{
    public function showForm()
    {
        return view('application');
    }

    public function create()
    {
        return view('application');
    }

 public function store(Request $request)
{
    $request->validate([
        'processing_type' => 'required|in:normal,express',

        // Qualifications
        'qualifications' => 'required|array|min:1',
        'qualifications.*.name' => 'required|string',
        'qualifications.*.program_name' => 'required|string|max:255',
        'qualifications.*.year' => 'required|digits:4',
        'qualifications.*.institution' => 'required|string|max:255',
        'qualifications.*.country' => 'required|string|max:255',
        'qualifications.*.custom_name' => 'nullable|required_if:qualifications.*.name,Other|string|max:255',
        'qualifications.*.merit' => 'nullable|string|max:255',
        

        // Files
        'certificates' => 'required|array|min:1',
        'certificates.*' => 'file|mimes:pdf,png,jpg,jpeg,|max:4096',
        'academic_records.*' => 'file|mimes:pdf,png,jpg,jpeg|max:4096',
        'previous_evaluations.*' => 'file|mimes:pdf,png,jpg,jpeg|max:4096',
        'syllabi.*' => 'file|mimes:pdf,png,jpg,jpeg|max:4096',

        'consent_agree' => 'accepted',
    ]);

    // Create Application
   $application = Application::create([
    'user_id' => Auth::id(),
    'processing_type' => $request->processing_type,
    'consent_agree' => $request->has('consent_agree'), 
]);

    // Save Qualifications
    foreach ($request->qualifications as $qualificationData) {
        Qualification::create([
            'application_id' => $application->id,
            'user_id' => Auth::id(),
            'name' => $qualificationData['name'],
            'custom_name' => $qualificationData['custom_name'] ?? null,
            'program_name' => $qualificationData['program_name'],
            'year' => $qualificationData['year'],
            'institution' => $qualificationData['institution'],
            'country' => $qualificationData['country'],
            'merit' => $qualificationData['merit'] ?? null,
        ]);
    }

    

    // Save Other Uploaded Documents
    foreach (['certificates', 'academic_records', 'previous_evaluations', 'syllabi'] as $type) {
        if ($request->hasFile($type)) {
            foreach ($request->file($type) as $file) {
                $path = $file->store('documents', 'public');
                $application->documents()->create([
                    'type' => $type,
                    'file_path' => $path,
                ]);
            }
        }
    }  
 return view('user.success', [
        'application' => $application
    ]);
}


 
    public function myApplications()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view your applications.');
        }

        $applications = Application::where('user_id', $user->id)->latest()->get();
        $applicationCount = $applications->count();

        return view('user.my-applications', compact('applications', 'applicationCount'));
    }

    public function show($id)
    {
        $application = Application::with([
            'documents',
            'invoice',
        ])->findOrFail($id);

        if (auth()->id() !== $application->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.application-details', compact('application'));
    }

    public function generateValidationLetter($applicationId)
    {
        $application = Application::with(['user.personalInfo', 'qualifications'])->findOrFail($applicationId);

        $user = $application->user;
        $qualification = $application->qualifications->first(); // Adjusted for multiple

        $data = [
            'user' => $user,
            'name' => $user->full_name,
            'care_of' => $user->care_of ?? 'N/A',
            'employer_address' => $user->employer_address ?? 'N/A',
            'box_number' => $user->box_number ?? '---',
            'city' => $user->city ?? '---',
            'qualification_name' => $qualification->name ?? 'N/A',
            'institution' => $qualification->institution ?? 'N/A',
            'country' => $qualification->country ?? 'N/A',
            'award_date' => $qualification ? \Carbon\Carbon::parse($qualification->year)->format('jS F, Y') : 'N/A',
            'salutation' => optional($user->personalInfo)->gender === 'female' ? 'Madam' : 'Sir',
            'date' => now()->format('jS F, Y'),
        ];

        $pdf = Pdf::loadView('pdfs.validation_letter', $data);

        return $pdf->download("Validation_Letter_{$user->full_name}.pdf");
    }
    public function showAdditionalInfoChat(Application $application)
{
    // Return the chat view
    return view('admin.additional-info-chat', compact('application'));
}

public function requestInfo(Request $request, Application $application)
{
    $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    // Create the request
    $infoRequest = AdditionalInfoRequest::create([
        'application_id' => $application->id,
        'requested_by'   => auth()->id(), // admin id
        'message'        => $request->message,
        'status'         => 'pending',
    ]);

    // Notify the applicant
    $user = $application->user; // applicant
    $user->notify(new AdditionalInfoNotification(
        "Admin has requested additional info: {$request->message}",
        route('user.application.details', $application->id)
    ));

    return back()->with('success', 'Request for additional info sent.');
}

 

public function respondInfo(Request $request, AdditionalInfoRequest $infoRequest)
{
    // Validate user input
    $request->validate([
        'response' => 'required|string|max:1000',
        'response_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
    ]);

    // Handle file upload if present
    $filePath = $infoRequest->response_file_path;
    if ($request->hasFile('response_file')) {
        $filePath = $request->file('response_file')->store('responses', 'public');
    }

    // Update the info request record
    $infoRequest->update([
        'response'           => $request->response,
        'response_file_path' => $filePath,
        'status'             => 'responded',
    ]);

    // Retrieve the related application and applicant
    $application = $infoRequest->application;

    // Generate a URL for admins to view the application
    $url = route('admin.applicants.viewApplication', [
        'user' => $application->user_id,       // matches {user} in the route
        'application' => $application->id     // matches {application} in the route
    ]);

    // Notify all admin users
    $admins = \App\Models\User::where('role', 'admin')->get();

    foreach ($admins as $admin) {
        $admin->notify(new \App\Notifications\AdditionalInfoNotification(
            "User has responded to your request for additional info.",
            $url
        ));
    }

    // Optional: Log for auditing purposes
    \Log::info("Additional info response submitted for application ID {$application->id} by user ID {$application->user_id}");

    return back()->with('success', 'Response submitted successfully and admins have been notified.');
}

public function pendingCount(Application $application)
{
    $pending = $application->additionalInfoRequests()->where('status', 'pending')->count();
    return response()->json(['pending' => $pending]);
}



public function userDashboard()
{
    $userId = Auth::id();
    $startOfMonth = Carbon::now()->startOfMonth();

    // All applications for this user
    $allApplications = Application::where('user_id', $userId)->count();

    // Approved / Validated
    $approvedApplications = Application::where('user_id', $userId)
        ->where('status', 'validated')
        ->count();

    // Pending
    $pendingApplications = Application::where('user_id', $userId)
        ->where('status', 'pending')
        ->count();

    // Rejected / Unrecognized
    $rejectedApplications = Application::where('user_id', $userId)
        ->where('status', 'invalid')
        ->count();

    return view('user.dashboard', compact(
        'allApplications',
        'approvedApplications',
        'pendingApplications',
        'rejectedApplications'
    ));
}

public function downloadPDF($id)
{
    $application = Application::with(['user.personalInformation', 'qualifications'])->findOrFail($id);

    $pdf = Pdf::loadView('pdfs.application', [
        'application' => $application,
        'user' => $application->user,
        'qualifications' => $application->qualifications,
    ]);

    // Get user full name or fallback to user name
    $userName = $application->user->personalInformation->full_name ?? $application->user->name;

    // Clean up the name for a safe filename
    $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '', $userName);

    // Generate filename
    $filename = $safeName . '_Application_' . $application->id . '.pdf';

    return $pdf->download($filename);
}

}
