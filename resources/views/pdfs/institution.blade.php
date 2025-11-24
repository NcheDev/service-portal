<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $applicant->institution_name }} Application</title>
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
            display: table;
            margin: 25px auto 10px auto;
            text-align: center;
            border-bottom: 3px solid #dd8027;
            padding: 4px 8px;
            font-size: 14px;
        }

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
    <h2>{{ $applicant->institution_name }} - Qualification Evaluation Application</h2>

    <h2>Applicant Details</h2>
    <table>
        <tr>
            <th>First Name</th>
            <td>{{ $applicant->first_name }}</td>
        </tr>
        <tr>
            <th>Surname</th>
            <td>{{ $applicant->surname }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $applicant->email }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $applicant->phone ?? 'N/A' }}</td>
        </tr>
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
            @forelse($applicant->qualifications as $q)
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
                $docGroups = $applicant->documents->groupBy('type');
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

</main>

</body>
</html>
