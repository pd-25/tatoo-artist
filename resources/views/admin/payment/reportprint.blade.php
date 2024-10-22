<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        tfoot td {
            font-weight: bold;
        }
        h2 {
            text-align: center;
        }
        .print-button {
            margin-bottom: 20px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">


    <h2>Deposit Report</h2>
    <p><strong>Start Date:</strong> {{ $startDate }}</p>
    <p><strong>End Date:</strong> {{ $endDate }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Artist Name</th>
                <th>Design</th>
                <th>Price</th>
                <th>Tips</th>
                <th>Total Due</th>
                <th>Customer's Name</th>
                <th>Placement</th>
                <th>Deposit</th>
                <th>Fees</th>
                <th>Payment Method</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->artist->name ?? 'N/A' }}</td>
                    <td>{{ $payment->design }}</td>
                    <td>{{ $payment->price }}</td>
                    <td>${{ $payment->tips }}</td>
                    <td>${{ $payment->total_due }}</td>
                    <td>{{ $payment->customers_name }}</td>
                    <td>{{ $payment->placement->title ?? 'N/A' }}</td>
                    <td>${{ $payment->deposit }}</td>
                    <td>${{ $payment->fees }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</td>
                    <td>{{  date('m-d-Y', strtotime($payment->date)) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;">Total:</td>
                <td>${{ $payments->sum('price') }}</td>
                <td>${{ $payments->sum('tips') }}</td>
                <td>${{ $payments->sum('total_due') }}</td>
                <td colspan="2"></td>
                <td>${{ $payments->sum('deposit') }}</td>
                <td>${{ $payments->sum('fees') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
    <div class="text-center no-print">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
    </div>
    </div>
</body>
</html>
