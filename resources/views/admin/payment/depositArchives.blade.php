@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Deposit Slip Index'  )
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title pr">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>All Deposits Payments Archives </h4>
                        </div>
                        <div class="d-flex align-items-center">
                             <!-- <a href="{{ route('admin.AddpaymentForm') }}" target="_blank" class="btn  btn-success">Add Payment</a> -->
                            <a href="{{route('admin.deposit-slips')}}" class="btn btn-primary m-1">Back</a>
                            <!-- <button class="btn btn-primary m-1 d-none" id="moveToArchives">Move to Archives</button> -->
                        </div>
                    </div>
                    <div id="alert-container"></div>

                   
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
               
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <!-- <th><input type="checkbox" id="selectAll"></th> -->
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
                                            <!-- <td><input type="checkbox" class="quoteCheckbox" value="{{ $payment->id }}"></td> -->

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
                        {{$payments->links()}}
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAll = document.getElementById("selectAll");
            const checkboxes = document.querySelectorAll(".quoteCheckbox");
            const moveToArchives = document.getElementById("moveToArchives");
        
            function toggleMoveToArchives() {
                const selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value); 
        
                moveToArchives.classList.toggle("d-none", selectedIds.length === 0);
        
                // Store selected IDs in a data attribute
                moveToArchives.setAttribute("data-selected", JSON.stringify(selectedIds));
            }
        
            selectAll.addEventListener("change", function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                toggleMoveToArchives();
            });
        
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", toggleMoveToArchives);
            });
        
            moveToArchives.addEventListener("click", function() {
                const selectedIds = JSON.parse(moveToArchives.getAttribute("data-selected") || "[]");
                
                if (selectedIds.length > 0) {
                    console.log("Selected IDs: ", selectedIds);
                    // Send these IDs to the server via AJAX or form submission
                    fetch("{{ route('deposit.moveToArchives') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    }).then(response => response.json())
                    .then(data => {
                    if (data.success) {
                        // Show Bootstrap alert
                        const alertDiv = document.createElement("div");
                        alertDiv.className = "alert alert-info";
                        alertDiv.innerHTML = data.success;
                        document.getElementById("alert-container").appendChild(alertDiv);
        
                        // Remove alert after 3 seconds
                        setTimeout(() => {
                            alertDiv.remove();
                            location.reload();
                        }, 3000);
                    } else {
                        alert("Something went wrong!");
                    }
                })
                .catch(error => console.error("Error:", error));
                }
            });
        });
        </script>
@endsection

