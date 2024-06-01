@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Edit Customer')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4>Edit Customer</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        <form action="{{ route('admin.updateCustomer', $customer->id) }}" method="POST" enctype="multipart/form-data">

                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full name</label><span class="text-danger">*</span>
                                        <input type="text" name="name" class="form-control" value="{{ $customer->name }}">


                                        @error('name')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'name field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Username</label><span class="text-danger">*</span>
                                    <input type="text" name="username" class="form-control" value="{{ $customer->username }}" disabled>


                                    @error('username')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ 'username field is required' }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label><span class="text-danger">*</span>
                                        <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
    
    
                                        @error('phone')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'phone field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label><span class="text-danger">*</span>
                                        <input type="text" name="email" class="form-control" value="{{ $customer->email }}">
    
    
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'email field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label><span class="text-danger">*</span>
                                        <input type="text" name="address" class="form-control" value="{{ $customer->address }}">
    
    
                                        @error('address')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'address field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
