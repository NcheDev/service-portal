<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>NCHE Application Details</title>
    <style>
        @page {
            margin: 50px 40px;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.5;
        }

        /* ===== Header ===== */
        header {
            position: fixed;
            top: -35px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            padding-bottom: 5px;
        }

        header img {
            height: 45px;
            vertical-align: middle;
            margin-right: 8px;
        }

        header h1 {
            display: inline-block;
            color: #52074f;
            font-size: 16px;
            font-weight: bold;
            vertical-align: middle;
            margin: 0;
        }

        /* ===== Footer ===== */
        footer {
            position: fixed;
            bottom: -25px;
            left: 0;
            right: 0;
            height: 20px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 3px;
        }

        /* ===== Headings ===== */
      h2 {
    color: #52074f;
    display: inline-block; /* makes border fit text width */
    border-bottom: 3px solid #dd8027;
    padding: 4px 8px;
    font-size: 14px;
    margin: 25px auto 10px auto; /* centers and adds balanced spacing */
    text-align: center;
}

/* To ensure centering works properly inside its container */
h2 {
    display: table;
    margin-left: auto;
    margin-right: auto;
}


        /* ===== Tables ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f6f1f9;
            color: #52074f;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #faf8fc;
        }

        /* ===== Highlight Boxes ===== */
        .consent {
            background-color: #fdf6ec;
            border: 1px solid #dd8027;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .docs {
            background-color: #f6f1f9;
            border: 1px solid #52074f;
            border-left: 5px solid #52074f;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .highlight {
            color: #52074f;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .status-agreed {
            color: green;
            font-weight: bold;
        }

        .status-notagreed {
            color: red;
            font-weight: bold;
        }

        .small {
            font-size: 11px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
        }
        .badge-purple {
            background-color: #52074f;
        }
        .badge-orange {
            background-color: #dd8027;
        }
    </style>
</head>
<body>

<header>
    <img src="{{ public_path('images/logo1.jpg') }}" alt="NCHE Logo">

     <h1>National Council for Higher Education (NCHE)</h1>
</header>

<footer>
    © {{ date('Y') }} National Council for Higher Education (NCHE) — Generated on {{ now()->format('d M Y, H:i') }}
</footer>

<main>
   <h2>Application Overview</h2>
<table>
    <tr>
        <th>Application ID</th>
        <td>NCHE/2025/{{ $application->id }}</td>
    </tr>
    <tr>
        <th>Date Submitted</th>
        <td>{{ $application->created_at->format('d M Y') }}</td>
    </tr>
    <tr>
        <th>Processing Type</th>
        <td class="text-capitalize">
            <span class="badge badge-purple">{{ ucfirst($application->processing_type) }}</span>
        </td>
    </tr>
    @if($user->personalInformation->application_type === 'Institution')
        <tr>
            <th>Institution Name</th>
            <td>{{ $user->personalInformation->institution_name ?? 'N/A' }}</td>
        </tr>
    @endif
</table>


    <h2>Applicant Details</h2>
    <table>
        @if($user->personalInformation->application_type === 'Institution' && $institutionApplicants)
        @foreach($institutionApplicants as $applicant)
            <tr>
                <th>First Name</th>
                <td>{{ $applicant->first_name }}</td>
            </tr>
            <tr>
                <th>Surname</th>
                <td>{{ $applicant->surname }}</td>
            </tr>
            <tr>
                
        @endforeach
    @else
        <tr>
    <th>First Name</th>
    <td>{{ $user->first_name }}</td>
</tr>

<tr>
    <th>Surname</th>
    <td>{{ $user->surname }}</td>
</tr>

 

        
    @endif
    </table>

    <h2>Qualification Details</h2>
    <table>
        <thead>
            <tr>
                <th>Level</th>
                <th>Field Of Study</th>
                <th>Institution</th>
                <th>Year</th>
                <th>Merit</th>
                <th>Country</th>
            </tr>
        </thead>
        <tbody>
            @forelse($qualifications as $q)
            <tr>
                <td>{{ $q->name }}</td>
                <td>{{ $q->program_name }}</td>
                <td>{{ $q->institution }}</td>
                <td>{{ $q->year }}</td>
                <td>{{ $q->merit }}</td>
                <td>{{ $q->country }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center"><em>No qualifications provided</em></td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Uploaded Documents</h2>
<table>
    <thead>
        <tr>
            <th>Document Type</th>
            <th>File(s)</th>
        </tr>
    </thead>
    <tbody>
        @php
            $docGroups = $application->documents->groupBy('type');
        @endphp

        @forelse($docGroups as $type => $docs)
            <tr>
                <td>{{ ucwords(str_replace('_', ' ', $type)) }}</td>
                <td>
                    @foreach($docs as $index => $doc)
    {{ ucwords(str_replace('_', ' ', $type)) }} {{ $docs->count() > 1 ? '(' . ($index + 1) . ')' : '' }}<br>
@endforeach

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2"><em>No documents uploaded</em></td>
            </tr>
        @endforelse
    </tbody>
</table>


    <h2>Consent & Declaration</h2>
    <div class="consent">
        <p><strong>Consent Status:</strong> 
            @if($application->consent_agree)
                <span class="status-agreed">✅ Agreed to Terms and Conditions</span>
            @else
                <span class="status-notagreed">❌ Not Agreed</span>
            @endif
        </p>
        <p>
            I hereby confirm that all information provided is true and accurate. I consent to NCHE verifying my 
            academic records with relevant authorities and institutions where applicable.
        </p>
    </div>
</main>

</body>
</html>
