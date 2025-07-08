<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tattoo Studio Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }

        input[readonly] {
            background-color: #f8f9fa;
            border-color: #ced4da;
            color: #495057;
            cursor: not-allowed;
        }

        input:disabled {
            background-color: #e9ecef;
        }

        .navbar {
            background-color: #2c3e50;
            padding: 1rem;
        }

        .navbar-brand {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-link {
            color: #ecf0f1 !important;
            margin: 0 1rem;
        }

        .nav-link:hover {
            color: #3498db !important;
        }

        .profile-header {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: #ffffff;
            padding: 2rem;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 15px;
            margin-top: -2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
        }

        .btn-custom {
            background-color: #3498db;
            color: #ffffff;
            border: none;
        }

        .btn-custom:hover {
            background-color: #2980b9;
        }

        #profile_image {
            display: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="{{ asset('logo.jpeg') }}"
                    style="width: 150px; height: 28px; object-fit:cover;" /></a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('customerProfile') }}">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <form method="POST" action="{{ route('customerProfile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="container mt-4">
            <div class="profile-header">
                <div class="row p-4 align-items-center">
                    <div class="col-md-3 d-flex flex-column align-items-center">
                        @if (!empty($profile->profile_image) && File::exists(public_path('storage/ProfileImage/' . $profile->profile_image)))
                            <img style="height: 82px; width: 82px; object-fit: cover; border-radius:50%"
                                src="{{ asset('storage/ProfileImage/' . $profile->profile_image) }}" alt="">
                        @else
                            <img style="height: 82px; width: 82px; object-fit: cover; border-radius:50%"
                                src="{{ asset('noimg.png') }}" alt="">
                        @endif
                        <!-- Hidden File Input -->
                        <input type="file" name="profile_image" id="profile_image" accept="image/*"
                            style="display: none;" onchange="this.form.submit();">

                        <!-- Visible Button -->
                        <button type="button" class="btn btn-warning mt-2"
                            onclick="document.getElementById('profile_image').click();">
                            Update Image
                        </button>
                    </div>

                    <div class="col-md-6 text-center">

                        <h2>{{ $profile->name }}</h2>
                        {{-- <p>{{ $profile->username }}</p> --}}
                    </div>
                </div>
            </div>

            <div class="profile-info">
                <h4 class="mb-4">Client Information</h4>
                @if (Session::has('msg'))
                    <p class="alert alert-success">{{ Session::get('msg') }}</p>
                @endif
                @if (Session::has('error'))
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">User Name</label>
                        <input type="text" class="form-control" value="{{ $profile->username }}" readonly>
                    </div>

                    <div class="col-md-4">
                        @php $exp_name = explode(' ', $profile->name); @endphp
                        <label class="form-label">First Name</label>
                        <input type="text" name="firstname" class="form-control" value="{{ $exp_name[0] }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lastname" class="form-control" value="{{ $exp_name[1] ?? '' }}">
                    </div>
                </div>



                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">State / Province</label>
                        <select name="state" id="state" class="form-control">
                            <option value="">Select State</option>
                            @php
                                $states = [
                                    'Alabama',
                                    'Alaska',
                                    'Arizona',
                                    'Arkansas',
                                    'California',
                                    'Colorado',
                                    'Connecticut',
                                    'Delaware',
                                    'Florida',
                                    'Georgia',
                                    'Hawaii',
                                    'Idaho',
                                    'Illinois',
                                    'Indiana',
                                    'Iowa',
                                    'Kansas',
                                    'Kentucky',
                                    'Louisiana',
                                    'Maine',
                                    'Maryland',
                                    'Massachusetts',
                                    'Michigan',
                                    'Minnesota',
                                    'Mississippi',
                                    'Missouri',
                                    'Montana',
                                    'Nebraska',
                                    'Nevada',
                                    'New Hampshire',
                                    'New Jersey',
                                    'New Mexico',
                                    'New York',
                                    'North Carolina',
                                    'North Dakota',
                                    'Ohio',
                                    'Oklahoma',
                                    'Oregon',
                                    'Pennsylvania',
                                    'Rhode Island',
                                    'South Carolina',
                                    'South Dakota',
                                    'Tennessee',
                                    'Texas',
                                    'Utah',
                                    'Vermont',
                                    'Virginia',
                                    'Washington',
                                    'West Virginia',
                                    'Wisconsin',
                                    'Wyoming',
                                ];
                            @endphp
                            @foreach ($states as $state)
                                <option value="{{ $state }}" {{ $profile->state == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <span class="text-danger"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Zip / Postal Code</label>
                        <input type="text" id="zipcode" name="zipcode" class="form-control"
                            value="{{ $profile->zipcode }}">
                        @error('zipcode')
                            <span class="text-danger"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        @php
                            $rawPhone = preg_replace('/\D/', '', $profile->phone);
                            $formattedPhone =
                                strlen($rawPhone) === 10
                                    ? '(' .
                                        substr($rawPhone, 0, 3) .
                                        ') ' .
                                        substr($rawPhone, 3, 3) .
                                        '-' .
                                        substr($rawPhone, 6)
                                    : $rawPhone;
                        @endphp
                        <input type="text" name="mobile_number" id="mobile_number" class="form-control"
                            value="{{ $formattedPhone }}" placeholder="(999) 9999-999">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $profile->email }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Date of Birth</label>
                        <input type="text" class="form-control" value="{{ $dob }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sex</label>
                        <select name="sex" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ $profile->sex == 'Male' ? 'selected' : '' }}>1) Male</option>
                            <option value="Female" {{ $profile->sex == 'Female' ? 'selected' : '' }}>2) Female
                            </option>
                            <option value="Other" {{ $profile->sex == 'Other' ? 'selected' : '' }}>3) Other</option>
                        </select>

                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Lead Source</label>
                        <input type="text" class="form-control" value="{{ $lead_name }}" readonly>
                    </div>
                    @if (!empty($profile->other_lead_source))
                        <div class="col-md-4">
                            <label class="form-label">Other Lead Source</label>
                            <input type="text" class="form-control" value="{{ $profile->other_lead_source }}"
                                readonly>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary" name="Update">Update</button>

            </div>
        </div>
    </form>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Format mobile input as (999) 9999-999 -->
    <script>
        document.getElementById('mobile_number').addEventListener('input', function(e) {
            let input = e.target.value.replace(/\D/g, '').substring(0, 10);
            let formatted = '';
            if (input.length > 0) {
                formatted += '(' + input.substring(0, 3);
            }
            if (input.length >= 4) {
                formatted += ') ' + input.substring(3, 6);
            }
            if (input.length >= 7) {
                formatted += '-' + input.substring(6, 10);
            }

            e.target.value = formatted;
            e.target.setAttribute('data-raw-value', input); // Optional: store raw digits
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const mobileInput = document.getElementById('mobile_number');
            const raw = mobileInput.getAttribute('data-raw-value') || mobileInput.value.replace(/\D/g, '');
            mobileInput.value = raw;
        });
    </script>

    <!-- Google Maps Autocomplete -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAE6dk-Oc544R2gZpwVqPQDhN0VGAjkxhw&libraries=places&callback=initAutocomplete">
    </script>
    <script>
        function initAutocomplete() {
            var input = document.getElementById('autocomplete');
            var autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['address'],
                componentRestrictions: {
                    country: 'us'
                }
            });

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) return;

                let address = {
                    state: '',
                    zip: '',
                    lat: '',
                    lng: ''
                };

                place.address_components.forEach(function(comp) {
                    if (comp.types.includes('administrative_area_level_1')) address.state = comp.long_name;
                    if (comp.types.includes('postal_code')) address.zip = comp.long_name;
                });

                document.getElementById('state').value = address.state;
                document.getElementById('zipcode').value = address.zip;
                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
            });
        }
    </script>
</body>

</html>
