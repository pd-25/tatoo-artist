@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Artwork-Edit')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4>Edit Artwork</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        @if (Auth::guard('artists')->check())
                        <form action="{{ route('artist.updateArtwork', encrypt($artwork->id)) }}" method="POST"
                            enctype="multipart/form-data">
                        @else
                        <form action="{{ route('artworks.update', encrypt($artwork->id)) }}" method="POST"
                            enctype="multipart/form-data">
                            @endif
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Artist Name</label><span class="text-info">(the artist can't be
                                            changed)</span>
                                        @if (Auth::guard('artists')->check())
                                            <input type="text" class="form-control" placeholder="Artist Name" name="artist_name" value="{{ $payments->artist->name }}" readonly>
                                            <input type="hidden" name="user_id" value="{{ Auth::guard('artists')->user()->id; }}">
                                        @else
                                            <select name="user_id" class="form-control" value="{{ old('user_id') }}">
                                                <option value="">select artist</option>
                                                @foreach ($artists as $artist)
                                                    <option {{ $artwork->user_id == $artist->id ? 'selected' : '' }}
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

                                    <div class="form-group">
                                        <label>Style Name</label><span class="text-danger">*</span>
                                        <select name="style_id" class="form-control" value="{{ old('style_id') }}">
                                            <option value="">select style</option>
                                            @foreach ($styles as $style)
                                                <option {{ $artwork->style_id == $style->id ? 'selected' : '' }}
                                                    value="{{ $style->id }}">{{ $style->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('style_id')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'Style field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Placement Name</label><span class="text-danger">*</span>
                                        <select name="placement_id" class="form-control" value="{{ old('placement_id') }}">
                                            <option value="">select placement</option>
                                            @foreach ($placements as $placement)
                                                <option {{ $artwork->placement_id == $placement->id ? 'selected' : '' }}
                                                    value="{{ $placement->id }}">{{ $placement->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('placement_id')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'Placement field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Subject Name</label><span class="text-danger">*</span>
                                        <select name="subject_id" class="form-control" value="{{ old('subject_id') }}">
                                            <option value="">select placement</option>
                                            @foreach ($subjects as $subject)
                                                <option {{ $artwork->subject_id == $subject->id ? 'selected' : '' }}
                                                    value="{{ $subject->id }}">{{ $subject->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('subject_id')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'Subject field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label><span class="text-danger">*</span>
                                        <input type="text" name="country" class="form-control"
                                            value="{{ $artwork->country }}" required>
                                        @error('country')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'country field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Zipcode</label><span class="text-danger">*</span>
                                        <input type="number" name="zipcode" class="form-control"
                                            value="{{ $artwork->zipcode }}" required>
                                        @error('zipcode')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'Zipcode field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Artwork title</label><span class="text-info">(This is auto generated, not
                                    changable)</span>
                                <span class="form-control">{{ $artwork->title }}</span>
                                @error('image')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Attach new artwork image if you want to change</label>
                                <input type="file" class="form-control" name="image">
                                @error('image')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Current image</label>
                                @if (!empty($artwork->image) && File::exists(public_path('storage/ArtworkImage/' . $artwork->image)))
                                    <img style="height: 82px; width: 82px;"
                                        src="{{ asset('storage/ArtworkImage/' . $artwork->image) }}" alt="">
                                @else
                                    <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}" alt="">
                                @endif

                            </div>

                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
