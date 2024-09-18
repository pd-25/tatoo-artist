@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Add Customer')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4>Add Customer</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('admin.storeCustomer') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full name</label><span class="text-danger">*</span>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'name field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label><span class="text-danger">*</span>
                                        <input type="text" name="username" class="form-control" value="{{ old('username') }}">
                                        @error('username')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'username field is required' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label><span class="text-danger">*</span>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="+1 (111) 333-1234" maxlength="18" pattern="\+\d{1} \(\d{3}\) \d{3}-\d{4}" required>
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
                                        <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ 'email field is required' }}</strong>
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
    </div>
    <script>
        document.getElementById('phone').addEventListener('input', function (e) {
            // Remove non-digit characters except for "+"
            var value = e.target.value.replace(/[^\d]/g, '');
    
            // Ensure the phone number starts with "1" (US country code)
            if (value.length > 0 && value.charAt(0) !== '1') {
                value = '1' + value;
            }
    
            // Limit the number to 11 digits (including the country code "1")
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
    
            // Start formatting the phone number
            var formattedValue = '+1 ';
    
            // Format the first 3 digits (area code)
            if (value.length > 1) {
                formattedValue += '(' + value.substring(1, 4) + ') ';
            }
    
            // Format the next 3 digits
            if (value.length >= 5) {
                formattedValue += value.substring(4, 7) + '-';
            }
    
            // Format the remaining 4 digits
            if (value.length >= 8) {
                formattedValue += value.substring(7, 11);
            }
    
            // Set the formatted value back to the input field
            e.target.value = formattedValue;
        });
    </script>
    
    
@endsection
