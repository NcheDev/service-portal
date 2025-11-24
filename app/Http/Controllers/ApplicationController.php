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
use App\Models\InstitutionApplicant;

 

class ApplicationController extends Controller
{
 

public function create()
{
    $user = auth()->user();

    // Ensure personal info exists
    if (! $user->personalInformation) {
        return redirect()->route('personal-info.form')
            ->with('error', 'Please complete your personal information before starting an application.');
    }

    $type = $user->personalInformation->application_type; // Individual or Institution

    if ($type === 'Institution') {
        return view('user.applications.institution-create', [
            'user' => $user,
            'personalInfo' => $user->personalInformation,
        ]);
    }

    // Default: Individual
    return view('application', [
        'user' => $user,
        'personalInfo' => $user->personalInformation,
    ]);
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
        'qualifications',
        'user.personalInformation',
        'institutionApplicants' // relation to fetch extra personal info if institution
    ])->findOrFail($id);

    if (auth()->id() !== $application->user_id) {
        abort(403, 'Unauthorized action.');
    }

    $user = $application->user;
    $personalInfo = $user->personalInformation;

    $institutionApplicants = null;
    if ($personalInfo && $personalInfo->application_type === 'Institution') {
        $institutionApplicants = $application->institutionApplicants; // collection of extra applicants
    }

    return view('user.application-details', compact(
        'application',
        'user',
        'personalInfo',
        'institutionApplicants'
    ));
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
    $application = Application::with([
        'documents',
        'qualifications',
        'user.personalInformation',
        'institutionApplicants'
    ])->findOrFail($id);

    $user = $application->user;
    $qualifications = $application->qualifications;
    $institutionApplicants = null;

    if ($user->personalInformation->application_type === 'Institution') {
        $institutionApplicants = $application->institutionApplicants;
    }

    $pdf = PDF::loadView('pdfs.application', compact(
        'application',
        'user',
        'qualifications',
        'institutionApplicants'
    ));

    $filename = preg_replace('/[^A-Za-z0-9_\-]/', '', $user->name) . '_Application_' . $application->id . '.pdf';

    return $pdf->download($filename);
}

public function edit($id)
{
    $application = Application::with(['documents', 'qualifications'])->findOrFail($id);

    if ($application->status !== 'pending') {
        return redirect()
            ->route('applications.index')
            ->with('error', 'You can only edit an application that is Under Review.');
    }

    // Load qualifications from the qualifications table
    $qualifications = $application->qualifications;

    // Load documents by type
    $certificates = $application->documents->where('type', 'certificates');
    $academic_records = $application->documents->where('type', 'academic_records');
    $previous_evaluations = $application->documents->where('type', 'previous_evaluations');
    $syllabi = $application->documents->where('type', 'syllabi');

    $countries = config('countries');

    return view('user.edit-application', compact(
        'application',
        'qualifications',
        'countries',
        'certificates',
        'academic_records',
        'previous_evaluations',
        'syllabi'
    ));
}




public function update(Request $request, $id)
{
    $application = Application::with('qualifications')->findOrFail($id);

    if ($application->status !== 'pending') {
        return back()->with('error', 'You cannot edit this application.');
    }

    $request->validate([
        'processing_type' => 'required|string',

        'qualifications.*.name'        => 'required|string',
        'qualifications.*.program_name'=> 'required|string',
        'qualifications.*.year'        => 'required|integer',
        'qualifications.*.institution' => 'required|string',
        'qualifications.*.country'     => 'required|string',
        'qualifications.*.merit'       => 'nullable|string',
    ]);

    // Update processing type
    $application->update([
        'processing_type' => $request->processing_type,
    ]);

    // Update each qualification
    foreach ($request->qualifications as $i => $qualData) {
        $qual = $application->qualifications[$i];

        if ($qual) {
            $qual->update([
                'name' => $qualData['name'],
                'program_name' => $qualData['program_name'],
                'year' => $qualData['year'],
                'institution' => $qualData['institution'],
                'country' => $qualData['country'],
                'merit' => $qualData['merit'] ?? null,
            ]);
        }
    }

    // Files upload
    foreach (['certificates', 'academic_records', 'previous_evaluations', 'syllabi'] as $type) {
        if ($request->hasFile($type)) {
            foreach ($request->file($type) as $file) {
                $path = $file->store("documents", "public");

                $application->documents()->create([
                    'type' => $type,
                    'file_path' => $path,
                ]);
            }
        }
    }

    return back()->with('success', 'Application updated successfully.');
}


