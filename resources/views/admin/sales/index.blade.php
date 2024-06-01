@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Artist-index'  )
@section('content')
    <div class="row justify-content-center">

        <div class="col-lg-10">
            <div class="card">
                <div class="card-title pr">
                    <h4>All Sales Person</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-title text-right">
                    <a href="{{ route('sales.create') }}" class="btn btn-sm btn-success">Add Sales Person</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>Full name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Profile Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                             
                                    <tr>
                                        <td>#</td>
                                        <td>
                                            {{ $sale->name }}
                                            
                                        </td>
                                        <td>
                                            {{ $sale->username }}
                                            
                                        </td>
                                        <td>
                                            {{ $sale->email }}
                                            
                                        </td>
                                        <td>
                                            @if (!empty($sale->profile_image) && File::exists(public_path('storage/ProfileImage/' . $sale->profile_image)))
                                            <img style="height: 82px; width: 82px;" src="{{ asset('storage/ProfileImage/'.$sale->profile_image) }}" alt="">
                                                
                                            @else
                                            <img style="height: 82px; width: 82px;" src="{{asset('noimg.png') }}" alt="">
                                                
                                            @endif
                                            
                                            
                                        </td>
                                        
                                        {{-- <td><span id="status-btn{{ $sale->id }}">
                                            <button class="btn btn-sm {{ $sale->status == 'Available' ? 'btn-success' : ($sale->status == 'Inactive' ? 'bg-danger' : 'bg-warning'); }}"  onclick="changeStatus('{{ $sale->id }}', {{ $sale->id}})" >
                                                {{ $sale->status }}
                                            </button>
                                        </span>
                                        </td> --}}
                                        <td>
                                            <a href="{{ route('sales.show', encrypt($sale->id)) }}"><i
                                                class="ti-eye btn btn-sm btn-success"></i></a>
                                            <a href="{{ route('sales.edit', encrypt($sale->id)) }}"><i
                                                    class="ti-pencil btn btn-sm btn-primary"></i></a>
                                            <a href="{{ route('admin.impersonate', $sale->id) }}">        
                                                <i class="ti-power-off btn btn-sm btn-info"></i>
                                            </a>  
                                            <form method="POST"
                                                action="{{ route('sales.destroy', encrypt($sale->id)) }}"
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
