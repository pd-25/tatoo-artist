@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Carousel-create')
@section('content')
<style>
    .myClass {
        width: 500px;
        height: 500px;
        border: solid;
    }

    .ajax-loader {
        visibility: hidden;
        background-color: rgba(255, 255, 255, 0.7);
        position: absolute;
        z-index: +100 !important;
        width: 100%;
        height: 100%;
    }

    .ajax-loader img {
        position: relative;
        top: 50%;
        left: 50%;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card">
            <div class="card-title">
                <h4>Create Carousel Image</h4>
                @if (Session::has('msg'))
                <p class="alert alert-info">{{ Session::get('msg') }}</p>
                @endif
            </div>
            <div class="card-body">
                <div class="basic-form">
                    @if (Auth::guard('artists')->check())
                    <form action="{{ route('artists.uploadArtistWiseCarousel') }}" method="POST" enctype="multipart/form-data">
                        @else
                        <form action="{{ route('carousels.store') }}" method="POST" enctype="multipart/form-data">
                            @endif
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Artist Name</label><span class="text-danger">*</span>
                                        @if (Auth::guard('artists')->check())
                                        <select name="user_id" class="form-control" value="{{ old('user_id') }}">
                                            <option selected value="{{ auth()->guard('artists')->id() }}">
                                                {{ auth()->guard('artists')->user()->name }}
                                            </option>
                                        </select>
                                        @else
                                        <select name="user_id" class="form-control" value="{{ old('user_id') }}">
                                            <option value="">select artists</option>
                                            @foreach ($artists as $artist)
                                            <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                                            @endforeach
                                        </select>
                                        @endif


                                        @error('user_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ 'Artist name field is required' }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Attach the carousel image here</label><span class="text-danger">*</span>
                                        <input type="file" class="form-control" name="carousel"
                                            value="{{ old('carousel') }}">
                                        @error('image')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="text" class="form-control flatpickr" name="from_date" placeholder="mm-dd-yyyy" value="{{ request()->input('start_date') ?? date('m-d-Y') }}">
                                        @error('from_date')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="text" class="form-control flatpickr" name="to_date" placeholder="mm-dd-yyyy" value="{{ request()->input('to_date') ?? date('m-d-Y') }}">
                                        @error('to_date')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" style="width:100%; height:80px;"></textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("input[name='from_date']", {
                dateFormat: "m-d-Y",
                allowInput: false, // prevent user typing wrong format
            });

            flatpickr("input[name='to_date']", {
                dateFormat: "m-d-Y",
                allowInput: false, // prevent invalid manual input
            });
        });
    </script>



    @endsection