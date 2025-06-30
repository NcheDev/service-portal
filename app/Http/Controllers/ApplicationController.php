<?php

namespace App\Http\Controllers;

use Pdf;
use App\Models\Invoice;
use App\Models\Document;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Models\EducationHistory;
use Illuminate\Support\Facades\Auth;

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
            'nationality' => 'required|in:local,foreigner',

            // Qualifications
            'qualifications.*.name' => 'required|string',
             'qualifications.*.program_name' => 'required|string|max:255',
            'qualifications.*.year' => 'required|date|before_or_equal:today',
            'qualifications.*.institution' => 'required|string|max:255',
            'qualifications.*.country' => 'required|string|max:255',
            'qualifications.*.custom_name' => 'nullable|required_if:qualifications.*.name,Other|string|max:255',

            // Education History
            'education_histories' => 'required|array|min:1',
            'education_histories.*.name' => 'required|string|max:255',
            'education_histories.*.year' => 'required|digits:4',
            'education_histories.*.institution' => 'required|string|max:255',
            'education_histories.*.country' => 'required|string|max:255',

            // Files
            'consent_form' => 'required|mimes:pdf|max:2048',
            'certificates.*' => 'file|max:5120',
            'academic_records.*' => 'file|max:5120',
            'previous_evaluations.*' => 'file|max:5120',
            'syllabi.*' => 'file|max:5120',
        ]);

        // Create Application
        $application = Application::create([
            'user_id' => Auth::id(),
            'processing_type' => $request->processing_type,
            'nationality' => $request->nationality,
        ]);

        // Save Qualifications
        if ($request->has('qualifications')) {
            foreach ($request->qualifications as $qualificationData) {
                Qualification::create([
                    'application_id' => $application->id,
                    'user_id' => Auth::id(),
                    'name' => $qualificationData['name'],
                    'custom_name' => $qualificationData['custom_name'] ?? null,
                    'program_name' => $qualificationData['program_name'] ?? null,
                    'year' => $qualificationData['year'],
                    'institution' => $qualificationData['institution'],
                    'country' => $qualificationData['country'],
                ]);
            }
        }

        // Save Education History
        if ($request->has('education_histories')) {
            foreach ($request->education_histories as $history) {
                $application->educationHistories()->create($history);
            }
        }

        // Save Consent Form
        if ($request->hasFile('consent_form')) {
            $path = $request->file('consent_form')->store('consent_forms', 'public');

            Document::create([
                'application_id' => $application->id,
                'type' => 'consent_form',
                'file_path' => $path,
            ]);
        }

        // Save Other Uploaded Documents
        $documentTypes = ['certificates', 'academic_records', 'previous_evaluations', 'syllabi'];
        foreach ($documentTypes as $type) {
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

        // Generate Invoice
        $fee = match ([$request->processing_type, $request->nationality]) {
            ['normal', 'local'] => 75000,
            ['normal', 'foreigner'] => 150,
            ['express', 'local'] => 112500,
            ['express', 'foreigner'] => 225,
        };

        $invoice = Invoice::create([
            'application_id' => $application->id,
            'user_id' => Auth::id(),
            'invoice_number' => 'INV-' . now()->timestamp . '-' . rand(1000, 9999),
            'processing_type' => $application->processing_type,
            'fee' => $fee,
        ]);

        return redirect()->route('invoices.show', $invoice->id);
    }

    public function uploadConsentForm(Request $request)
    {
        $request->validate([
            'consent_form' => 'required|mimes:pdf|max:2048',
        ]);

        $user = auth()->user();
        $applicationId = $user->application()->latest()->first()?->id;

        $path = $request->file('consent_form')->store('consent_forms', 'public');

        Document::create([
            'application_id' => $applicationId,
            'type' => 'consent_form',
            'file_path' => $path,
        ]);

        return back()->with('success', 'Consent form uploaded successfully.');
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
}
