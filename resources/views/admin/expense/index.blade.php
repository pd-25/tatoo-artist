@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Artist-index'  )
@section('content')
    <div class="row justify-content-center">

        <div class="col-lg-10">
            <div class="card">
                <div class="card-title pr">
                    <h4>All Expenses </h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-title text-right">
                    <a href="{{ route('admin.AddexpensesForm') }}" class="btn btn-sm btn-success">Add Expenses</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Artist</th>
                                    <th>Date</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Expenses</th>
                                    <th>Transaaction Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($expense)>0)
                                    @foreach ($expense as $index => $expenses)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>
                                                {{ $expenses->user->name }}
                                            </td>
                                            <td>
                                                {{ date('jS F, Y', strtotime($expenses->created_at)) }}
                                            </td>
                                            <td>
                                                {{ ucfirst($expenses->payment_method) }}
                                            </td>
                                            <td>
                                                ${{ $expenses->amount }}
                                            </td>
                                            <td>{{ ucfirst($expenses->expense_items) }}</td>
                                            <td>
                                                {{ date('jS F, Y', strtotime($expenses->transaction_date)) }}
                                            </td>
                                            <td>

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
                    </div>
                </div>
            </div>
        </div>

    </div>
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
