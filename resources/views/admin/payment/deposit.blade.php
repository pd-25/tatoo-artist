@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Deposit Slip Index'  )
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <div class="row justify-content-center">

        <div class="col-lg-11">
            <div class="card">
                <div class="card-title pr">
                    <h4>Search Data By Date Range OR Customer Name</h4>
                    @if (Session::has('message'))
                    <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.filterDeposite') }}" method="GET" enctype="multipart/form-data" name="paymentform">
                        @csrf
                        <div class="row d-flex justify-content-between">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <label for="start_date"><b>Start Date:</b></label>
                                <div class="input-group date datepicker">
                                    <input type="text" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-control" >
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                    
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <label for="end_date"><b>End Date:</b></label>
                                <div class="input-group date datepicker">
                                    <input type="text" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}" >
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <label for="name"><b>Name</b></label>
                                <div class="input-group">
                                    <select name="customers_name" class="form-control" id="customers_name">
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer }}" {{ old('customers_name') == $customer ? 'selected' : '' }}>
                                                {{ $customer }}
                                            </option>
                                        @endforeach
                                    </select>
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
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>All Deposits of Payments</h4>
                        </div>
                        <div class="d-flex align-items-center">
                             <a href="{{ route('admin.AddpaymentForm') }}" target="_blank" class="btn  btn-success">Add Payment</a>
                            <a href="{{route('deposit.getArchives')}}" class="btn btn-primary m-1">Archives</a>
                            <button class="btn btn-primary m-1 d-none" id="moveToArchives">Move to Archives</button>
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
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>SL No</th>
                                    <th>Customer Name</th>
                                    <th>Price</th>
                                    <th>Paid</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center" >Payment Type</th>
                                    <th class="text-center">View Deposit Image</th>
                                    <th class="text-center">Action</th>
                                    <th>View/Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($payments)>0)
                                    @foreach ($payments as $index=> $payment)
                                        <tr>
                                            <td>
                                                
                                                <input 
                                                    type="checkbox" 
                                                    class="quoteCheckbox" 
                                                    value="{{ $payment->id }}" 
                                                    @disabled($payment->total_due > 0)
                                                    title="{{ $payment->total_due > 0 ? 'Disabled due to deposit' : 'Select this payment' }}"
                                                >
                                            </td>
                                            

                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $payment->customers_name }}<br>
                                                @if($payment->isarchive == 1)
                                                <p class="badge" style="background: red; color: #e7e7e7; font-size: 10px;">Archived</p>
                                            @endif
                                            </td>
                                            <td>{{ $payment->price }}</td>
                                            <td>{{ $payment->deposit_total }}</td>
                                            <td class="text-center">{{ date('m-d-Y',strtotime( $payment->date)) }}</td>
                                            <td class="text-center">{{ $payment->payment_method }}</td>
                                            <td style="text-align: center;">
                                                @if(!empty($payment->bill_image))
                                                    <a href="{{ asset($payment->bill_image) }}" class="btn btn-sm btn-success" target="_blank">View Link</a>
                                                @else
                                                    <button class="btn btn-sm btn-danger" readonly >No image!</button>     
                                                @endif
                                            </td>
                                            <td style="text-align: center; display:flex; gap:3px;">
                                                <a href="{{ route('admin.showInstallments', $payment->id) }}">
                                                    <i class="ti-files btn btn-sm btn-primary"></i>
                                                </a>
                                                
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const selectAll = document.getElementById("selectAll");
    const checkboxes = document.querySelectorAll(".quoteCheckbox");
    const moveToArchives = document.getElementById("moveToArchives");

    function toggleMoveToArchives() {
        const selectedIds = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked && !checkbox.disabled)
            .map(checkbox => checkbox.value);

        moveToArchives.classList.toggle("d-none", selectedIds.length === 0);

        moveToArchives.setAttribute("data-selected", JSON.stringify(selectedIds));
    }

    selectAll.addEventListener("change", function () {
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = selectAll.checked;
            }
        });
        toggleMoveToArchives();
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", toggleMoveToArchives);
    });

    moveToArchives.addEventListener("click", function () {
        const selectedIds = JSON.parse(moveToArchives.getAttribute("data-selected") || "[]");

        if (selectedIds.length > 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to move selected items to archive.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, move it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
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
                                const alertDiv = document.createElement("div");
                                alertDiv.className = "alert alert-info";
                                alertDiv.innerHTML = data.success;
                                document.getElementById("alert-container").appendChild(alertDiv);

                                setTimeout(() => {
                                    alertDiv.remove();
                                    location.reload();
                                }, 3000);
                            } else {
                                Swal.fire('Error', 'Something went wrong!', 'error');
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire('Error', 'Failed to send request.', 'error');
                        });
                }
            });
        }
    });
});
</script>

@endsection

