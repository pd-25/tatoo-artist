{{-- resources/views/admin/print.blade.php --}}
@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Print Payment')

@section('content')


        <div class="print-container">
            <div class="print-header">
                <h2>Invoice</h2>
                <p>Thank you for choosing our tattoo services</p>
            </div>

            <div class="print-content">
                <div class="row d-flex justify-content-between text-left align-items-end">
                <ul class="list-unstyled">
                    <li><strong>Customer's Name:</strong> {{ $payments->customers_name ?? 'N/A' }}</li>
                    <li><strong>Invoice Id:</strong> #{{ $payments->id ?? 'N/A' }}</li>
                    
                </ul>
                <ul class="list-unstyled">
                    @if($payments->artist->banner_image)
                    <li  class="text-center"><img style="height: 100px; width: 100px" src="{{asset('storage/BannerImage/'. $payments->artist->banner_image)}}"></li>

                    
                    @endif
                    <li><strong>Artist Name:</strong> {{ $payments->artist->name ?? 'N/A' }}</li>
                    <li><strong>Address:</strong> #{{ $payments->artist->address ?? 'N/A' }}-{{$payments->artist->zipcode}}<br>{{$payments->artist->address2}}</li>
                    
                </ul>
                </div>
                <hr>
                <table class="table">
                    
                    <tr>
                        <td><strong>Design:</strong></td>
                        <td>{{ $payments->design ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Price:</strong></td>
                        <td>{{ $payments->price ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tips:</strong></td>
                        <td>{{ $payments->tips ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Due:</strong></td>
                        <td>{{ $payments->total_due ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Placement:</strong></td>
                        <td>{{ $placements->firstWhere('id', $payments->placement)->title ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Deposit:</strong></td>
                        <td>{{ $payments->deposit ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fees:</strong></td>
                        <td>{{ $payments->fees ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment Method:</strong></td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payments->payment_method ?? 'N/A')) }}</td>
                    </tr>
                    
                </table>
                <hr>
                <div class="row d-flex justify-content-between">
                    <div class="signature text-left">
                        <p><strong>Date:</strong> {{ $payments->date ?? 'N/A' }} 
                        <br><strong>Signature:</strong>
                        </p>
                    </div>
                <div class="total">
                    <p><strong>Total:</strong> {{ $payments->total_due ?? 'N/A' }}</p>
                </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn btn-primary print-button">Print</button>
            </div>
        </div>
   
<style>
    body {
        font-family: 'Times New Roman', Times, serif;
        background-color: #f4f4f4;
        color: #333;
    }

    .print-container {
        background: white;
        padding: 30px;
        margin: 30px auto;
        width: 80%;
        max-width: 800px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .print-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .print-header h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .print-header p {
        font-size: 16px;
        margin-top: 0;
    }

    .print-content {
        font-size: 16px;
        line-height: 1.6;
    }

    .print-content ul {
        list-style-type: none;
        padding: 0;
        margin: 0 0 20px 0;
    }

    .print-content li {
        margin-bottom: 10px;
    }

    .print-content hr {
        border: 0;
        border-top: 1px solid #ccc;
        margin: 20px 0;
    }

    .print-content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        text-align: left;
    }

    .print-content table td {
        padding: 8px 0;
    }

    .print-content img {
        max-width: 100%;
        height: auto;
    }

    .total {
        text-align: right;
    }

    .total p {
        font-size: 18px;
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    @media print {
    button.print-button {
        display: none !important; /* Ensure the button is hidden */
    }
    .print-container {
        box-shadow: none;
        margin: 0 0 0 -100px;
        width: 100%;
        max-width: none;
    }
    body {
        background: none;
        margin: 0;
    }
}

</style>
@endsection



