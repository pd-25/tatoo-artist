@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Category-edit')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-title">
                    <h4>Edit Payment</h4>
                    @if (Session::has('message'))
                        <p class="alert alert-info">{{ Session::get('message') }}</p>
                    @endif
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('admin.editpaymentPost', encrypt($payments->id)) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Artist</label><span class="text-danger">*</span>
                                        @if (Auth::guard('artists')->check())
                                            <input type="text" class="form-control" placeholder="Artist Name" name="artist_name" value="{{ $payments->artist->name }}" readonly>
                                            <input type="hidden" name="artist_id" value="{{ Auth::guard('artists')->user()->id; }}">
                                        @else
                                            <select name="artist_id" class="form-control" value="{{ old('artist_id') }}">
                                                <option value="">select artist</option>
                                                @foreach ($artists as $artist)
                                                    <option {{ $payments->artist_id == $artist->id ? 'selected' : '' }}
                                                        value="{{ $artist->id }}">{{ $artist->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif

                                        @error('artist_id')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>Design</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" placeholder="Design" name="design" value="{{ $payments->design }}" required>
                                        @error('design')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" class="form-control" placeholder="Price" name="price" value="{{ $payments->price }}">
                                        @error('price')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Tips</label>
                                        <input type="text" class="form-control" placeholder="Tips" name="tips" value="{{ $payments->tips }}">
                                        @error('tips')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Total Due</label>
                                        <input type="text" class="form-control" placeholder="Total Due" name="total_due" value="{{ $payments->total_due }}">
                                        @error('total_due')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Deposit Slip</label>
                                        <input type="file" class="form-control" name="bill_image">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" name="old_image_path" value="{{$payments->bill_image}}">
                                            @if (!empty($payments->bill_image))
                                                <img style="height: 82px; width: 82px;"
                                                    src="{{ asset($payments->bill_image) }}"
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

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Customers Name</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" placeholder="Customers Name" name="customers_name" value="{{ $payments->customers_name }}" required>
                                        @error('customers_name')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Placement</label>
                                        {{-- <input type="text" class="form-control" placeholder="Placement" name="placement" value="{{ $payments->placement }}"> --}}
                                        <select name="placement" class="form-control" value="{{ old('placement') }}">
                                            <option value="">select placement</option>
                                            @foreach ($placements as $placement)
                                                <option {{ $payments->placement == $placement->id ? 'selected' : '' }}
                                                    value="{{ $placement->id }}">{{ $placement->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('placement')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Deposit</label>
                                        <input type="text" class="form-control" placeholder="Deposit" name="deposit" value="{{ $payments->deposit }}">
                                        @error('deposit')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>



                                    <div class="form-group">
                                        <label>Fees</label>
                                        <input type="text" class="form-control" placeholder="Fees" name="fees" value="{{  $payments->fees  }}">
                                        @error('fees')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Total Due</label>
                                        <select name="payment_method" class="form-control">
                                            <option value="atm_debit" @if($payments->payment_method == 'atm_debit') selected @endif>Atm/Debit</option>
                                            <option value="cash" @if($payments->payment_method == 'cash') selected @endif>Cash</option>
                                            <option value="credit_card" @if($payments->payment_method == 'credit_card') selected @endif>Credit Card</option>
                                            <option value="gift_card" @if($payments->payment_method == 'gift_card') selected @endif>Gift Card</option>
                                        </select>
                                        @error('payment_method')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
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
