<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Validation Letter</title> 
    <style>
        @page {
            margin: 50px 50px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
            line-height: 1.8;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .left-info {
            width: 35%;
            font-size: 12px;
        }

        .logo {
            text-align: center;
            width: 30%;
        }

        .logo img {
            width: 80px;
        }

        .right-info {
            text-align: right;
            width: 35%;
            font-size: 12px;
        }

        .content {
            margin-top: 40px;
        }

        .signature-block {
            margin-top: 60px;
        }

        .signature-block img {
            height: 45px;
        }

        .watermark {
            position: fixed;
            top: 30%;
            left: 20%;
            width: 400px;
            opacity: 0.05;
            z-index: -1;
        }
    </style>
</head>
<body>
<div class="header" style="display: table; width: 100%; font-size: 12px; font-family: 'Times New Roman', serif;">
    {{-- Left Info --}}
    <div style="display: table-cell; width: 30%; vertical-align: top;">
        <strong>Telephone:</strong> +265 1 755 884<br>
        <strong>Fax:</strong> +265 1 754 633<br>
        <strong>Email:</strong> ceo@nche.ac.mw<br><br>
        Communications should be addressed <br>to:<br>
        <strong>The Chief Executive Officer</strong>
    </div>

    {{-- Center Logo --}}
    <div style="display: table-cell; width: 30%; text-align: center; vertical-align: middle;">
        <img src="{{ public_path('images/logo1.jpg') }}" alt="NCHE Logo" style="width: 90px;">
    </div>

    {{-- Right Info --}}
    <div style="display: table-cell; width: 40%; vertical-align: top;">
        In reply please quote<br>
        No:................... <br><br>
        <strong style="white-space: nowrap;">National Council for Higher Education</strong><br>
        Private Bag B371<br>
        Capital City, Lilongwe<br>
        {{ date('d F Y') }}
    </div>
</div>
<br><br>

{{-- Watermark --}}
<div class="watermark">
    <img src="{{ public_path('images/logo1.jpg') }}" alt="Watermark" style="width: 100%;">
</div>

<p>{{ ucfirst($user->personalInfo->title ?? '') }} {{ ucwords(strtolower($user->personalInfo->full_name ?? 'N/A')) }}</p>
<p>{{ $user->personalInfo->email ?? 'N/A' }}</p>
<p>{{ ucwords(strtolower($user->personalInfo->physical_address ?? 'N/A')) }}</p>
<p>{{ ucwords(strtolower($user->personalInfo->country ?? 'N/A')) }}</p>

{{-- Determine recognition text based on application status --}}
@php
    if (in_array($application->status, ['valid', 'validated'])) {
        $recognitionText = 'recognised';
    } elseif ($application->status === 'invalid') {
        $recognitionText = 'not recognised';
    } else {
        $recognitionText = 'pending recognition';
    }
@endphp

{{-- Letter Body --}}
<div class="content">
    <p>Dear {{ $salutation }},</p>

    {{-- SUBJECT (ALL CAPS) --}}
    <strong>RE: VALIDATION AND RECOGNITION OF  
        <span style="text-transform: uppercase;">
            {{ mb_strtoupper($qualification->name ?? '---', 'UTF-8') }}
        </span> 
        OF 
        <span style="text-transform: uppercase;">
            {{ mb_strtoupper($qualification->program_name ?? '---', 'UTF-8') }}
        </span> 
        FROM 
        <span style="text-transform: uppercase;">
            {{ mb_strtoupper($institution ?? '---', 'UTF-8') }}
        </span> 
        IN 
        <span style="text-transform: uppercase;">
            {{ mb_strtoupper($country ?? '---', 'UTF-8') }}
        </span>
    </strong>

    <p>
        The National Council for Higher Education (NCHE) Act No. 15 of 2011 mandates the Council to assess, evaluate and recognise qualifications attained at local and foreign higher education institutions (HEIs).
        In line with this mandate, we advise that the <strong>{{ ucwords(strtolower($qualification->name ?? '---')) }}</strong> awarded to <strong>{{ ucwords(strtolower($qualification->program_name ?? '---')) }}</strong> on <strong>{{ $qualification->year }}</strong> by <strong>{{ ucwords(strtolower($institution ?? '---')) }}</strong> is <strong>{{ $recognitionText }}</strong> by the NCHE.
    </p>

    <p>
        We hope this information will help you to make an informed decision. However, if you need any further clarification, please do not hesitate to contact the undersigned.
    </p>
</div>

{{-- Signature --}}
<div class="signature-block">
    <p>Yours faithfully,</p>
    <img src="{{ public_path('images/signature.jpeg') }}" alt="Signature"><br>
    <strong>John Sadalaki</strong><br>
    FOR; CHIEF EXECUTIVE OFFICER<br>
    National Council for Higher Education
</div>

</body>
</html>
