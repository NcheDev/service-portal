<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice PDF</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            margin: 20px;
            color: #333;
        }

        h2, h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        p {
            margin: 0 0 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .text-end {
            text-align: right;
        }

        .section {
            margin-bottom: 25px;
        }

        .border-box {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h2>🧾 Invoice #{{ $invoice->invoice_number }}</h2>
    <p><strong>Date:</strong> {{ $invoice->created_at->format('d M Y') }}</p>

    <!-- Applicant Info -->
    <div class="section border-box">
        <h4>👤 Applicant Details</h4>
        <p><strong>Name:</strong> {{ $invoice->application->user->name }}</p>
        <p><strong>Email:</strong> {{ $invoice->application->user->email }}</p>
    </div>

    <!-- Application Info -->
    <div class="section border-box">
        <h4>📄 Application Info</h4>
        <p><strong>Processing Type:</strong> {{ ucfirst($invoice->processing_type) }}</p>
        <p><strong>Nationality:</strong> {{ $invoice->application->nationality }}</p>
    </div>

    <!-- Fee Info -->
    <div class="section">
        <h4>💵 Fee Breakdown</h4>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-end">Amount (USD)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ ucfirst($invoice->processing_type) }} Application Fee</td>
                    <td class="text-end">${{ number_format($invoice->fee, 2) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th class="text-end">${{ number_format($invoice->fee, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>
