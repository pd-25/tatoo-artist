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
                                <label for="id_end_time"><b>Start Date:</b></label>
                                <div class="input-group date datepicker">
                                    <input type="text" name="start_date" value="{{ old('start_date') }}" class="form-control" required>
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>

                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <label for="id_end_time"><b>End Date:</b></label>
                                <div class="input-group date datepicker">
                                    <input type="text" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">Search</button>
                                </div>    
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
                                    {{-- <th>Design</th>
                                    <th>Placement</th> --}}
                                    <th>Price</th>
                                    <th>Deposit</th>
                                    <th>Tips</th>
                                    <th>Fees</th>
                                    <th>Total Due</th>
                                    <th>Date</th>
                                    <th>Payment Method</th>
                                    <th>View Deposit Image</th>
                                    <th>View Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($payments)>0)
                                    @foreach ($payments as $index=> $payment)

                                        <tr>
                                            <td><?=$index+1?></td>
                                            <td>
                                                {{ $payment->customers_name }}
                                            </td>
                                            {{-- <td>
                                                {{ $payment->design }}
                                            </td>
                                            <td>
                                                {{ $payment->placement }}
                                            </td> --}}
                                            <td>
                                                {{ $payment->price }}
                                            </td>
                                            <td>
                                                {{ $payment->deposit }}
                                            </td>
                                            <td>
                                                {{ $payment->tips }}
                                            </td>
                                            <td>
                                                {{ $payment->fees }}
                                            </td>
                                            <td>
                                                {{ $payment->total_due }}
                                            </td>

                                            <td>
                                                {{ $payment->date }}
                                            </td>

                                            <td>
                                                @if($payment->payment_method == 'atm_debit')
                                                Atm/Debit
                                                @elseif ($payment->payment_method == 'cash')
                                                Cash
                                                @elseif ($payment->payment_method == 'credit_card')
                                                Credit Card
                                                @else
                                                Gift Card
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if(!empty($payment->bill_image))
                                                    <a href="{{ asset($payment->bill_image) }}" class="btn btn-sm btn-success" target="_blank">View Link</a>
                                                @else
                                                    <button class="btn btn-sm btn-danger" readonly >No image provided!</button>     
                                                @endif
                                            </td>
    
                                            <td style="text-align: center;">
                                                <a href="{{ route('admin.editpaymentForm', encrypt($payment->id)) }}" target="_blank">
                                                    <i class="ti-eye btn btn-sm btn-primary"></i>
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="11" style="text-align: center;">
                                        <b>No record is found at this moment!</b>
                                    </td>
                                </tr>    
                            @endif        
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(function() {
            $('#datetimepicker1').datetimepicker();
        });

        $('.datepicker').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "DD/MM/YYYY",
        });
    </script>
@endsection


