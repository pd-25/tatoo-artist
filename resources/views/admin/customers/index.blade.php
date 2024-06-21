@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Artist-index')
@section('content')
    <div class="row justify-content-center">

        <div class="col-lg-10">
            <div class="card">
                <div class="card-title pr">
                    <h4>All Customers</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <form action="{{ route('admin.customers') }}" method="get">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="search_customer"
                                            id="artwrk_tbl_filter" placeholder="Search data for this page">
                                    </div>
                                    <div class="col-md-2">
                                        <Button type="submit" class="btn btn-md btn-success">Search</Button>
                                    </div>
                                </div>
                            </form>

                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>Full name</th>
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>#</td>
                                        <td>
                                            {{ $customer->name }}
                                        </td>

                                        <td>
                                            {{ $customer->username }}
                                        </td>

                                        <td>
                                            {{ $customer->phone }}
                                        </td>

                                        <td>
                                            {{ $customer->email }}
                                        </td>

                                        <td>
                                            {{ isset($customer->address) ? $customer->address : 'Not Provided!' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.editCustomer', $customer->id) }}"><i
                                                    class="ti-pencil btn btn-sm btn-primary"></i></a>
                                            <form method="POST"
                                                action="{{ route('admin.destroyCustomer', $customer->id) }}"
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

                                        {{-- <td><span id="status-btn{{ $customer->id }}">
                                            <button class="btn btn-sm {{ $customer->status == 'Available' ? 'btn-success' : ($customer->status == 'Inactive' ? 'bg-danger' : 'bg-warning'); }}"  onclick="changeStatus('{{ $customer->id }}', {{ $customer->id}})" >
                                                {{ $customer->status }}
                                            </button>
                                        </span>
                                        </td> --}}
                                    </tr>
                                @endforeach
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
        $(document).ready(function() {
            $('#artwork_tbl').filterTable('#artwrk_tbl_filter');
        });
    </script>
@endsection
