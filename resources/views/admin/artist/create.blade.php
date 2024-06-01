@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Artist-create')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4>Create Artist</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('artists.store') }}" method="POST" enctype="multipart/form-data" id="artistProfileUpdate">
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
                            
                            <div class="form-group">
                                <label>Main Address</label>
                                <input type="text" class="form-control" placeholder="address" name="address" id="autocomplete"> 
                                <input type="hidden" name="latitude" id="latitude">    
                                <input type="hidden" name="longitude" id="longitude">    
                                @error('address')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Address Line 2</label>
                                <input type="text" class="form-control" placeholder="Enter additional address details like premises, apartment no etc." name="address2"> 
                                @error('address2')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="country" placeholder="Country" name="country">
                                        @error('country')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="state" placeholder="state" name="state">
                                        @error('state')
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
                                        <label>City</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="city" placeholder="city" name="city">
                                        @error('city')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Zip Code</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="zipcode" placeholder="zipcode" name="zipcode">
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
                                        <label>Hourly Rate</label><span class="text-danger">*</span>
                                        <input type="number" class="form-control" id="hourly_rate" placeholder="Hourly Rate" name="hourly_rate">
                                        @error('hourly_rate')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Speciality</label><span class="text-danger">*</span>
                                        <select name="specialty" class="form-control" value="{{ old('specialty') }}">
                                            <option value="">select style</option>
                                            @foreach ($styles as $style)
                                                <option value="{{ $style->id }}">{{ $style->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('specialty')
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
                                        <label>Years In Trade</label><span class="text-danger">*</span>
                                        <input type="number" class="form-control" id="years_in_trade" placeholder="Years In Trade" name="years_in_trade">
                                        @error('years_in_trade')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Walk in Welcome</label>
                                        <select name="walk_in_welcome" class="form-control" value="{{ old('walk_in_welcome') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('walk_in_welcome')
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
                                        <label>Certified Professionals</label><span class="text-danger">*</span>
                                        <select name="certified_professionals" class="form-control" value="{{ old('certified_professionals') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('certified_professionals')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Consultations Available</label>
                                        <select name="consultation_available" class="form-control" value="{{ old('consultation_available') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('consultation_available')
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
                                        <label>Language Spoken</label><span class="text-danger">*</span>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="language_spoken[]" value="English" id="English" checked>
                                            <label class="form-check-label" for="English">
                                                English
                                            </label>
                                          </div>
                                         
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="language_spoken[]" value="Spanish" id="Spanish">
                                            <label class="form-check-label" for="Spanish">
                                              Spanish
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="language_spoken[]" value="French" id="French">
                                            <label class="form-check-label" for="French">
                                              French
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="language_spoken[]" value="Italian" id="Italian">
                                            <label class="form-check-label" for="Italian">
                                              Italian
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="language_spoken[]" value="Chinese" id="Chinese">
                                            <label class="form-check-label" for="Chinese">
                                              Chinese
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="language_spoken[]" value="Farsi" id="Farsi">
                                            <label class="form-check-label" for="Farsi">
                                              Farsi
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="language_spoken[]" value="Other" id="Other">
                                            <label class="form-check-label" for="Other">
                                              Other
                                            </label>
                                          </div>
                                        @error('language_spoken')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Parking Available</label>
                                        <select name="parking" class="form-control" value="{{ old('parking') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('parking')
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
                                        <label>Payment Option</label><span class="text-danger">*</span>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="payment_method[]" value="Cash" id="Cash" checked>
                                            <label class="form-check-label" for="Cash">
                                                Cash
                                            </label>
                                          </div>
                                         
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="payment_method[]" value="Check" id="Check">
                                            <label class="form-check-label" for="Check">
                                              Check
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="payment_method[]" value="CC" id="CC">
                                            <label class="form-check-label" for="CC">
                                              CC
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="payment_method[]" value="Venomo" id="Venomo">
                                            <label class="form-check-label" for="Venomo">
                                              Venomo
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="payment_method[]" value="Zelle" id="Zelle">
                                            <label class="form-check-label" for="Zelle">
                                              Zelle
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="payment_method[]" value="CashApp" id="CashApp">
                                            <label class="form-check-label" for="CashApp">
                                              CashApp
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="payment_method[]" value="Paypal" id="Paypal">
                                            <label class="form-check-label" for="Paypal">
                                              Paypal
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="payment_method[]" value="ApplePay" id="ApplePay">
                                            <label class="form-check-label" for="ApplePay">
                                              ApplePay
                                            </label>
                                          </div>

                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="payment_method[]" value="GooglePay" id="GooglePay">
                                            <label class="form-check-label" for="GooglePay">
                                              GooglePay
                                            </label>
                                          </div>

                                        @error('payment_method')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Air Conditioned</label>
                                        <select name="air_conditioned" class="form-control" value="{{ old('air_conditioned') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('air_conditioned')
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
                                        <label>Water Available</label><span class="text-danger">*</span>
                                        <select name="water_available" class="form-control" value="{{ old('certified_professionals') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('water_available')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coffee Available</label>
                                        <select name="coffee_available" class="form-control" value="{{ old('coffee_available') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('coffee_available')
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
                                        <label>Masks Worn</label><span class="text-danger">*</span>
                                        <select name="mask_worn" class="form-control" value="{{ old('mask_worn') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('mask_worn')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vaccinated Staff</label>
                                        <select name="vaccinated_staff" class="form-control" value="{{ old('vaccinated_staff') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('vaccinated_staff')
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
                                        <label>Wheel Chair Accessible</label><span class="text-danger">*</span>
                                        <select name="wheel_chair_accessible" class="form-control" value="{{ old('mask_worn') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('wheel_chair_accessible')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Bike Parking</label>
                                        <select name="bike_parking" class="form-control" value="{{ old('bike_parking') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('bike_parking')
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
                                        <label>Wifi Available</label><span class="text-danger">*</span>
                                        <select name="wifi_available" class="form-control" value="{{ old('wifi_available') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('wifi_available')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Artist of The Year</label>
                                        <select name="artist_of_the_year" class="form-control" value="{{ old('artist_of_the_year') }}">
                                            <option selected disabled>select option</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        @error('artist_of_the_year')
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
                                        <label>Instagram Account</label><span class="text-danger">*</span>
                                        <input type="url" class="form-control" id="insta_handle" placeholder="Instagram Account" name="insta_handle">
                                        @error('insta_handle')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Facebook Account</label><span class="text-danger">*</span>
                                        <input type="url" class="form-control" id="facebook_handle" placeholder="facebook_handle" name="facebook_handle">
                                        @error('facebook_handle')
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
                                        <label>YouTube Account</label><span class="text-danger">*</span>
                                        <input type="url" class="form-control" id="youtube_handle" placeholder="YouTube Account" name="youtube_handle">
                                        @error('youtube_handle')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>X - Twitter</label><span class="text-danger">*</span>
                                        <input type="url" class="form-control" id="twitter_handle" placeholder="X - Twitter" name="twitter_handle">
                                        @error('twitter_handle')
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
                                        <label>Google Map API</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="google_map_api" placeholder="Google Map API" name="google_map_api">
                                        @error('google_map_api')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Yelp API</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="yelp_api" placeholder="Yelp API" name="yelp_api">
                                        @error('yelp_api')
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
                                        <label>Shop Logo</label><span class="text-danger">*</span>
                                        <input type="file" class="form-control" name="shop_logo"
                                            value="{{ old('shop_logo') }}">
                                        @error('shop_logo')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Shop Percentage</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="shop_percentage" placeholder="Shop Percentage" name="shop_percentage">
                                        @error('shop_percentage')
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
                                        <label>Shop Email</label><span class="text-danger">*</span>
                                        <input type="email" class="form-control" id="shop_email" placeholder="Shop Email" name="shop_email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"> 
                                        @error('shop_email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>    
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Shop Name</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="shop_name" placeholder="Shop Name" name="shop_name">
                                        @error('shop_name')
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
                                        <label>Shop Address</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" id="shop_address" placeholder="Shop Address" name="shop_address"> 
                                        @error('shop_address')
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
                            </div>    
                                
                            <div class="row">
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
                                
                                <div class="col-md-6">
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
                            </div>    

                            <div class="row">

                                <div class="col-md-2">
                                    <label>Sunday Time</label>
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="sunday_from" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="sunday_to" class="form-control">

                                </div>



                                <div class="col-md-2">
                                    <label>Monday Time</label>
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="monday_from" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="monday_to" class="form-control">

                                </div>

                                <div class="col-md-2">
                                    <label>Tuesday Time</label>
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="tuesday_from" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="tuesday_to" class="form-control">

                                </div>

                                <div class="col-md-2">
                                    <label>Wednesday Time</label>
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="wednesday_from" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="wednesday_to" class="form-control">

                                </div>

                                <div class="col-md-2">
                                    <label>Thursday Time</label>
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="thrusday_from" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="thrusday_to" class="form-control">

                                </div>

                                <div class="col-md-2">
                                    <label>Friday Time</label>
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="friday_from" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="friday_to" class="form-control">

                                </div>

                                <div class="col-md-2">
                                    <label>Saturday Time</label>
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="saterday_from" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <input type="time" name="saterday_to" class="form-control">

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
