@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Artwork-create')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4>Create Artwork</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        @if (Auth::guard('artists')->check())
                            <form action="{{ route('artists.uploadArtistWiseArtwork') }}" method="POST"
                                enctype="multipart/form-data">
                            @else
                                <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data">
                        @endif

                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist Name</label><span class="text-danger">*</span>
                                    {{-- <input type="text"  placeholder="full name" name="name"
                                            value="{{ old('name') }}"> --}}
                                            @if (Auth::guard('artists')->check())
                                            <select name="user_id" id="user_id" class="form-control" value="{{ old('user_id') }}">
                                                <option selected value="{{ auth()->guard('artists')->id() }}">{{ auth()->guard('artists')->user()->name }}</option>
                                               
                                            </select>
                                            @else
                                            <select name="user_id" id="user_id" class="form-control" value="{{ old('user_id') }}">
                                                <option value="">select artists</option>
                                                @foreach ($artists as $artist)
                                                    <option data-zipcode="{{ $artist->zipcode }}" value="{{ $artist->id }}">
                                                        {{ $artist->username }}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                   

                                    @error('user_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ 'Artist name field is required' }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Style Name</label><span class="text-danger">*</span>
                                    <select name="style_id" class="form-control" value="{{ old('style_id') }}">
                                        <option value="">select style</option>
                                        @foreach ($styles as $style)
                                            <option value="{{ $style->id }}">{{ $style->title }}</option>
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
                                            <option value="{{ $placement->id }}">{{ $placement->title }}</option>
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
                                            <option value="{{ $subject->id }}">{{ $subject->title }}</option>
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
                                        value="United States of America" required>
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
                                      @if (Auth::guard('artists')->check())
                                         <input type="number" name="zipcode" class="form-control" value="{{ auth()->guard('artists')->user()->zipcode }}"
                                            id="zipcode" required>
                                      @else
                                        <input type="number" name="zipcode" class="form-control" value="{{ old('zipcode') }}"
                                        id="zipcode" required>
                                      @endif
                                  
                                    @error('zipcode')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ 'Zipcode field is required' }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Attach the artwork image here</label><span class="text-danger">*</span>
                            <input type="file" class="form-control" name="image" value="{{ old('image') }}">
                            @error('image')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label><span class="text-danger">*</span>
                                        <input type="password" class="form-control" placeholder="password" name="password"
                                            value="{{ old('password') }}">
                                        @error('password')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Zipcode</label><span class="text-danger">*</span>
                                        <input type="number" class="form-control" placeholder="zipcode" name="zipcode"
                                            value="{{ old('zipcode') }}">
                                        @error('zipcode')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Profile Image</label>
                                        <input type="file" class="form-control" name="profile_image"
                                            value="{{ old('profile_image') }}">
                                        @error('profile_image')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Banner Image</label>
                                        <input type="file" class="form-control" name="banner_image"
                                            value="{{ old('banner_image') }}">
                                        @error('banner_image')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}








                        <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('user_id').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var zipcode = selectedOption.getAttribute('data-zipcode');
                document.getElementById('zipcode').value = zipcode;
            });
        </script>
    @endsection
