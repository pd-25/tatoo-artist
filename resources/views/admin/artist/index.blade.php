@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Artist-index'  )
@section('content')
    <div class="row justify-content-center">

        <div class="col-lg-10">
            <div class="card">
                <div class="card-title pr">
                    <h4>All Artists</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-title text-right">
                    <a href="{{ route('artists.create') }}" class="btn btn-sm btn-success">Add Artist</a>

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
                                @if(count($artists)>0)
                                    @foreach ($artists as $index => $artist)
                                
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                                {{ $artist->name }}
                                                
                                            </td>
                                            <td>
                                                {{ $artist->username }}
                                                
                                            </td>
                                            <td>
                                                {{ $artist->email }}
                                                
                                            </td>
                                            <td>
                                                @if (!empty($artist->profile_image) && File::exists(public_path('storage/ProfileImage/' . $artist->profile_image)))
                                                <img style="height: 82px; width: 82px;" src="{{ asset('storage/ProfileImage/'.$artist->profile_image) }}" alt="">
                                                    
                                                @else
                                                <img style="height: 82px; width: 82px;" src="{{asset('noimg.png') }}" alt="">
                                                    
                                                @endif
                                                
                                                
                                            </td>
                                            
                                            {{-- <td><span id="status-btn{{ $artist->id }}">
                                                <button class="btn btn-sm {{ $artist->status == 'Available' ? 'btn-success' : ($artist->status == 'Inactive' ? 'bg-danger' : 'bg-warning'); }}"  onclick="changeStatus('{{ $artist->id }}', {{ $artist->id}})" >
                                                    {{ $artist->status }}
                                                </button>
                                            </span>
                                            </td> --}}
                                            <td>
                                                <a href="{{ route('artists.show', encrypt($artist->id)) }}"><i
                                                    class="ti-eye btn btn-sm btn-success"></i></a>
                                                <a href="{{ route('artists.edit', encrypt($artist->id)) }}"><i
                                                        class="ti-pencil btn btn-sm btn-primary"></i></a>
                                                <form method="POST"
                                                    action="{{ route('artists.destroy', encrypt($artist->id)) }}"
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
