<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // <--- ADD THIS

class DocumentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Show upload form
     */
    public function create(Application $application)
    {
        return view('applications.documents.create', [
            'application' => $application,
        ]);
    }

    /**
     * Store uploaded documents
     */public function store(Request $request, Application $application)
{
    $request->validate([
        'documents.*.file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        'documents.*.type' => 'required|string|max:50',
    ]);

    if ($request->has('documents')) {
        foreach ($request->documents as $doc) {
            $file = $doc['file'];
            $path = $file->store('documents');

            Document::create([
                'application_id' => $application->id,
                'document_type'  => $doc['type'],
                'file_path'      => $path,
            ]);
        }
    }

     $application->update([
        'current_step' => 'preview'
    ]);
    return redirect()
        ->route('applications.documents.create', $application)
        ->with('success', 'Documents uploaded successfully.');
}
public function download(Document $document)
{
    // Authorization: ensure only the owner can download
    $this->authorize('view', $document);

    return Storage::download($document->file_path);
}


}
