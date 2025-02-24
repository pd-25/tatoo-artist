@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Artist-index'  )
@section('content')
    <div class="row justify-content-center">

        <div class="col-lg-11">
            <div class="card">
                <div class="card-title pr">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>All Expenses </h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('admin.AddexpensesForm') }}" class="btn btn-success">Add Expenses</a>
                            <a href="{{route('expenses.getExpensesArchive')}}" class="btn btn-primary m-1">Archives</a>
                            <button class="btn btn-primary m-1 d-none" id="moveToArchives">Move to Archives</button>
                        </div>
                    </div>
                    <div id="alert-container"></div>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                
                <div class="card-body">
                    <form action="{{ route('admin.getExpenses') }}" method="GET" class="row g-3 d-flex justify-content-center">
                        <div class="col-md-3">
                            <label for="start_date"><b>Start Date:</b></label>
                            <div class="input-group date datepicker">
                                <input type="text" name="start_date" value="{{ old('start_date') }}" class="form-control" required>
                                <div class="input-group-addon input-group-append">
                                    <div class="input-group-text">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-3">
                            <label for="end_date"><b>End Date:</b></label>
                            <div class="input-group date datepicker">
                                <input type="text" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                                <div class="input-group-addon input-group-append">
                                    <div class="input-group-text">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- New Expense Items Filter -->
                        <div class="col-md-3">
                            <label for="expense_items"><b>Expense Item:</b></label>
                            <select name="expense_items" class="form-control" required>
                                <option value="all">ALL</option>
                                <option value="advertising">Advertising</option>
                                <option value="ink">Ink</option>
                                <option value="tools">Tools</option>
                                <option value="clothing">Clothing</option>
                                <option value="insurance">Insurance</option>
                                <option value="ccfees">CC Fees</option>
                            </select>
                        </div>
                    
                        <!-- Filter and Print Buttons -->
                        <div class="col-md-3 d-flex align-items-end mb-2 justify-content-center ">
                            <button type="submit" class="btn btn-primary w-100 m-1">Filter</button>
                            <a href="{{ route('admin.printExpenses', request()->query()) }}" class="m-1 btn btn-secondary no-print w-100">Print</a>
                        </div>
                    </form>
                    
                    
                    
                    
                    
                    
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>SL No</th>
                                    <th>Artist</th>
                                    {{-- <th>Date</th> --}}
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Expenses</th>
                                    <th>Transaction Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($expense)>0)
                                    @foreach ($expense as $index => $expenses)
                                        <tr>
                                            <td><input type="checkbox" class="quoteCheckbox" value="{{ $expenses->id }}"></td>
                                            <td>{{$index+1}}</td>
                                            <td>
                                                {{ $expenses->user->name ?? '' }}
                                            </td>
                                            {{-- <td>
                                                {{ date('m-d-Y',strtotime($expenses->created_at))  }}
                                            </td> --}}
                                            <td>
                                                {{ ucfirst($expenses->payment_method) }}
                                            </td>
                                            <td>
                                                ${{ $expenses->amount }}
                                            </td>
                                            <td>{{ ucfirst($expenses->expense_items) }}</td>
                                            <td>
                                                {{  date('m-d-Y',strtotime($expenses->transaction_date)) }}
                                            </td>
                                            <td style="display: flex; gap:3px; justify-content:flex-end">

                                                <a href="{{ route('admin.editexpensesForm', encrypt($expenses->id)) }}"><i
                                                        class="ti-pencil btn btn-sm btn-primary"></i></a>
                                                <form method="POST"
                                                    action="{{ route('admin.deleteexpensesForm', encrypt($expenses->id)) }}"
                                                    class="action-icon">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger  delete-icon show_confirm"
                                                        data-toggle="tooltip" title='Delete'>
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" style="text-align: center;">
                                            <b>No record is found at this moment!</b>
                                        </td>
                                    </tr>    
                                @endif    
                            </tbody>
                            
                        </table>
                        {{ $expense->appends(request()->query())->links() }}

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
                fetch("{{ route('expenses.moveToArchives') }}", {
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
    <script>
        function changeStatus(slug, id) {
            $.ajax({
                type: "POST",
                url: "#",
                data: {
                    'service_slug': slug,
                    '_token': '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.status) {
                        $("#status-btn"+ id).load(window.location.href + " #status-btn"+ id);
                        swal('Status updated');
                    }else {
                        swal('Some Error occur, relode the page');
                    }
                }
            });
        }
    </script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
    <script>
        $(function() {
            $('#datetimepicker1').datetimepicker();
        });

        $('.datepicker').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "MM/DD/YYYY",
        });
    </script>
@endsection
