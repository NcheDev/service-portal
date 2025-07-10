<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NCHE | Qualifications Recognition & Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8f8fb;
            color: #333;
            margin: 0;
        }

        .header-section {
            background: linear-gradient(rgba(82, 7, 79, 0.88), rgba(82, 7, 79, 0.88)),
                        url('https://images.unsplash.com/photo-1600203480066-d531c6ba2717?auto=format&fit=crop&w=1500&q=80') center/cover no-repeat;
            padding: 70px 20px;
            color: white;
            text-align: center;
            border-radius: 0 0 30px 30px;
        }

        .header-section h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .header-section p {
            font-size: 1rem;
            color: #ffdaae;
        }

        .content-box {
            background: white;
            max-width: 960px;
            margin: -40px auto 50px auto;
            padding: 30px 25px;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #52074f;
            font-size: 1.3rem;
            margin-top: 2.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        h5 {
            color: #52074f;
            font-size: 1.1rem;
            margin-top: 1.2rem;
        }

        .download-btn {
            background-color: #dd8027;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            float: right;
            transition: background 0.3s ease;
        }

        .download-btn:hover {
            background-color: #c56e20;
        }

        ul {
            padding-left: 1.5rem;
        }

        li {
            margin-bottom: 0.6em;
        }

        .icon {
            color: #dd8027;
            font-size: 1.4rem;
        }

        .clearfix {
            clear: both;
        }

        @media (max-width: 768px) {
            .download-btn {
                float: none;
                display: block;
                text-align: center;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header-section">
        <h1>Qualifications Recognition & Verification</h1>
        <p>National Council for Higher Education (NCHE)</p>
    </div>

    <!-- Main Content -->
    <div class="content-box">
        <a href="{{ route('documentation.download') }}" class="download-btn mb-3">
            <i class="mdi mdi-download"></i> Download PDF
        </a>
        <div class="clearfix"></div>

        <h2><i class="mdi mdi-clipboard-edit icon"></i> 1. Lodging an Application</h2>
        <p>Applications must be submitted using the official NCHE form, completed fully and legibly. Incomplete applications will not be processed.</p>

        <h2><i class="mdi mdi-shield-alert icon"></i> 2. Forged Documents</h2>
        <p>Submitting forged or falsified documents disqualifies the application. NCHE may share such information with appropriate institutions.</p>

        <h2><i class="mdi mdi-clock-outline icon"></i> 3. Timelines for Applications</h2>
        <ul>
            <li>Normal processing: 21 working days</li>
            <li>Urgent cases: 10 working days</li>
        </ul>
        <p>Processing time may vary due to unforeseen delays. Applicants will be notified accordingly.</p>

        <h2><i class="mdi mdi-file-document-check-outline icon"></i> 4. Evaluation Results</h2>
        <p>Results will be issued only to the applicant, via email or personal collection. Certified copies can be requested at a fee.</p>

        <h2><i class="mdi mdi-cash-multiple icon"></i> 5. Processing Charges</h2>
        <ul>
            <li><strong>Normal:</strong> Locals – MK 75,000 | Foreigners – US$ 150</li>
            <li><strong>Express:</strong> Locals – MK 112,500 | Foreigners – US$ 225</li>
        </ul>

        <h2><i class="mdi mdi-file-certificate-outline icon"></i> 6–10. Required Documents</h2>
        <div>
            <h5>Doctorate:</h5>
            <ul>
                <li>Certificate & transcripts</li>
                <li>Thesis</li>
                <li>Master’s degree documents</li>
            </ul>

            <h5>Master’s Degree:</h5>
            <ul>
                <li>Certificate & transcripts</li>
                <li>Thesis</li>
                <li>Bachelor’s certificate</li>
            </ul>

            <h5>Postgraduate Diploma:</h5>
            <ul>
                <li>Diploma certificate & transcripts</li>
                <li>Bachelor’s certificate</li>
            </ul>

            <h5>Bachelor’s Degree:</h5>
            <ul>
                <li>Certificate & transcripts</li>
            </ul>

            <h5>Diploma:</h5>
            <ul>
                <li>Certificate & transcripts</li>
                <li>Secondary school certificate</li>
            </ul>
        </div>

        <h2><i class="mdi mdi-checkbox-marked-circle-outline icon"></i> 11. Verification Process</h2>
        <ul>
            <li>Check if qualification is on HEQF</li>
            <li>Confirm institution accreditation</li>
            <li>Verify authenticity</li>
        </ul>

        <h2><i class="mdi mdi-lan icon"></i> 12. The Credential Evaluation System</h2>
        <p>The evaluation system ensures recognition and credibility of academic qualifications in line with national standards.</p>

        <h2><i class="mdi mdi-application icon"></i> Application Form Requirements</h2>
        <p>Provide full personal and academic history. Attach the following:</p>
        <ul>
            <li>All certified academic documents</li>
            <li>Course hours and syllabi (if available)</li>
            <li>Translation if not in English</li>
            <li>ID or passport</li>
            <li>Proof of payment</li>
        </ul>

        <h2><i class="mdi mdi-account-check-outline icon"></i> Declaration</h2>
        <p>Applicants must certify the accuracy of their information and authorize NCHE to verify submitted qualifications.</p>

        <h2><i class="mdi mdi-bank icon"></i> Bank Account Details</h2>
        <ul>
            <li><strong>Bank:</strong> NBS Bank</li>
            <li><strong>Branch:</strong> Lilongwe</li>
            <li><strong>Account Name:</strong> NCHE Service Fees</li>
            <li><strong>Account Number:</strong> 14416177</li>
            <li><strong>SWIFT CODE:</strong> NBSMWMW</li>
        </ul>

        <h2><i class="mdi mdi-phone icon"></i> Contact Us</h2>
        <p>
            <strong>The Chief Executive Officer</strong><br>
            National Council for Higher Education<br>
            Private Bag B371, Lilongwe 3<br>
            Tel: +265 1 755 884<br>
            Email: <a href="mailto:verification@nche.ac.mw">verification@nche.ac.mw</a><br>
            Website: <a href="http://www.nche.ac.mw" target="_blank">www.nche.ac.mw</a>
        </p>
    </div>
</body>
</html>
