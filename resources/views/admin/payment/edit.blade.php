@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Edit Payment')
@section('content')
<style>
    </style>
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
                                        <label>Artist Name</label><span class="text-danger">*</span>
                                        @if (Auth::guard('artists')->check())
                                            <input type="text" class="form-control" value="{{ Auth::guard('artists')->user()->name }}" readonly>
                                            <input type="hidden" name="artist_id" id="artist-select" value="{{ Auth::guard('artists')->user()->id }}">
                                        @else
                                            <select name="artist_id" id="artist-select" class="form-control">
                                                <option value="">Select artist</option>
                                                @foreach ($artists as $artist)
                                                    <option {{ old('artist_id', $payments->artist_id) == $artist->id ? 'selected' : '' }}
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
                                        <input type="text" class="form-control" placeholder="Design" name="design" value="{{ old('design', $payments->design) }}" required>
                                        @error('design')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" class="form-control" placeholder="Price" name="price" value="{{ old('price', $payments->price) }}">
                                        @error('price')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Tips</label>
                                        <input type="number" class="form-control" placeholder="Tips" name="tips" value="{{ old('tips', $payments->tips) }}">
                                        @error('tips')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Total Due</label>
                                        <input type="number" class="form-control" placeholder="Total Due" name="total_due" value="{{ old('total_due', $payments->total_due) }}">
                                        @error('total_due')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Deposit Slip</label>
                                        <input type="file" class="form-control" name="bill_image">
                                        <small class="form-text text-muted">Leave blank if not updating.</small>
                                        @if (!empty($payments->bill_image))
                                                <img style="height: 82px; width: 82px;"
                                                    src="{{ asset($payments->bill_image) }}"
                                                    alt="">
                                            @else
                                                <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}"
                                                    alt="">
                                            @endif
                                        @error('bill_image')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customers Name</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" placeholder="Customers Name" name="customers_name" value="{{ old('customers_name', $payments->customers_name) }}" required>
                                        @error('customers_name')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Placement</label>
                                        <select name="placement" class="form-control">
                                            <option value="">Select Placement</option>
                                            @foreach ($placements as $placement)
                                                <option {{ old('placement', $payments->placement_id) == $placement->id ? 'selected' : '' }}
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
                                        <input type="number" class="form-control" placeholder="Deposit" name="deposit" value="{{ old('deposit', $payments->deposit) }}">
                                        @error('deposit')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Fees</label>
                                        <input type="number" class="form-control" placeholder="Fees" name="fees" value="{{ old('fees', $payments->fees) }}">
                                        @error('fees')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Payment Method</label>
                                        <select name="payment_method" id="payment-method" class="form-control">
                                            <option value="">Select Payment Method</option>
                                            @if($payments->payment_method)
                                                <option value="{{ $payments->payment_method }}" selected>
                                                    {{ ucwords(str_replace('_', ' ', $payments->payment_method)) }}
                                                </option>
                                            @endif
                                            <!-- The options will be populated via AJAX -->
                                        </select>
                                    
                                        @error('payment_method')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    
                                </div>
                            </div>

                            <button type="submit" class="btn btn-default">Update</button>
                            <a href="{{ route('admin.paymentview', encrypt($payments->id)) }}" type="button" class="btn btn-primary" >Print</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#artist-select').change(function() {
                    var artistId = $(this).val();
                    var paymentMethodSelect = $('#payment-method');
                    var oldPaymentMethod = paymentMethodSelect.val(); // Store the old selected value
        
                    // Clear current options except for the old selected value
                    paymentMethodSelect.empty();
                    paymentMethodSelect.append('<option value="">Select Payment Method</option>');
        
                    // Re-add the old payment method if it is still valid
                    if (oldPaymentMethod) {
                        paymentMethodSelect.append('<option value="' + oldPaymentMethod + '" selected>' + 
                            oldPaymentMethod.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) + 
                            '</option>');
                    }
        
                    if (artistId) {
                        $.ajax({
                            url: '{{ route("admin.getPaymentMethods") }}',
                            type: 'GET',
                            data: { artist_id: artistId },
                            success: function(data) {
                                if (data.length > 0) {
                                    $.each(data, function(index, method) {
                                        paymentMethodSelect.append('<option value="' + method.toLowerCase().replace(/ /g, '_') + '">' + method.charAt(0).toUpperCase() + method.slice(1) + '</option>');
                                    });
                                } else {
                                    paymentMethodSelect.append('<option value="">No Payment Methods Available</option>');
                                }
                            },
                            error: function(xhr) {
                                console.error(xhr);
                            }
                        });
                    }
                });
        
                // Trigger change event on page load to ensure the dropdown is correctly populated
                $('#artist-select').trigger('change');
            });
        </script>
        
    @endsection
