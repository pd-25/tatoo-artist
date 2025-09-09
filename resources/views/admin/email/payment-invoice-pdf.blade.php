<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background-color: #fff;
            font-size: 14px;
            color: #333;
        }

        .invoice-container {
            padding: 20px;
            width: 100%;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header h2 {
            margin: 0;
            font-size: 24px;
            color: #222;
        }

        .invoice-header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #f4f4f4;
        }

        .section-title {
            margin: 20px 0 10px;
            font-size: 16px;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            font-size: 13px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
            width: 200px;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h2>Invoice</h2>
            <p>Thank you for choosing our tattoo services</p>
        </div>

        <div class="info-section">
            <ul class="info-list">
                <li><strong>Customer Name:</strong> {{ $data['customer']->name ?? 'N/A' }}</li>
                <li><strong>Invoice ID:</strong> #{{ $data['payment']->id ?? 'N/A' }}</li>
            </ul>
            <ul class="info-list">
                <li><strong>Artist Name:</strong> {{ $data['artist']->name ?? 'N/A' }}</li>
                <li><strong>Address:</strong>
                    {{ $data['artist']->artistData->shop_address ?? '' }}
                    @if($data['artist']->address2), {{ $data['artist']->address2 }} @endif
                    @if($data['artist']->city), {{ $data['artist']->city }} @endif
                    @if($data['artist']->state), {{ $data['artist']->state }} @endif
                    @if($data['artist']->country), {{ $data['artist']->country }} @endif
                    @if($data['artist']->zipcode) - {{ $data['artist']->zipcode }} @endif
                </li>
            </ul>
        </div>

        <h4 class="section-title">Payment Details</h4>
        <table>
            <tr><th>Design</th><td>{{ $data['payment']->design ?? 'N/A' }}</td></tr>
            <tr><th>Placement</th><td>{{ $data['payment']->placement ?? 'N/A' }}</td></tr>
            <tr><th>Price</th><td>${{ number_format($data['payment']->price, 2) }}</td></tr>
            <tr><th>Deposit</th><td>${{ number_format($data['payment']->deposit_total, 2) }}</td></tr>
            <tr><th>Tips</th><td>${{ number_format($data['payment']->tips, 2) }}</td></tr>
            <tr><th>Fees</th><td>${{ number_format($data['payment']->fees, 2) }}</td></tr>
            <tr><th>Total Due</th><td><strong>${{ number_format($data['payment']->total_due, 2) }}</strong></td></tr>
            <tr><th>Date</th><td>{{ $data['payment']->date }}</td></tr>
        </table>

        <h4 class="section-title">Payment History</h4>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Method</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $logs = json_decode($data['payment']->deposit_log, true); @endphp
                @if ($logs && count($logs) > 0)
                    @foreach ($logs as $index => $log)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($log['date'])->format('d M Y, h:i A') }}</td>
                            <td>{{ ucwords($log['method']) }}</td>
                            <td>${{ number_format($log['amount'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">No installments yet.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="signature-section">
            <div>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($data['payment']->date)->format('m-d-Y') }}</p>
                <div class="signature-line">Signature</div>
            </div>
            <div class="text-right">
                <p><strong>Total:</strong> ${{ number_format($data['payment']->deposit_total, 2) }}</p>
            </div>
        </div>
    </div>
</body>
</html>
