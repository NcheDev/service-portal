<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #000;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 15px;
            border: 1px solid #eee;
        }

        .heading {
            font-size: 20px;
            margin-bottom: 10px;
            text-align: center;
        }

        .info, .summary, .items {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .total {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="heading">Invoice</div>

        <div class="info">
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->created_at->format('d M Y') }}</p>
            <p><strong>Name:</strong> {{ $invoice->user->name }}</p>
            <p><strong>Email:</strong> {{ $invoice->user->email }}</p>
        </div>

        <div class="summary">
            <p><strong>Processing Type:</strong> {{ ucfirst($invoice->processing_type) }}</p>
            <p><strong>Nationality:</strong> {{ ucfirst($invoice->nationality) }}</p>
            <p><strong>Qualifications:</strong> {{ $invoice->qualification_count }}</p>
            <p><strong>Currency:</strong> {{ $invoice->currency }}</p>
        </div>

        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total">
                        <td colspan="3" class="text-right">Total Amount</td>
                        <td class="text-right">{{ number_format($invoice->total_amount, 2) }} {{ $invoice->currency }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            Thank you for your request!
        </div>
    </div>
</body>
</html>
