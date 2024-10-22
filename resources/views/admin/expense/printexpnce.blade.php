<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Expenses</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Expenses Report</h2>
        
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Expense Item</th>
                    <th>Transaction Date</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Expenses</th>
                    <th>Artist</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalAmount = 0;
                @endphp
                @forelse($expenses as $key => $expense)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $expense->expense_items }}</td>
                        <td>{{ date('m-d-Y', strtotime($expense->transaction_date)) }}</td>
                        <td>$ {{ $expense->amount }}</td>
                        <td>{{ $expense->payment_method }}</td>
                        <td>{{ $expense->expense_items }}</td>
                        <td>{{ $expense->user->name }}</td>
                    </tr>
                    @php
                        $totalAmount += $expense->amount;
                    @endphp
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Expenses Found</td>
                    </tr>
                @endforelse
            </tbody>
            
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total Amount</strong></td>
                    <td colspan="4">$ {{ $totalAmount }}</td>
                </tr>
            </tfoot>
            
            
        </table>

        <div class="text-center no-print">
            <button onclick="window.print()" class="btn btn-primary">Print</button>
        </div>
    </div>
</body>
</html>
