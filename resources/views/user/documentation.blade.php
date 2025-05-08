<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Qualifications Recognition & Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f6f6fb;
            color: #333;
        }

        .doc-header {
            background: linear-gradient(rgba(82, 7, 79, 0.85), rgba(82, 7, 79, 0.85)),
                        url('https://images.unsplash.com/photo-1600203480066-d531c6ba2717?auto=format&fit=crop&w=1500&q=80') center/cover no-repeat;
            color: white;
            padding: 60px 20px;
            text-align: center;
            border-radius: 0 0 30px 30px;
        }

        .doc-header h1 {
            font-size: 2.8em;
            margin-bottom: 0.2em;
        }

        .doc-header p {
            font-size: 1.2em;
            font-weight: 300;
            color: #ffdaae;
        }

        .doc-container {
            max-width: 900px;
            margin: 3em auto;
            padding: 2em 2.5em;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            line-height: 1.7;
        }

        h2 {
            color: #52074f;
            margin-top: 2em;
        }

        p {
            margin: 0.5em 0 1.5em;
        }

        .download-btn {
            display: inline-block;
            background-color: #dd8027;
            color: white;
            padding: 0.75em 1.5em;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
            float: right;
            margin-top: -40px;
        }

        .download-btn:hover {
            background-color: #c56e20;
        }

        @media (max-width: 600px) {
            .download-btn {
                float: none;
                display: block;
                margin: 1em auto;
            }
        }
        
    </style>
</head>
<body>
    <div class="doc-header">
        <h1>Qualifications Recognition & Verification</h1>
        <p>National Council for Higher Education (NCHE)</p>
    </div>

    <div class="doc-container">
        <a href="{{ route('documentation.download') }}" class="btn btn-primary" style="padding: 10px 20px; background-color: #dd8027; color: white; border-radius: 8px; text-decoration: none;">Download PDF</a>

        <h2>The Process of Qualifications Recognition and Verification</h2>
        <p>
            NCHE evaluates foreign and local qualifications to determine comparability with the local education system.
            This ensures academic integrity and promotes trust in qualifications across borders.
        </p>

        <h2>Lodging an Application</h2>
        <p>
            Any person may lodge an application to have their qualification(s) evaluated by NCHE. Applications must be made
            on the approved form and completed fully, correctly, and legibly.
        </p>

        <h2>Evaluation Requirements</h2>
        <p>
            Incomplete or incorrect applications will not be processed. All submitted documents must be authentic. If forged,
            altered or falsified documents are detected, NCHE reserves the right to inform relevant authorities.
        </p>

        <h2>Timelines for Application Processing</h2>
        <p>
            Applications are typically processed within 21 working days. Urgent cases may be handled in 10 working days, though
            unforeseen delays may occur. Clients will be notified in such cases.
        </p>

        <h2>Evaluation Report</h2>
        <p>
            The report will be issued only to the applicant. Certified copies may be shared with other parties if requested and paid for.
            Reports can be mailed or collected in person.
        </p>

        <h2>Additional Guidelines</h2>
        <p>
            • All foreign language documents must be accompanied by certified English translations.<br>
            • Applicants are responsible for following up on the status of their application.<br>
            • NCHE does not guarantee a favorable outcome and bases evaluations strictly on verifiable academic credentials.
        </p>

        <h2>Need Help?</h2>
        <p>
            For inquiries, please contact the Evaluation Division via email at <strong>evaluation@nche.org</strong> or visit our office during working hours.
        </p>
    </div>
</body>
</html>
