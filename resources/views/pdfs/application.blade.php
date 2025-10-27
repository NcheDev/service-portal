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
        }

        /* Header */
        header {
            position: fixed;
            top: -35px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            border-bottom: 3px solid #dd8027;
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

        /* Footer */
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

        h2 {
            color: #52074f;
            border-left: 4px solid #dd8027;
            padding-left: 8px;
            font-size: 14px;
            margin-top: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f7f2f8;
            color: #52074f;
        }

        .consent {
            background-color: #fdf6ec;
            border: 1px solid #dd8027;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .small {
            font-size: 11px;
        }
    </style>
</head>
<body>

<header>
    <img src="{{ public_path('images/nche_logo.png') }}" alt="NCHE Logo">
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
            <td>{{ $application->id }}</td>
        </tr>
        <tr>
            <th>Date Submitted</th>
            <td>{{ $application->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Processing Type</th>
            <td class="text-capitalize">{{ ucfirst($application->processing_type) }}</td>
        </tr>
    </table>

    <h2>Applicant Details</h2>
    <table>
        <tr><th>Full Name</th><td>{{ $user->personalInformation->full_name ?? $user->name }}</td></tr>
        <tr><th>Email</th><td>{{ $user->email }}</td></tr>
        <tr><th>Gender</th><td>{{ $user->personalInformation->gender ?? 'N/A' }}</td></tr>
        <tr><th>Country</th><td>{{ $user->personalInformation->country ?? 'N/A' }}</td></tr>
        <tr><th>Physical Address</th><td>{{ $user->personalInformation->physical_address ?? 'N/A' }}</td></tr>
    </table>

    <h2>Qualification Details</h2>
    <table>
        <thead>
            <tr>
                <th>Level</th>
                <th>Program Name</th>
                <th>Institution</th>
                <th>Year</th>
                <th>Merit</th>
                <th>Country</th>
            </tr>
        </thead>
        <tbody>
            @foreach($qualifications as $q)
            <tr>
                <td>{{ $q->name }}</td>
                <td>{{ $q->program_name }}</td>
                <td>{{ $q->institution }}</td>
                <td>{{ $q->year }}</td>
                <td>{{ $q->merit }}</td>
                <td>{{ $q->country }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Uploaded Documents</h2>
    <table>
        <tr><th>Qualification Certificates</th>
            <td>
                @if(!empty($application->certificate_paths))
                    @foreach(json_decode($application->certificate_paths, true) as $file)
                        {{ basename($file) }}<br>
                    @endforeach
                @else
                    <em>None uploaded</em>
                @endif
            </td>
        </tr>
        <tr><th>Academic Records</th>
            <td>
                @if(!empty($application->academic_record_paths))
                    @foreach(json_decode($application->academic_record_paths, true) as $file)
                        {{ basename($file) }}<br>
                    @endforeach
                @else
                    <em>None uploaded</em>
                @endif
            </td>
        </tr>
    </table>

    <h2>Consent & Declaration</h2>
    <div class="consent">
        <p><strong>Consent Status:</strong> 
            {{ $application->consent_agree ? '✅ Agreed to Terms and Conditions' : '❌ Not Agreed' }}
        </p>
        <p>
            I hereby confirm that all information provided is true and accurate, and I consent to NCHE verifying my 
            academic records with relevant authorities and institutions.
        </p>
    </div>
</main>

</body>
</html>
