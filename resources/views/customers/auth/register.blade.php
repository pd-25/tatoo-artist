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
                        <div class="login-form">
                            <h4>Customer Registration</h4>
                            @if (Session::has('msg'))
                            <p class="alert alert-danger">{{ Session::get('msg') }}</p>
                            @endif
                            <form method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label><span class="text-danger">*</span>
                                            <input type="text" name="firstname" value="{{ old('firstname') }}" class="form-control" placeholder="First Name">
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
                                            <input type="text" name="lastname" value="{{ old('lastname') }}" class="form-control" placeholder="Last Name">
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
                                            <input type="email" name="email" value="{{ old('email') }}"
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
                                            <select name="customer_state" id="state" class="form-control">
                                                <option value="">Select State</option>
                                                @php
                                                $states = [
                                                'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado',
                                                'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho',
                                                'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
                                                'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
                                                'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada',
                                                'New Hampshire', 'New Jersey', 'New Mexico', 'New York',
                                                'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon',
                                                'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota',
                                                'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington',
                                                'West Virginia', 'Wisconsin', 'Wyoming'
                                                ];
                                                @endphp
                                                @foreach ($states as $state)
                                                <option value="{{ $state }}" {{ old('customer_state') == $state ? 'selected' : '' }}>
                                                    {{ $state }}
                                                </option>
                                                @endforeach
                                            </select>
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
                                            <input type="number" name="zipcode" value="{{ old('zipcode') }}" class="form-control" placeholder="Zip Code" id="zipcode" maxlength="5"
                                                oninput="this.value=this.value.slice(0,5)">
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
                                            <input type="text" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}" class="form-control" placeholder="(999) 999-9999" minlength="10">
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
                                            <input type="radio" name="sex" id="male_radio" value="">
                                            <label class="form-check-label" for="sex">
                                                1) Male
                                            </label><br>
                                            <input type="radio" name="sex" id="female_radio" value="">
                                            <label class="form-check-label" for="sex">
                                                2) Female
                                            </label><br>
                                            <input type="radio" name="sex" id="other_radio" value="">
                                            <label class="form-check-label" for="sex">
                                                3) Other
                                            </label>

                                            @error('sex')
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
                                            <label>DOB</label><span class="text-danger">*</span>
                                            <input type="date" name="dob" id="dob" value="{{ old('dob') }}" class="form-control flatpickr" placeholder="DOB">

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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Lead Source</label><span class="text-danger">*</span>
                                            <select class="form-control" name="lead_source" id="lead_source" onchange="show_other_lead_field()">
                                                <option value="">Select</option>
                                                @foreach($leads as $key=>$value)
                                                <option value="{{ $value->id }}">{{ $value->lead_source_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('lead_source')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" id="other_lead" style="display:none;">
                                            <label>Other Lead Source</label><span class="text-danger">*</span>
                                            <input type="text" name="other_lead_source" id="other_lead_source" value="{{ old('other_lead_source') }}" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-12">
                                        <div class="form-group" id="note">
                                            <label>Give A Note</label><span class="text-danger">*</span>
                                            <textarea type="text" name="note" id="note" value="{{ old('not') }}" class="form-control" style="height: 100px;" placeholder="Give a note" rows="5">{{ old('note') }}</textarea>

                                            </textarea>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Password" value="{{ old('password') }}">
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
                                            <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter Password" value="{{ old('confirm_password') }}">
                                            @error('confirm_password')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Register</button>
                                <span style="color:blue;">Already have account?</span><a href="{{ route('customerLogin') }}"> Sign In</a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr(".flatpickr", {
                dateFormat: "m-d-Y",
                allowInput: true,
                maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 13)),
                minDate: new Date(new Date().setFullYear(new Date().getFullYear() - 100)),
                defaultDate: new Date(new Date().setFullYear(new Date().getFullYear() - 25))
            });
        });

        // Mobile number formatting
        document.getElementById('mobile_number').addEventListener('input', function(e) {
            // Remove all non-digit characters
            let phoneNumber = e.target.value.replace(/\D/g, '');

            // Format the phone number
            if (phoneNumber.length > 0) {
                phoneNumber = '(' + phoneNumber.substring(0, 3) + ') ' + phoneNumber.substring(3, 6) + '-' + phoneNumber.substring(6, 10);
            }

            // Update the input value
            e.target.value = phoneNumber;

            // Store the raw numbers in a data attribute
            const rawNumber = e.target.value.replace(/\D/g, '');
            e.target.setAttribute('data-raw-value', rawNumber);
        });

        // Before form submission, update the value with raw numbers
        document.querySelector('form').addEventListener('submit', function(e) {
            const mobileInput = document.getElementById('mobile_number');
            const rawValue = mobileInput.getAttribute('data-raw-value') || mobileInput.value.replace(/\D/g, '');
            mobileInput.value = rawValue;
        });

        // Radio button value handling
        $("#male_radio").on('change', function() {
            $("#male_radio").val('Male');
            $("#female_radio").val('');
            $("#other_radio").val('');
        });

        $("#female_radio").on('change', function() {
            $("#female_radio").val('Female');
            $("#male_radio").val('');
            $("#other_radio").val('');
        });

        $("#other_radio").on('change', function() {
            $("#other_radio").val('Other');
            $("#male_radio").val('');
            $("#female_radio").val('');
        });

        function show_other_lead_field() {
            var lead_source = $("#lead_source option:selected").text();

            if (lead_source == 'Other') {
                $("#other_lead").show();
                $("#other_lead_source").focus();
            } else {
                $("#other_lead").hide();
                $("#other_lead_source").val("");
            }
        }
    </script>


</body>

</html>