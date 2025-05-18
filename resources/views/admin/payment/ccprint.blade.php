<!DOCTYPE html>
<html>
<head>
    <title>CC Payments Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .print-btn {
            margin-top: 20px;
            text-align: center;
        }

        .print-btn button {
            padding: 8px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-btn button:hover {
            background-color: #0056b3;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">CC Payments Report</h2>
    @if(!empty($startDate) && !empty($endDate))
    <p><strong>Start Date:</strong> {{ date('m-d-Y', strtotime($startDate)) }}</p>
    <p><strong>End Date:</strong> {{ date('m-d-Y', strtotime($endDate)) }}</p>
    @endif
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Artist Name</th>
                <th>Customer Name</th>
                <th>Price</th>
                <th>Total Paid</th>
                <th>Tips</th>
                <th>CC Fees</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>Reimbursed</th>
                <th>Date</th>
                <th>Shop %</th>
                <th>Artist %</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $counter = 1; 
                $totalPrice = 0;
                $totalPaid = 0;
                $totalTips = 0;
                $totalFees = 0;
                $totalAmount = 0;
                $totalShopPercentage = 0;
                $totalArtistPercentage = 0;
            @endphp
            @foreach ($payments as $payment)
                @php
                    $logs = collect(json_decode($payment->deposit_log, true))
                                ->filter(fn($log) => isset($log['method']) && strtolower($log['method']) === 'cc' && strtolower($log['reimbursed']) === '0')
                                ->values();
                    $rowspan = $logs->count() > 0 ? $logs->count() : 1;
                    $totalPrice += $payment->price;
                    $totalPaid += $payment->deposit_total;
                    $totalTips += $payment->tips;
                    $totalFees += $payment->fees;
                    $totalShopPercentage += $payment->shop_percentage;
                    $totalArtistPercentage += $payment->artist_percentage;
                    $currentCounter = $counter++; // Increment counter once per payment
                @endphp

                @if ($logs->count() > 0)
                    @foreach ($logs as $index => $log)
                        @php
                            $totalAmount += $log['amount'];
                        @endphp
                        <tr>
                            @if ($index === 0)
                                <td rowspan="{{ $rowspan }}">{{ $currentCounter }}</td>
                            @else
                                <td style="display: none;"></td>
                            @endif
                            @if ($index === 0)
                                <td rowspan="{{ $rowspan }}">{{ $payment->artist->name ?? '' }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $payment->customers_name ?? '' }}</td>
                                <td rowspan="{{ $rowspan }}">{{ number_format($payment->price, 2) }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $payment->deposit_total }}</td>
                                <td rowspan="{{ $rowspan }}">{{ number_format($payment->tips, 2) }}</td>
                                <td rowspan="{{ $rowspan }}">{{ number_format($payment->fees, 2) }}</td>
                            @endif
                            <td>{{ $log['method'] }}</td>
                            <td>{{ $log['amount'] }}</td>
                            <td>{{ $log['reimbursed'] == 1 ? 'Yes' : 'No' }}</td>
                            <td>{{ \Carbon\Carbon::parse($log['date'])->format('m-d-Y') }}</td>
                            @if ($index === 0)
                                <td rowspan="{{ $rowspan }}">{{ $payment->shop_percentage }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $payment->artist_percentage }}</td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $currentCounter }}</td>
                        <td>{{ $payment->artist->name ?? '' }}</td>
                        <td>{{ $payment->customers_name ?? '' }}</td>
                        <td>{{ number_format($payment->price, 2) }}</td>
                        <td>{{ $payment->deposit_total }}</td>
                        <td>{{ number_format($payment->tips, 2) }}</td>
                        <td>{{ number_format($payment->fees, 2) }}</td>
                        <td colspan="6">No CC Payments</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Totals</th>
                <th>{{ number_format($totalPrice, 2) }}</th>
                <th>{{ number_format($totalPaid, 2) }}</th>
                <th>{{ number_format($totalTips, 2) }}</th>
                <th>{{ number_format($totalFees, 2) }}</th>
                <th></th>
                <th>{{ number_format($totalAmount, 2) }}</th>
                <th></th>
                <th></th>
                <th>{{ number_format($totalShopPercentage, 2) }}</th>
                <th>{{ number_format($totalArtistPercentage, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="print-btn">
        <button onclick="window.print()">🖨️ Print</button>
    </div>
</body>
</html>