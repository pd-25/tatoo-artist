@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Deposit Slip Index'  )
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <div class="row justify-content-center">

        <div class="col-lg-11">
            <div class="card">
                <div class="card-title pr">
                    <h4>Search Data based on date</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.filterDeposite') }}" method="POST" enctype="multipart/form-data" name="paymentform">
                        @csrf
                        <div class="row d-flex justify-content-between">
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <label for="start_date"><b>Start Date:</b></label>
                                <div class="input-group date datepicker">
                                    <input type="text" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-control" required>
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                    
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <label for="end_date"><b>End Date:</b></label>
                                <div class="input-group date datepicker">
                                    <input type="text" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                      <!-- Filter and Print Buttons -->
                      <div class="ccol-lg-2 col-md-2 col-sm-12 d-flex align-items-end mb-2 justify-content-center ">
                        <button type="submit" class="btn btn-primary w-100 m-1 ">Search</button>
                        <a href="{{ route('admin.printDepositPDF', ['start_date' => old('start_date'), 'end_date' => old('end_date')]) }}" target="_blank" class="m-1 btn btn-secondary no-print w-100" style="color:white">Print PDF</a>
                        
                        
                    </div>
                          
                        </div> 
                    </form>
                        
                </div>    
            </div>
        </div>    

        <div class="col-lg-11">
            <div class="card">
                <div class="card-title pr">
                    <h4>All Deposits of Payments</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-title text-right">
                    <a href="{{ route('admin.AddpaymentForm') }}" target="_blank" class="btn btn-sm btn-success">Add Payment</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Customer Name</th>
                                    <th>Price</th>
                                    <th>Deposit</th>
                                    <th>Total Due</th>
                                    <th>Date</th>
                                    <th>Payment Method</th>
                                    <th>View Deposit Image</th>
                                    <th>Action</th>
                                    <th>View/Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($payments)>0)
                                    @foreach ($payments as $index=> $payment)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $payment->customers_name }}</td>
                                            <td>{{ $payment->price }}</td>
                                            <td>{{ $payment->deposit }}</td>
                                            <td>{{ $payment->total_due }}</td>
                                            <td>{{ date('m-d-Y',strtotime( $payment->date)) }}</td>
                                            <td>{{ $payment->payment_method }}</td>
                                            <td style="text-align: center;">
                                                @if(!empty($payment->bill_image))
                                                    <a href="{{ asset($payment->bill_image) }}" class="btn btn-sm btn-success" target="_blank">View Link</a>
                                                @else
                                                    <button class="btn btn-sm btn-danger" readonly >No image!</button>     
                                                @endif
                                            </td>
                                            <td style="text-align: center; display:flex; gap:3px;">
                                                <a href="{{ route('admin.editpaymentForm', encrypt($payment->id)) }}"><i class="ti-pencil btn btn-sm btn-primary"></i></a>
                                                <form method="POST" action="{{ route('admin.deletepaymentForm', encrypt($payment->id)) }}" class="action-icon">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn btn-sm btn-danger delete-icon show_confirm" data-toggle="tooltip" title='Delete'>
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td style="text-align: center;">
                                                <a href="{{ route('admin.editpaymentForm', encrypt($payment->id)) }}" target="_blank"><i class="ti-eye btn btn-sm btn-primary"></i></a>
                                                <a href="{{ route('admin.paymentview', encrypt($payment->id)) }}" target="_blank"><i class="ti-printer btn btn-sm btn-primary"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11" style="text-align: center;"><b>No record is found at this moment!</b></td>
                                    </tr>    
                                @endif        
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <style>
        .form-control {
  display: block;
  width: 100%;
  padding: .375rem .75rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: .25rem;
  transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
select.form-control:not([size]):not([multiple]) {
  height: calc(2.25rem + 2px);
}
.form-control {
  height: 42px !important;
  border-radius: 0px;
  box-shadow: none !important;
  border-color: #e7e7e7;
  font-family: 'Roboto', sans-serif;
}
          </style>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script>
        $(function() {
            $('.datepicker').datetimepicker({
                "allowInputToggle": true,
                "showClose": true,
                "showClear": true,
                "showTodayButton": true,
                "format": "MM/DD/YYYY",
            });
        });
    </script>
@endsection
