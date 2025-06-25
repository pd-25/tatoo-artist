<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Customer: {{ env('APP_NAME') }}</title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">

    <!-- Styles -->
    <link href="{{ asset('admin-asset/css/lib/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-asset/css/lib/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-asset/css/lib/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-asset/css/lib/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-asset/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body class="bg-primary">

    <div class="unix-login">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-content">
                        <!-- <div class="login-logo">
                            <a href="javascript:void(0)"><span>{{ env('APP_NAME') }}</span></a>
                        </div> -->
                        <div class="login-form">
                            <h4>Customer Registration</h4>
                            @if (Session::has('msg'))
                                <p class="alert alert-danger">{{ Session::get('msg') }}</p>
                            @endif
                            <form method="POST" action="{{ route('custs.store') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label><span class="text-danger">*</span>
                                            <input type="text" name="firstname" value="{{ old('firstname') }}"  class="form-control" placeholder="First Name">
                                            @error('firstname')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label><span class="text-danger">*</span>
                                            <input type="text" name="lastname" value="{{ old('lastname') }}"  class="form-control" placeholder="Last Name">
                                            @error('lastname')
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
                                            <label>Email address</label><span class="text-danger">*</span>
                                            <input type="text" name="email" value="{{ old('email') }}" 
                                                autocomplete="email" autofocus class="form-control" placeholder="Email">
                                            @error('email')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username</label><span class="text-danger">*</span>
                                            <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Username">
                                            @error('username')
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
                                            <label>State</label><span class="text-danger">*</span>
                                            <input type="text" name="customer_state" value="{{ old('customer_state') }}" class="form-control" placeholder="State">
                                            @error('customer_state')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Zip Code</label><span class="text-danger">*</span>
                                            <input type="text" name="zipcode" value="{{ old('zipcode') }}" class="form-control" placeholder="Zip Code">
                                            @error('zipcode')
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
                                            <label>Mobile No.</label><span class="text-danger">*</span>
                                            <input type="text" name="mobile_number" value="{{ old('mobile_number') }}" class="form-control" placeholder="Mobile No.">
                                            @error('mobile_number')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Sex</label><span class="text-danger">*</span>
                                        <div class="form-group">
                                            
                                            <input type="radio" name="sex" value="Male">
                                            <label class="form-check-label" for="sex">
                                                1) Male
                                            </label><br>
                                            <input type="radio" name="sex" value="Female">
                                            <label class="form-check-label" for="sex">
                                                2) Female
                                            </label><br>
                                            <input type="radio" name="sex" value="Other">
                                            <label class="form-check-label" for="sex">
                                                3) Other
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>DOB</label><span class="text-danger">*</span>
                                            <input type="text" name="dob" id="dob" value="{{ old('dob') }}" class="form-control flatpickr" placeholder="DOB">
                                            
                                            @error('dob')
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
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Lead Source</label><span class="text-danger">*</span>
                                            <select class="form-control" name="lead_source">
                                                <option value="">Select</option>
                                        
                                                @foreach($leads as $key=>$value)
                                                    
                                                    <option @if($value->id == old('lead_source')) selected @endif value="{{ $value->id }}">{{ $value->lead_source_name }}</option>
                                                    
                                                @endforeach
                                                  
                                            </select>

                                            </select>
                                            @error('lead_source')
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
                                            <label>Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                            @error('password')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Re-enter Password</label>
                                            <input type="password" name="conf_password" class="form-control" placeholder="Re-enter Password">
                                            @error('conf_password')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                

                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Register</button>
                                <center><span style="color:blue;">Already have account?</span><a href="{{ route('customerLogin') }}"> Sign In</a></center>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr(".flatpickr", {
            dateFormat: "m-d-Y", // Customize the date format
            allowInput: true, // Allow manual input
            // defaultDate: "today", // Set default date to today
        });
    });
</script>

</body>

</html>
