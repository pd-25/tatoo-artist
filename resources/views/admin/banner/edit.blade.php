@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | BannerImage-create')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4>Edit Carousel Image</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        @if (Auth::guard('artists')->check())
                            <form action="{{ route('artists.updateArtistWiseBanner', $banner->id) }}" method="POST" enctype="multipart/form-data">
                        @else
                            <form action="{{ route('artists.updateArtistWiseBanner', $banner->id) }}" method="POST" enctype="multipart/form-data">
                        @endif
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist Name</label><span class="text-info">(the artist can't be
                                        changed)</span>
                                    @if (Auth::guard('artists')->check())
                                    <select name="user_id" id="user_id" class="form-control" value="{{ old('user_id') }}">
                                        <option selected value="{{ auth()->guard('artists')->id() }}">{{ auth()->guard('artists')->user()->name }}</option>
                                       
                                    </select>
                                        {{-- <input type="text" class="form-control" placeholder="Artist Name" name="artist_name" value="{{ $payments->artist->name }}" readonly> --}}
                                        <input type="hidden" name="user_id" value="{{ Auth::guard('artists')->user()->id }}">


                                    @else
                                        <select name="user_id" class="form-control" value="{{ old('user_id') }}">
                                            <option value="">select artist</option>
                                            @foreach ($artists as $artist)
                                                <option {{ $banner->user_id == $artist->id ? 'selected' : '' }}
                                                    value="{{ $artist->id }}">{{ $artist->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                    @error('artist_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>    

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Attach the Banner Image Here</label><span class="text-danger">*</span>
                                    <input type="file" class="form-control" name="banner_image">
                                    @error('banner_image')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-group">
                                        <label>Current image</label>
                                        @if (!empty($banner->banner_image) && File::exists(public_path('storage/BannerImage/' . $banner->banner_image)))
                                            <img style="height: 82px; width: 82px;"
                                                src="{{ asset('storage/BannerImage/' . $banner->banner_image) }}" alt="">
                                        @else
                                            <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}" alt="">
                                        @endif
        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input type="date" class="form-control" name="from_date" value="{{$banner->from_date}}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input type="date" class="form-control" name="to_date" value="{{$banner->to_date}}">
                                </div>   
                            </div>
                        </div>                             

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" style="width:100%; height:80px;">{{ $banner->description }}</textarea>
                                </div> 
                            </div>
                        </div>        

                        <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
