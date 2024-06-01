@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Comment-index'  )
@section('content')
    <div class="row justify-content-center">

        <div class="col-lg-10">
            <div class="card">
                <div class="card-title pr">
                    <h4>All Comments</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                {{-- <div class="card-title text-right">
                    <a href="{{ route('artworks.create') }}" class="btn btn-sm btn-success">Add Comment</a>

                </div> --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>Commented by</th>
                                    <th>Comment</th>
                                    <th>Artwork Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($comments)>0)
                                    @foreach ($comments as $comment)
                                
                                        <tr>
                                            <td>#</td>
                                            <td>
                                                {{ $comment->user->username }}
                                                
                                            </td>
                                            <td>
                                                {{ $comment->comment }}
                                                
                                            </td>
                                        
                                            <td>
                                                @if (!empty($comment->artwork->image) && File::exists(public_path('storage/ArtworkImage/' . $comment->artwork->image)))
                                                <img style="height: 82px; width: 82px;" src="{{ asset('storage/ArtworkImage/'.$comment->artwork->image) }}" alt="">
                                                    
                                                @else
                                                <img style="height: 82px; width: 82px;" src="{{asset('noimg.png') }}" alt="">
                                                    
                                                @endif
                                                
                                                
                                            </td>
                                            
                                            {{-- <td><span id="status-btn{{ $comment->id }}">
                                                <button class="btn btn-sm {{ $comment->status == 'Available' ? 'btn-success' : ($comment->status == 'Inactive' ? 'bg-danger' : 'bg-warning'); }}"  onclick="changeStatus('{{ $comment->id }}', {{ $comment->id}})" >
                                                    {{ $comment->status }}
                                                </button>
                                            </span>
                                            </td> --}}
                                            <td>
                                            
                                                
                                                <form method="POST"
                                                    action="{{ route('comment.delete', encrypt($comment->id)) }}"
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
                                        <td colspan="5" style="text-align: center;">
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
