@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Category-edit')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4>Edit Artist</h4>
                    @if (Session::has('msg'))
                        <p class="alert alert-info">{{ Session::get('msg') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        @if (Auth::guard('artists')->check())
                            <form action="{{ route('artists.profileUpdate', encrypt($artist->id)) }}" id="artistProfileUpdate"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            @else
                                <form action="{{ route('artists.update', encrypt($artist->id)) }}" id="artistProfileUpdate"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                        @endif


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist Name</label><span class="text-danger">*</span>
                                    <input type="text" class="form-control" placeholder="full name" name="name"
                                        value="{{ $artist->name }}">
                                    @error('name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Username</label><span class="text-info"></span>
                              
                                    <input type="text" class="form-control" id="username" placeholder="username"
                                        name="username" value="{{ $artist->username }}">
                                    @error('username')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label><span class="text-info"></span>
                                         <input type="email" class="form-control" id="email" placeholder="email"
                                        name="email" value="{{ $artist->email }}">
                                    
                                    @error('email')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" id="phone" placeholder="phone number"
                                        name="phone" value="{{ $artist->phone }}">
                                    @error('phone')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Main Address</label>
                            <input type="text" class="form-control" placeholder="address" name="address"
                                value="{{ $artist->address }}" id="autocomplete">
                            <input type="hidden" name="latitude" id="latitude" value="{{ @$artist->latitude }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ @$artist->longitude }}">
                            @error('address')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Address Line 2</label>
                            <input type="text" class="form-control"
                                placeholder="Enter additional address details like premises, apartment no etc."
                                name="address2" value="{{ $artist->address2 }}">
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
                                    <input type="text" class="form-control" id="country" placeholder="Country" name="country"
                                        value="{{ $artist->country }}" readonly>
                                    {{-- <select class="form-control" id="country" name="country">
                                        @foreach (config('contry.countries') as $k => $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select> --}}

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
                                    <input type="text" class="form-control" id="state" placeholder="state"
                                        name="state" value="{{ $artist->state }}">
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
                                    <input type="text" class="form-control" id="city" placeholder="city"
                                        name="city" value="{{ $artist->city }}">
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
                                    <input type="text" class="form-control" id="zipcode" placeholder="zipcode"
                                        name="zipcode" value="{{ $artist->zipcode }}">
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
                                    <input type="number" class="form-control" id="hourly_rate"
                                        placeholder="Hourly Rate" name="hourly_rate"
                                        value="{{ @$artistData->hourly_rate }}">
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
                                            <option value="{{ $style->id }}"
                                                {{ @$artistData->specialty == $style->id ? 'selected' : '' }}>
                                                {{ $style->title }}</option>
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
                                    <input type="number" class="form-control" id="years_in_trade"
                                        placeholder="Years In Trade" name="years_in_trade"
                                        value="{{ @$artistData->years_in_trade }}">
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
                                    <select name="walk_in_welcome" class="form-control">
                                        <option disabled>select option</option>
                                        <option value="yes"
                                            {{ @$artistData->walk_in_welcome == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no" {{ @$artistData->walk_in_welcome == 'no' ? 'selected' : '' }}>
                                            No</option>
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
                                    <select name="certified_professionals" class="form-control"
                                        value="{{ old('certified_professionals') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes"
                                            {{ @$artistData->certified_professionals == 'yes' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="no"
                                            {{ @$artistData->certified_professionals == 'no' ? 'selected' : '' }}>No
                                        </option>
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
                                    <select name="consultation_available" class="form-control"
                                        value="{{ old('consultation_available') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes"
                                            {{ @$artistData->consultation_available == 'yes' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="no"
                                            {{ @$artistData->consultation_available == 'no' ? 'selected' : '' }}>No
                                        </option>
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
                                        <input class="form-check-input" type="checkbox" name="language_spoken[]"
                                            value="English" id="English"
                                            {{ in_array('English', @$languageSpoken) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="English">
                                            English
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="language_spoken[]"
                                            value="Spanish" id="Spanish"
                                            {{ in_array('Spanish', @$languageSpoken) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Spanish">
                                            Spanish
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="language_spoken[]"
                                            value="French" id="French"
                                            {{ in_array('French', @$languageSpoken) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="French">
                                            French
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="language_spoken[]"
                                            value="Italian" id="Italian"
                                            {{ in_array('Italian', @$languageSpoken) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Italian">
                                            Italian
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="language_spoken[]"
                                            value="Chinese" id="Chinese"
                                            {{ in_array('Chinese', @$languageSpoken) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Chinese">
                                            Chinese
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="language_spoken[]"
                                            value="Farsi" id="Farsi"
                                            {{ in_array('Farsi', @$languageSpoken) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Farsi">
                                            Farsi
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="language_spoken[]"
                                            value="Other" id="Other"
                                            {{ in_array('Other', @$languageSpoken) ? 'checked' : '' }}>
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
                                    <label>Won't Do</label><span class="text-danger">*</span>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Offensive or Hate Symbols" id="OffensiveHateSymbols"
                                            {{ in_array('Offensive or Hate Symbols', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="OffensiveHateSymbols">
                                            Offensive or Hate Symbols
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Copyrighted Material" id="CopyrightedMaterial"
                                            {{ in_array('Copyrighted Material', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="CopyrightedMaterial">
                                            Copyrighted Material
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Inappropriate Imagery" id="InappropriateImagery"
                                            {{ in_array('Inappropriate Imagery', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="InappropriateImagery">
                                            Inappropriate Imagery
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Eyes" id="Eyes"
                                            {{ in_array('Eyes', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Eyes">
                                            Eyes
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Genitals" id="Genitals"
                                            {{ in_array('Genitals', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Genitals">
                                            Genitals
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Inner Lips" id="InnerLips"
                                            {{ in_array('Inner Lips', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="InnerLips">
                                            Inner Lips
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Armpits" id="Armpits"
                                            {{ in_array('Armpits', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Armpits">
                                            Armpits
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Bottom Of Foot" id="BottomOfFoot"
                                            {{ in_array('Bottom Of Foot', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="BottomOfFoot">
                                            Bottom Of Foot
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Palms" id="Palms"
                                            {{ in_array('Palms', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Palms">
                                            Palms
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Toes" id="Toes"
                                            {{ in_array('Toes', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Toes">
                                            Toes
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Breasts" id="Breasts"
                                            {{ in_array('Breasts', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Breasts">
                                            Breasts
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="wont_do[]" value="Gang Symbols" id="GangSymbols"
                                            {{ in_array('Gang Symbols', @$wontDo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="GangSymbols">
                                            Gang Symbols
                                        </label>
                                    </div>
                            
                                    @error('wont_do')
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
                                        <input class="form-check-input" type="checkbox" name="payment_method[]"
                                            value="Cash" id="Cash"
                                            {{ in_array('Cash', @$PaymentMethod) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Cash">
                                            Cash
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="payment_method[]"
                                            value="Check" id="Check"
                                            {{ in_array('Check', @$PaymentMethod) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Check">
                                            Check
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="payment_method[]"
                                            value="CC" id="CC"
                                            {{ in_array('CC', @$PaymentMethod) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="CC">
                                            CC
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="payment_method[]"
                                            value="Venmo" id="Venmo"
                                            {{ in_array('Venmo', @$PaymentMethod) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Venmo">
                                            Venmo
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="payment_method[]"
                                            value="Zelle" id="Zelle"
                                            {{ in_array('Zelle', @$PaymentMethod) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Zelle">
                                            Zelle
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="payment_method[]"
                                            value="CashApp" id="CashApp"
                                            {{ in_array('CashApp', @$PaymentMethod) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="CashApp">
                                            CashApp
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="payment_method[]"
                                            value="Paypal" id="Paypal"
                                            {{ in_array('Paypal', @$PaymentMethod) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Paypal">
                                            Paypal
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="payment_method[]"
                                            value="ApplePay" id="ApplePay"
                                            {{ in_array('ApplePay', @$PaymentMethod) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ApplePay">
                                            ApplePay
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="payment_method[]"
                                            value="GooglePay" id="GooglePay"
                                            {{ in_array('GooglePay', @$PaymentMethod) ? 'checked' : '' }}>
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
                                    <label>Unique Offerings</label><span class="text-danger">*</span>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="unique_offerings[]" value="Vegan Ink" id="Vegan Ink"
                                        {{ in_array('Vegan Ink', @$uniqueOfferings) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Vegan Ink">
                                            Vegan Ink
                                        </label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="unique_offerings[]" value="Cover Ups" id="Cover Ups"
                                        {{ in_array('Cover Ups', @$uniqueOfferings) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Cover Ups">
                                            Cover Ups
                                        </label>
                                    </div>
                            
                                  
                            
                                    @error('unique_offerings')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>CC Fees </label>
                                <div class="form-group">
                                    <input type="radio" name="cc_fees" value="1"
                                        {{ @$artistData->cc_fees == '1' ? 'checked' : '' }}> 
                                        <label> 1) Credit Card Fees Paid By Shop</label><br>
                                    <input type="radio" name="cc_fees" value="2"
                                        {{ @$artistData->cc_fees == '2' ? 'checked' : '' }}>
                                        <label> 2) Credit Card Fees Shared Using Current Shop Percentage</label><br>
                                    <input type="radio" name="cc_fees" value="3"
                                        {{ @$artistData->cc_fees == '3' ? 'checked' : '' }}>
                                        <label> 3) Credit Card Fess Charged to Artist</label>
                                    @error('cc_fees')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current CC Fees Percent Charged(%)</label>
                                    <div class="form-group">
                                        <input type="number" step="0.01" class="form-control" id="cc_fees_percentage" placeholder="Current CC Fees Percent Charged" name="cc_fees_percentage" value="{{ @$artistData->cc_fees_percentage }}">
                                        @error('cc_fees_percentage')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Parking Available</label>
                                    <select name="parking" class="form-control" value="{{ old('parking') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes" {{ @$artistData->parking == 'yes' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="no" {{ @$artistData->parking == 'no' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                    @error('parking')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Air Conditioned</label>
                                    <select name="air_conditioned" class="form-control"
                                        value="{{ old('air_conditioned') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes"
                                            {{ @$artistData->air_conditioned == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no"
                                            {{ @$artistData->air_conditioned == 'no' ? 'selected' : '' }}>No</option>
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
                                    <label>Water Available</label>
                                    <select name="water_available" class="form-control"
                                        value="{{ old('certified_professionals') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes"
                                            {{ @$artistData->water_available == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no"
                                            {{ @$artistData->water_available == 'no' ? 'selected' : '' }}>No</option>
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
                                    <select name="coffee_available" class="form-control"
                                        value="{{ old('coffee_available') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes"
                                            {{ @$artistData->coffee_available == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no"
                                            {{ @$artistData->coffee_available == 'no' ? 'selected' : '' }}>No</option>
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
                                    <label>Masks Worn</label>
                                    <select name="mask_worn" class="form-control" value="{{ old('mask_worn') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes" {{ @$artistData->mask_worn == 'yes' ? 'selected' : '' }}>
                                            Yes</option>
                                        <option value="no" {{ @$artistData->mask_worn == 'no' ? 'selected' : '' }}>No
                                        </option>
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
                                    <select name="vaccinated_staff" class="form-control"
                                        value="{{ old('vaccinated_staff') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes"
                                            {{ @$artistData->vaccinated_staff == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no"
                                            {{ @$artistData->vaccinated_staff == 'no' ? 'selected' : '' }}>No</option>
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
                                    <label>Wheel Chair Accessible</label>
                                    <select name="wheel_chair_accessible" class="form-control"
                                        value="{{ old('mask_worn') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes"
                                            {{ @$artistData->wheel_chair_accessible == 'yes' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="no"
                                            {{ @$artistData->wheel_chair_accessible == 'no' ? 'selected' : '' }}>No
                                        </option>
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
                                        <option value="yes"
                                            {{ @$artistData->bike_parking == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no" {{ @$artistData->bike_parking == 'no' ? 'selected' : '' }}>
                                            No</option>
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
                                    <label>Wifi Available</label>
                                    <select name="wifi_available" class="form-control"
                                        value="{{ old('wifi_available') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes"
                                            {{ @$artistData->wifi_available == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no"
                                            {{ @$artistData->wifi_available == 'no' ? 'selected' : '' }}>No</option>
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
                                    <select name="artist_of_the_year" class="form-control"
                                        value="{{ old('artist_of_the_year') }}">
                                        <option selected disabled>select option</option>
                                        <option value="yes"
                                            {{ @$artistData->artist_of_the_year == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no"
                                            {{ @$artistData->artist_of_the_year == 'no' ? 'selected' : '' }}>No</option>
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
                                    <label>Instagram Account</label>
                                    <input type="url" class="form-control" id="insta_handle"
                                        placeholder="Instagram Account" name="insta_handle"
                                        value="{{ @$artistData->insta_handle }}">
                                    @error('insta_handle')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Facebook Account</label>
                                    <input type="url" class="form-control" id="facebook_handle"
                                        placeholder="facebook_handle" name="facebook_handle"
                                        value="{{ @$artistData->facebook_handle }}">
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
                                    <label>YouTube Account</label>
                                    <input type="url" class="form-control" id="youtube_handle"
                                        placeholder="YouTube Account" name="youtube_handle"
                                        value="{{ @$artistData->youtube_handle }}">
                                    @error('youtube_handle')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>X - Twitter</label>
                                    <input type="url" class="form-control" id="twitter_handle"
                                        placeholder="X - Twitter" name="twitter_handle"
                                        value="{{ @$artistData->twitter_handle }}">
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
                                    <label>Google Map API</label>
                                    <input type="text" class="form-control" id="google_map_api"
                                        placeholder="Google Map API" name="google_map_api"
                                        value="{{ @$artistData->google_map_api }}">
                                    @error('google_map_api')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Yelp API</label>
                                    <input type="text" class="form-control" id="yelp_api" placeholder="Yelp API"
                                        name="yelp_api" value="{{ @$artistData->yelp_api }}">
                                    @error('yelp_api')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            {{-- <div class="col-md-6">
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
                            </div> --}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shop Percentage</label><span class="text-danger">*</span>
                                    <input type="number" class="form-control" id="shop_percentage"
                                        placeholder="Shop Percentage" name="shop_percentage"
                                        value="{{ @$artistData->shop_percentage }}">
                                    @error('shop_percentage')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
{{-- @dd(!empty($artist->artistData->shop_logo), File::exists(public_path('storage/ShopImage/' . $artist->artistData->shop_logo)), $artist->artistData->shop_logo) --}}
                        <div class="row">

                            {{-- <div class="col-md-6" id="companyLogo">
                                <div class="form-group">
                                    <label>Current Shop Logo</label>
                                   
                                    @if (!empty($artist->artistData->shop_logo) && Storage::disk('public')->exists('ShopImage/' . $artist->artistData->shop_logo))
                                        <img style="height: 82px; width: 82px;" src="{{ asset('storage/ShopImage/' . $artist->artistData->shop_logo) }}" alt="">
                                    @else
                                        <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}" alt="">
                                    @endif

                                </div>
                            </div> --}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ @$artist->created_by == 0 ? 'Admin' : 'Sales Person' }} Email</label><span
                                        class="text-danger">*</span>
                                    <input type="email" class="form-control"
                                        value="{{ @$artist->created_by == 0 ? 'admin@mail.com' : @$artist->createdBy->email }}"
                                        readonly>
                                    @error('shop_email')
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
                                    <input type="email" class="form-control" id="shop_email" placeholder="Shop Email"
                                        name="shop_email" value="{{ @$artistData->shop_email }}"
                                        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
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
                                    <input type="text" class="form-control" id="shop_name" placeholder="Shop Name"
                                        name="shop_name" value="{{ @$artistData->shop_name }}">
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
                                    
                                    <input hidden readonly type="text" class="form-control" id="shop_address"
                                        placeholder="Shop Address" name="shop_address"
                                        value="{{ @$artistData->shop_address }}">
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
                                    <label>Change Password</label><span class="text-info">(if you don't want to change,
                                        don't keep it blank)</span>
                                    <input type="password" class="form-control" placeholder="*************" name="password">
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
                                    <input type="file" class="form-control" name="profile_image">
                                    @error('profile_image')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shop Image</label>
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

                            <div class="col-md-6" id="companyLogo">
                                <div class="form-group">
                                    <label>Current Profile Image</label>
                                    @if (!empty($artist->profile_image) && Storage::disk('public')->exists('ProfileImage/' . $artist->profile_image))
                                        <img style="height: 82px; width: 82px;"
                                            src="{{ asset('storage/ProfileImage/' . $artist->profile_image) }}"
                                            alt="">
                                    @else
                                        <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}"
                                            alt="">
                                    @endif
                                </div>

                                <div class="form-group">

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current Shop Image</label>
                                    @if (!empty($artist->banner_image) && Storage::disk('public')->exists('BannerImage/' . $artist->banner_image))
                                    
                                        <img style="height: 82px; width: 82px;"
                                            src="{{ asset('storage/BannerImage/' . $artist->banner_image) }}"
                                            alt="">
                                    @else
                                        <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="form-group">

                                </div>
                            </div>
                        </div>



                        <div class="row" id="profileHours">

                            <div class="col-md-1">
                                <label>Sunday Time</label>
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="sunday_from"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->sunday_from)) }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="sunday_to"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->sunday_to)) }}"
                                    class="form-control">

                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" name="sunday_close" id="check1"
                                    {{ @$artist->timeData->sunday_from == '00:00' && @$artist->timeData->sunday_to == '00:00' ? 'checked' : '' }}>
                                <label class="form-check-label">Close</label>
                            </div>


                            <div class="col-md-1">
                                <label>Monday Time</label>
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="monday_from"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->monday_from)) }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="monday_to"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->monday_to)) }}"
                                    class="form-control">

                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" name="monday_close" id="check2"
                                    {{ @$artist->timeData->monday_from == '00:00' && @$artist->timeData->monday_to == '00:00' ? 'checked' : '' }}>
                                <label class="form-check-label">Close</label>

                            </div>

                            <div class="col-md-1">
                                <label>Tuesday Time</label>
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="tuesday_from"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->tuesday_from)) }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="tuesday_to"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->tuesday_to)) }}"
                                    class="form-control">

                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" name="tuesday_close" id="check3"
                                    {{ @$artist->timeData->tuesday_from == '00:00' && @$artist->timeData->tuesday_to == '00:00' ? 'checked' : '' }}>
                                <label class="form-check-label">Close</label>

                            </div>
                            <div class="col-md-1">
                                <label>Wednesday Time</label>
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="wednesday_from"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->wednesday_from)) }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="wednesday_to"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->wednesday_to)) }}"
                                    class="form-control">

                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" name="wednesday_close" id="check5"
                                    {{ @$artist->timeData->wednesday_from == '00:00' && @$artist->timeData->wednesday_to == '00:00' ? 'checked' : '' }}>
                                <label class="form-check-label">Close</label>

                            </div>

                            <div class="col-md-1">
                                <label>Thursday Time</label>
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="thrusday_from"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->thrusday_from)) }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="thrusday_to"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->thrusday_to)) }}"
                                    class="form-control">

                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" name="thrusday_close" id="check6"
                                    {{ @$artist->timeData->thrusday_from == '00:00' && @$artist->timeData->thrusday_to == '00:00' ? 'checked' : '' }}>
                                <label class="form-check-label">Close</label>

                            </div>

                            <div class="col-md-1">
                                <label>Friday Time</label>
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="friday_from"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->friday_from)) }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="friday_to"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->friday_to)) }}"
                                    class="form-control">

                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" name="friday_close" id="check7"
                                    {{ @$artist->timeData->friday_from == '00:00' && @$artist->timeData->friday_to == '00:00' ? 'checked' : '' }}>
                                <label class="form-check-label">Close</label>

                            </div>

                            <div class="col-md-1">
                                <label>Saturday Time</label>
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="saterday_from"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->saterday_from)) }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <input type="time" name="saterday_to"
                                    value="{{ date('H:i', strtotime(@$artist->timeData->saterday_to)) }}"
                                    class="form-control">

                            </div>
                            <div class="col-md-1">
                                <input type="checkbox" name="saterday_close" id="check8"
                                    {{ @$artist->timeData->saterday_from == '00:00' && @$artist->timeData->saterday_to == '00:00' ? 'checked' : '' }}>
                                <label class="form-check-label">Close</label>

                            </div>

                        </div>
                        <button type="button" id="submitProfileUpdate" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <!-- Include Inputmask from CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAE6dk-Oc544R2gZpwVqPQDhN0VGAjkxhw&loading=async&libraries=places&callback=initAutocomplete">
        </script>

<script>
    // Function to initialize the autocomplete
    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to the US
        var input = $('#autocomplete')[0];
        var options = {
            types: ['address'],
            componentRestrictions: {
                country: 'us'
            }
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
            var streetNumber = '';
            var route = '';  // To store the street name
            

            // Loop through each component to find country, state, city, zip code, and route
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
                } else if (componentType === 'street_number') {
                    streetNumber = component.long_name; // Get street number
                } else if (componentType === 'route') {
                    route = component.long_name; // Get route name
                }
            });

            // Combine street number and route
            if (streetNumber && route) {
                route = streetNumber + ' ' + route;
            }

            // Extract latitude and longitude
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();

            // Fill in the form fields with the extracted values
            if (country.length > 0) {
                $("#country").val(country);
            }

            if (state.length > 0) {
                $("#state").val(state);
            }

            if (city.length > 0) {
                $("#city").val(city);
            }

            if (zipCode.length > 0) {
                $("#zipcode").val(zipCode);
            }

            $("#latitude").val(latitude);
            $("#longitude").val(longitude);
            
            // Set only the route name as the shop address
            $("#shop_address").val(route);

            // Display the extracted address components
            console.log('Country:', country);
            console.log('State:', state);
            console.log('City:', city);
            console.log('Zip Code:', zipCode);
            console.log('Route (Shop Address):', route);
            console.log('Latitude:', latitude);
            console.log('Longitude:', longitude);
        });
    }

    $(document).ready(function() {
        // Phone number input mask
        $('#phone').inputmask('(999) 999-9999');

        // Submit button functionality
        $("#submitProfileUpdate").on("click", function() {
            $("#phone").inputmask({
                removeMaskOnSubmit: true
            });
            $("#artistProfileUpdate").submit();
        });

        // Update shop address when the input changes
        $("#autocomplete").on("change", function() {
            $("#shop_address").val($(this).val());
        });

        // Limit input for hourly rate
        $("#hourly_rate").on("input", function() {
            var value = $(this).val();
            if (value.length > 3) {
                $(this).val(value.slice(0, 3));
            }
        });

        // Limit input for years in trade
        $("#years_in_trade").on("input", function() {
            var value = $(this).val();
            if (value.length > 2) {
                $(this).val(value.slice(0, 2));
            }
        });
    });
</script>

    @endsection
