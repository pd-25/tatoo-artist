@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Category-show')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4> Artist Details</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {{-- <form action="{{ route('artists.update', encrypt($artist->id)) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist Name</label>
                                    <span class="form-control">{{ $artist->name }}</span>

                                </div>

                                <div class="form-group">
                                    <label>Username</label>
                                    <span class="form-control">{{ $artist->username }}</span>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <span class="form-control">{{ $artist->email }}</span>

                                </div>

                                <div class="form-group">
                                    <label>Phone</label>

                                    <span class="form-control">{{ $artist->phone }}</span>

                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <span class="form-control">{{ $artist->address }}</span>

                                </div>

                                <div class="form-group">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Zipcode</label><span class="text-danger">*</span>
                                    <input type="number" class="form-control" placeholder="zipcode" name="zipcode"
                                        value="{{ $artist->zipcode }}">
                                    @error('zipcode')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current Profile Image</label>
                                    @if (!empty($artist->profile_image) && File::exists(public_path('storage/ProfileImage/' . $artist->profile_image)))
                                        <img style="height: 82px; width: 82px;"
                                            src="{{ asset('storage/ProfileImage/' . $artist->profile_image) }}"
                                            alt="">
                                    @else
                                        <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}"
                                            alt="">
                                    @endif
                                </div>

                                <div class="form-group">

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current Banner Image</label>
                                    @if (!empty($artist->banner_image) && File::exists(public_path('storage/BannerImage/' . $artist->banner_image)))
                                        <img style="height: 82px; width: 82px;"
                                            src="{{ asset('storage/BannerImage/' . $artist->banner_image) }}"
                                            alt="">
                                    @else
                                        <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="form-group">

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                @if ($artist->artworks->count() > 0)
                    <h4>All artworks</h4>
                    <div class="row">


                        @foreach ($artist->artworks as $item)
                            <div class="col-md-3">
                                @if (!empty($item->image) && File::exists(public_path('storage/ArtworkImage/' . $item->image)))
                                    <div>
                                        <img style="height: 185px; width: 182px;"
                                            src="{{ asset('storage/ArtworkImage/' . $item->image) }}" alt="">
                                    </div>
                                    <span>{{ $item->title }}</span>
                                @else
                                    <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}" alt="">
                                @endif
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>


        </div>
    @endsection
