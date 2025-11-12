@extends('layouts.user-dashboard')
@section('content')

<div class="documentation-card p-4 mb-5 shadow-sm rounded bg-white">
    <h1 class="text-center fw-bold mb-3" style="color:#52074f; font-size:26px;">
        Qualifications Recognition, Verification and Evaluation
    </h1>

    <p class="fw-bold text-center mb-4" style="color:#dd8027; font-size:18px;">
        The Process of Qualifications Recognition and Verification
    </p>

    {{-- Lodging an Application --}}
    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Lodging an Application</h2>
    <p>
        Any person may lodge an application to have their qualification(s) evaluated by the 
        <strong>National Council for Higher Education (NCHE)</strong>. Applications must be made 
        on the approved application form and must be completed fully, correctly, and legibly.
    </p>
    <p>
        The NCHE will process full applications only. If any information is lacking, or does not 
        comply with the requirements in the application form and as stated below, the evaluation 
        process will not be activated and additional information will be requested.
    </p>

    {{-- Forged Documents --}}
    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Forged Documents</h2>
    <p>
        If forged, altered, or falsified documents are submitted, an evaluation will not be processed. 
        The NCHE reserves the right to share the information with institutions and government agencies 
        as appropriate.
    </p>

    {{-- Timelines --}}
    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Timelines for Applications</h2>
    <ul>
        <li><strong>Normal Processing:</strong> Within 21 working days</li>
        <li><strong>Express Processing:</strong> Within 10 working days</li>
    </ul>
    <p>
        Due to various factors beyond NCHE’s control, timelines may sometimes be exceeded. 
        Clients should therefore be aware of possible delays before submitting their applications. 
        In the event of extraordinary circumstances causing considerable delay, clients will be informed. 
        NCHE will, however, do everything possible to ensure timely processing.
    </p>

    {{-- Evaluation Results --}}
    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Evaluation Results</h2>
    <p>
        Evaluation reports are issued only to the applicant. A certified copy may be issued to another 
        party if specifically requested and paid for by the applicant. 
    </p>
    <p>
        Evaluation results are made available according to the applicant’s instruction — by mail or personal collection. 
        Reports are not faxed or emailed under any circumstances.
    </p>

    {{-- Charges --}}
    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Charges</h2>
    <p>All applicants are required to pay the prescribed evaluation fees as follows:</p>
    <ul>
        <li><strong>Normal Processing:</strong> Locals – MK 75,000 | Foreigners – US$150</li>
        <li><strong>Express Processing:</strong> Locals – MK 112,500 | Foreigners – US$225</li>
    </ul>

    {{-- Payment Info --}}
<h2 class="text-nche-primary border-bottom mb-3 pb-2">Payment Information & Bank Details</h2>
<p>Payments should be deposited into the following account:</p>
<table class="table table-bordered" style="width:100%; border-collapse: collapse;">
    <tr>
        <th style="width: 30%; background-color:#f7f2f8;">Bank Name</th>
        <td>NBS Bank</td>
    </tr>
    <tr>
        <th style="background-color:#f7f2f8;">Branch</th>
        <td>Lilongwe</td>
    </tr>
    <tr>
        <th style="background-color:#f7f2f8;">Account Name</th>
        <td>NCHE Service Fees</td>
    </tr>
    <tr>
        <th style="background-color:#f7f2f8;">Account Number</th>
        <td>0000014416177</td>
    </tr>
    <tr>
        <th style="background-color:#f7f2f8;">SWIFT Code</th>
        <td>NBSMWMW</td>
    </tr>
</table>
<p class="small text-muted mt-1">
    Please retain your deposit slip or payment confirmation and attach proof of payment to your application form.
</p>

    {{-- Requirements --}}
    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Requirements for Doctorate Qualifications Verification</h2>
    <ul>
        <li>Doctorate certificate with transcripts</li>
        <li>Doctorate thesis</li>
        <li>All Master’s degree verification documents mentioned below</li>
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

    {{-- Process --}}
    <h2 class="text-nche-primary border-bottom mb-3 pb-2">Process for Qualification Recognition, Evaluation or Verification</h2>
    <p>
        The process includes verifying whether the qualification is:
    </p>
    <ul>
        <li>Registered on the <strong>Higher Education Qualifications Framework (HEQF)</strong></li>
        <li>Offered by a registered and accredited institution</li>
        <li>Lawfully obtained</li>
    </ul>

</div>

{{-- Custom Styles --}}
<style>
.documentation-card h2 {
    color: #52074f;
    border-bottom: 3px solid #dd8027;
    padding-bottom: 6px;
    margin-top: 25px;
    margin-bottom: 12px;
}

.text-nche-primary {
    color: #52074f;
}

ul li {
    margin-bottom: 6px;
    line-height: 1.6;
}

p {
    line-height: 1.7;
}

.documentation-card {
    max-width: 900px;
    margin: 0 auto;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
}
</style>

@endsection
