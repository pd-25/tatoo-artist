@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | BannerImage-index')
@section('content')
    <div class="row justify-content-center">

        <div class="col-lg-10">
            <div class="card">
                <div class="card-title pr">
                    <h4>All BannerImages</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-title text-right">
                    @if (Auth::guard('artists')->check())
                        <a href="{{ route('artists.bgetForm') }}" class="btn btn-sm btn-success">Add Banner</a>
                    @else
                        <a href="{{ route('banners.create') }}" class="btn btn-sm btn-success">Add Banner</a>
                    @endif
                   

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>Artist name</th>
                                    <th>Banner image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($banners)>0)
                                    @foreach ($banners as $banner)
                                        <tr>
                                            <td>#</td>

                                            <td>
                                                {{ @$banner->artist->username }}

                                            </td>

                                            <td>
                                                @if (!empty($banner->banner_image) && File::exists(public_path('storage/BannerImage/' . $banner->banner_image)))
                                                    <img style="height: 82px; width: 82px;"
                                                        src="{{ asset('storage/BannerImage/' . $banner->banner_image) }}"
                                                        alt="">
                                                @else
                                                    <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}"
                                                        alt="">
                                                @endif


                                            </td>


                                            <td>
                                                @if (Auth::guard('artists')->check())
                                                    <form method="POST"
                                                        action="{{ route('artists.destroyBanner', encrypt($banner->id)) }}"
                                                        class="action-icon">
                                                        @csrf
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger  delete-icon show_confirm"
                                                            data-toggle="tooltip" title='Delete'>
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('banners.destroy', encrypt($banner->id)) }}"
                                                        class="action-icon">
                                                        @csrf
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger  delete-icon show_confirm"
                                                            data-toggle="tooltip" title='Delete'>
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" style="text-align: center;">
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
                        $("#status-btn" + id).load(window.location.href + " #status-btn" + id);
                        swal('Status updated');
                    } else {
                        swal('Some Error occur, relode the page');
                    }
                }
            });
        }
    </script>
@endsection