public function destroyDocument($id)
{
    $document = \App\Models\Document::findOrFail($id);

    // Ensure the authenticated user owns this document via the application
    if($document->application->user_id !== auth()->id()) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    // Delete file from storage
    if(file_exists(storage_path('app/public/'.$document->file_path))){
        unlink(storage_path('app/public/'.$document->file_path));
    }

    // Delete the DB record
    $document->delete();

    return response()->json(['success' => true]);
}

public function storeInstitution(Request $request)
{
    // Validation: institution applicant + qualifications + files
    $request->validate([
        // Institution applicant
        'first_name'   => 'required|string|max:255',
        'surname'      => 'required|string|max:255',
        'email'        => 'required|email|max:255',
        'nationality'  => 'required|string|max:100',
        'title'        => 'nullable|string|max:50',
        'dob'          => 'required|date',
        'phone'        => ['required','regex:/^\+?[0-9]{8,15}$/'],

        // Application
        'processing_type' => 'required|in:normal,express',
        'consent_agree'   => 'accepted',

        // Qualifications (same structure as individual)
        'qualifications' => 'required|array|min:1',
        'qualifications.*.name' => 'required|string',
        'qualifications.*.program_name' => 'required|string|max:255',
        'qualifications.*.year' => 'required|digits:4',
        'qualifications.*.institution' => 'required|string|max:255',
        'qualifications.*.country' => 'required|string|max:255',
        'qualifications.*.custom_name' => 'nullable|required_if:qualifications.*.name,Other|string|max:255',
        'qualifications.*.merit' => 'nullable|string|max:255',

        // Files (same groups as individual)
        'certificates' => 'required|array|min:1',
        'certificates.*' => 'file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
        'academic_records.*' => 'nullable|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
        'previous_evaluations.*' => 'nullable|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
        'syllabi.*' => 'nullable|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
    ]);

    // 1) Create application
    $application = Application::create([
        'user_id' => Auth::id(),
        'processing_type' => $request->processing_type,
        'application_type' => 'Institution',
        'consent_agree' => $request->has('consent_agree'),
        'status' => 'pending',
    ]);

    // 2) Save institution applicant (separate table)
    $institutionApplicant = InstitutionApplicant::create([
        'application_id' => $application->id,
        'first_name' => $request->first_name,
        'surname' => $request->surname,
        'email' => $request->email,
        'nationality' => $request->nationality,
        'title' => $request->title,
        'dob' => $request->dob,
        'phone' => $request->phone,
    ]);

    // 3) Save qualifications (reuse your Qualification model)
    foreach ($request->qualifications as $q) {
        Qualification::create([
            'application_id' => $application->id,
            'user_id' => Auth::id(), // representative user
            'name' => $q['name'],
            'custom_name' => $q['custom_name'] ?? null,
            'program_name' => $q['program_name'],
            'year' => $q['year'],
            'institution' => $q['institution'],
            'country' => $q['country'],
            'merit' => $q['merit'] ?? null,
        ]);
    }

    // 4) Save documents (same groups)
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

    // 5) Return success (same success view as individual)
    return view('user.success', [
        'application' => $application,
    ]);
}


public function downloadPDFInstitution($applicantId)
{
    // Fetch the institution applicant along with related qualifications and documents
    $applicant = InstitutionApplicant::with(['qualifications', 'documents'])
        ->findOrFail($applicantId);

    // Create a full name property on the fly
    $applicant->full_name = $applicant->first_name . ' ' . $applicant->surname;

    // Generate PDF using the Blade view for institution applications
    $pdf = PDF::loadView('pdfs.institution', compact('applicant'));

    // Download the PDF with applicant's full name
    return $pdf->download($applicant->full_name . '_Application.pdf');
}
 
}