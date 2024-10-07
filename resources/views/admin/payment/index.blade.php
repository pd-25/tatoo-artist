@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Artist-index'  )
@section('content')
    <div class="row justify-content-center">

        <div class="col-lg-11">
            <div class="card">
                <div class="card-title pr">
                    <h4>All Payments</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-title text-right">
                    <a href="{{ route('admin.AddpaymentForm') }}" class="btn btn-sm btn-success">Add Payment</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>

                                    <th>Date</th>
                                    <th>Customer Name</th>
                                    <th>Design</th>
                                    <th>Placement</th>
                                    <th>Price</th>
                                    <th>Deposit</th>
                                    <th>Tips</th>
                                    <th>Fees</th>
                                    <th>Total Due</th>
                                    <th>Payment Method</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($payments)>0): ?>
                                  @foreach ($payments as $payment)
                                    <tr>

                                        <td>
                                            {{ date('m-d-Y',strtotime($payment->date))  }}
                                        </td>
                                        <td>
                                            {{ $payment->customers_name }}
                                        </td>
                                        <td>
                                            {{ $payment->design }}
                                        </td>
                                        <td> {{ $payment->placementData->title ?? '' }}</td>
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
                                        <td>

                                            <a href="{{ route('admin.editpaymentForm', encrypt($payment->id)) }}"><i
                                                    class="ti-pencil btn btn-sm btn-primary"></i></a>
                                            <form method="POST"
                                                action="{{ route('admin.deletepaymentForm', encrypt($payment->id)) }}"
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

                                <?php else: ?>
                                    <tr>
                                        <td colspan="12" style="text-align: center;">
                                            <b>No record is found at this moment!</b>
                                        </td>
                                    </tr>    
                                <?php endif; ?>   
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
@endsection
