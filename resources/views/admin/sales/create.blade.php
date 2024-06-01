@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Artist-create')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4>Create Sales Person</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data" id="artistProfileUpdate">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Artist Name</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" placeholder="full name" name="name"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Username</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" placeholder="username" name="username"
                                            value="{{ old('username') }}">
                                        @error('username')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" placeholder="email address"
                                            name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" id="phone" placeholder="phone number" name="phone"
                                            value="{{ old('phone') }}">
                                        @error('name')
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
                                        <label>Password</label><span class="text-danger">*</span>
                                        <input type="password" class="form-control" placeholder="password" name="password"
                                            value="{{ old('password') }}">
                                        @error('password')
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

                            <button type="submit" id="submitProfileUpdate" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <!-- Include Inputmask from CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAE6dk-Oc544R2gZpwVqPQDhN0VGAjkxhw&loading=async&libraries=places&callback=initAutocomplete"></script>


        <script>
             // Function to initialize the autocomplete
             function initAutocomplete() {
                // Create the autocomplete object, restricting the search to the US
                var input = $('#autocomplete')[0];
                var options = {
                    types: ['address'],
                    componentRestrictions: { country: 'us' }
                };
                var autocomplete = new google.maps.places.Autocomplete(input, options);

                // Event listener for when a place is selected
                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    if (!place.geometry) {
                        console.log("No details available for input: '" + place.name + "'");
                        return;
                    }

                    // Extracting address components
                    var addressComponents = place.address_components;
                    var country = '';
                    var state = '';
                    var city = '';
                    var zipCode = '';

                    // Loop through each component to find country, state, city, and zip code
                    $.each(addressComponents, function(index, component) {
                        var componentType = component.types[0];
                        if (componentType === 'country') {
                            country = component.long_name;
                        } else if (componentType === 'administrative_area_level_1') {
                            state = component.long_name;
                        } else if (componentType === 'locality') {
                            city = component.long_name;
                        } else if (componentType === 'postal_code') {
                            zipCode = component.long_name;
                        }
                    });

                    // Extract latitude and longitude
                    var latitude = place.geometry.location.lat();
                    var longitude = place.geometry.location.lng();

                    if(country.length > 0){
                        $("#country").val(country);
                    }

                    if(state.length > 0){
                        $("#state").val(state);
                    }

                    if(city.length > 0){
                        $("#city").val(city);
                    }

                    if(zipCode.length > 0){
                        $("#zipcode").val(zipCode);
                    }

                    $("#latitude").val(latitude);
                    $("#longitude").val(longitude);

                    // Display the extracted address components
                    console.log('Country:', country);
                    console.log('State:', state);
                    console.log('City:', city);
                    console.log('Zip Code:', zipCode);
                    console.log('Latitude:', latitude);
                    console.log('Longitude:', longitude);
                });
            }

            $(document).ready(function() {
                $('#phone').inputmask('(999) 999-9999');

                $("#submitProfileUpdate").on("click",function(){
                    $("#phone").inputmask({removeMaskOnSubmit: true});
                    $("#artistProfileUpdate").submit();
                });
            });
        </script>
    @endsection
