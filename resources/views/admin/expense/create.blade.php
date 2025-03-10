@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Artist-create')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4>Create Expenses</h4>
                    @if (Session::has('message'))
                        <p class="alert alert-info">{{ Session::get('message') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('admin.AddexpensesPost') }}" method="POST" enctype="multipart/form-data" name="Expensesform">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Artist Name</label><span class="text-danger">*</span>
                                                @if (Auth::guard('artists')->check())
                                                <select name="user_id" id="user_id" class="form-control" value="{{ old('user_id') }}">
                                                    <option selected value="{{ auth()->guard('artists')->id() }}">{{ auth()->guard('artists')->user()->name }}</option>
                                                   
                                                </select>
                                                @else
                                                <select name="user_id" id="user_id" class="form-control" value="{{ old('user_id') }}">
                                                    <option value="">select artists</option>
                                                    @foreach ($artists as $artist)
                                                        <option data-zipcode="{{ $artist->zipcode }}" value="{{ $artist->id }}">
                                                            {{ $artist->name }}</option>
                                                    @endforeach
                                                </select>
                                                @endif
                                       
    
                                        @error('user_id')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'Artist name field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id_end_time">Transaction Date:</label>
                                        <div class="input-group date" id="datepicker">
                                            <input type="text" name="transaction_date" class="form-control" required>
                                            <div class="input-group-addon input-group-append">
                                                <div class="input-group-text">
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>   
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Payment Method</label><span class="text-danger">*</span>
                                        <select name="payment_method" class="form-control" required>
                                            <option value="Credit Card">Credit Card</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Debit Card">Debit Card</option>
                                            <option value="Check">Check</option>
                                            <option value="Zelle">Zelle</option>
                                            <option value="PayPal">PayPal</option>
                                            <option value="Venmo">Venmo</option>
                                        </select>
                                        @error('payment_method')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>     
                            </div>            
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Expense Items</label><span class="text-danger">*</span>
                                        <select name="expense_items" class="form-control" required>
                                            <option value="advertising">Advertising</option>
                                            <option value="ink">Ink</option>
                                            <option value="tools">Tools</option>
                                            <option value="clothing">Clothing</option>
                                            <option value="insurance">Insurance</option>
                                            <option value="ccfees">CC Fees</option>
                                        </select>
                                        @error('expense_items')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount</label><span class="text-danger">*</span>
                                        <input type="number" step="0.01" class="form-control" name="amount" placeholder="Enter amount" required>
                                        @error('amount')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>  
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Note</label>
                                        <textarea name="note" class="form-control" style="height: 50px;" > </textarea>
                                        @error('note')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
                            </div>    
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
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
                $('#datetimepicker1').datetimepicker();
            });

            $('#datepicker').datetimepicker({
                "allowInputToggle": true,
                "showClose": true,
                "showClear": true,
                "showTodayButton": true,
                "format": "MM/DD/YYYY",
            });
        </script>
    @endsection
