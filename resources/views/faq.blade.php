@extends('layouts.user-dashboard')
@section('content')

<div class="documentation-card p-4 mb-5 shadow-sm rounded" style="background-color:#fff;">
    <h1 class="text-center fw-bold mb-4" style="color:#52074f; font-size:24px;">
        Qualifications Recognition, Verification and Evaluation
    </h1>

    <p class="fw-bold text-center mb-4" style="color:#dd8027;">
        The Process of Qualifications Recognition and Verification
    </p>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Lodging an Application</h2>
    <p>
        Any person may lodge an application to have their qualification(s) evaluated by the 
        <strong>National Council for Higher Education (NCHE)</strong>. Applications must be made 
        on the approved application form and must be completed fully, correctly, and legibly.
    </p>
    <p>
        The NCHE will process full applications only. If any information is lacking or does not 
        comply with the requirements in the application form and as stated below, the evaluation 
        process will not be activated and additional information will be requested.
    </p>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Forged Documents</h2>
    <p>
        If forged, altered, or falsified documents are submitted, an evaluation will not be processed. 
        The NCHE reserves the right to share the information with institutions and government agencies 
        as appropriate.
    </p>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Timelines for Applications</h2>
    <ul>
        <li>Ordinary applications: 21 working days</li>
        <li>Urgent applications: 10 working days</li>
    </ul>
    <p>
        Due to factors beyond NCHE's control, timelines may be exceeded. Clients should take cognizance 
        of possible delays. In the event of extraordinary circumstances causing delays, clients will be informed. 
        NCHE will, however, do everything possible to make results available promptly.
    </p>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Evaluation Results</h2>
    <p>
        Evaluation reports are issued only to the applicant. A certified copy may be issued to another 
        party if specifically requested and paid for by the applicant. Results are available via mail or 
        personal collection; reports are never faxed or emailed.
    </p>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Charges</h2>
    <ul>
        <li>Normal processing: Locals MK 75,000 | Foreigners US$ 150</li>
        <li>Express processing: Locals MK 112,500 | Foreigners US$ 225</li>
    </ul>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Requirements for Doctorate Qualifications Verification</h2>
    <ul>
        <li>Doctorate certificate with transcripts</li>
        <li>Doctorate thesis</li>
        <li>All master’s degree verification documents mentioned below</li>
    </ul>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Requirements for Master’s Degree Verification</h2>
    <ul>
        <li>Master’s Degree certificate with transcripts</li>
        <li>Master’s Degree thesis</li>
        <li>Bachelor’s Degree certificate or equivalent</li>
    </ul>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Postgraduate Diploma Verification Requirements</h2>
    <ul>
        <li>Postgraduate Diploma certificate with transcripts</li>
        <li>Diploma certificate(s) or equivalent</li>
        <li>Bachelor’s Degree certificate(s) or equivalent</li>
    </ul>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Bachelor’s Degree Certification Verification</h2>
    <ul>
        <li>Bachelor’s Degree certificate(s) or equivalent</li>
        <li>Bachelor’s Degree transcripts</li>
    </ul>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Diploma Certificate Verification</h2>
    <ul>
        <li>Diploma certificate(s) and transcripts</li>
        <li>Secondary school certificate or equivalent</li>
    </ul>

    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Process for Qualification Recognition, Evaluation or Verification</h2>
    <p>
        The process includes verifying whether the qualification is:
    </p>
    <ul>
        <li>Registered on the HEQF;</li>
        <li>Offered by a registered and accredited institution; and</li>
        <li>Lawfully obtained.</li>
    </ul>
</div>

<style>
.documentation-card h2 {
    color: #52074f;
    border-bottom: 3px solid #dd8027;
    padding-bottom: 6px;
    margin-top: 20px;
    margin-bottom: 12px;
}

.text-nche-primary {
    color: #52074f;
}

ul li {
    margin-bottom: 6px;
}

p {
    line-height: 1.6;
}

.documentation-card {
    max-width: 900px;
    margin: 0 auto;
}
</style>

@endsection
