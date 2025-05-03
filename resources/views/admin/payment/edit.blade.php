@extends('admin.layout.main')
@section('title', env('APP_NAME') . ' | Edit Payment')
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
                    <form action="{{ route('admin.editpaymentPost', $payments->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- Left Column --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artist Name <span class="text-danger">*</span></label>
                                    @if (Auth::guard('artists')->check())
                                        <input type="text" class="form-control" value="{{ Auth::guard('artists')->user()->name }}" readonly>
                                        <input type="hidden" name="artist_id" value="{{ Auth::guard('artists')->user()->id }}">
                                        <input type="hidden" id="artist-id" value="{{ Auth::guard('artists')->user()->id }}">
                                    @else
                                        <select name="artist_id" id="artist-select" class="form-control" required>
                                            <option value="">Select artist</option>
                                            @foreach ($artists as $artist)
                                                <option {{ old('artist_id', $payments->artist_id) == $artist->id ? 'selected' : '' }} value="{{ $artist->id }}">{{ $artist->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('artist_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Design <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="design" placeholder="Design" value="{{ old('design', $payments->design) }}" required>
                                    @error('design') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="Price" value="{{ old('price', $payments->price) }}" required>
                                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Shop Percentage</label>
                                    <input type="text" class="form-control" id="shop_percentage" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Artist Percentage</label>
                                    <input type="text" class="form-control" id="artist_percentage" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Fees</label>
                                    <input type="text" class="form-control" name="fees" placeholder="Fees" value="{{ old('fees', $payments->fees) }} " readonly>
                                    @error('fees') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                              
                            </div>

                            {{-- Right Column --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Customers Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="customers_name" placeholder="Customer Name" value="{{ old('customers_name', $payments->customers_name) }}" required>
                                    @error('customers_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Placement</label>
                                    <select name="placement" class="form-control">
                                        <option value="">Select placement</option>
                                        @foreach ($placements as $placement)
                                            <option {{ old('placement', $payments->placement) == $placement->id ? 'selected' : '' }} value="{{ $placement->id }}">{{ $placement->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('placement') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                

                                {{-- <div class="form-group">
                                    <label>Pay Type <span class="text-danger">*</span></label>
                                    <select name="payment_method" id="payment-method" class="form-control" required>
                                        <option value="">Select Pay Type</option>
                                    </select>
                                    @error('payment_method') <span class="text-danger">{{ $message }}</span> @enderror
                                </div> --}}

                                <div class="form-group">
                                    <label>Deposit Total</label>
                                    <input type="number" class="form-control" name="deposit_total" id="deposit_total" placeholder="Deposit Total" value="{{ old('deposit_total', $payments->deposit_total) }}">
                                    <small id="total-error" class="text-danger d-none">Total deposit cannot exceed price.</small>
                                    @error('deposit_total') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Tips</label>
                                    <input type="number" class="form-control" name="tips" placeholder="Tips" value="{{ old('tips', $payments->tips) }}">
                                    @error('tips') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label>Deposit Slip</label>
                                    <input type="file" class="form-control" name="bill_image">
                                    <small>Leave blank to keep existing image.</small><br>
                                    @if (!empty($payments->bill_image))
                                        <img style="height: 82px; width: 82px;" src="{{ asset($payments->bill_image) }}" alt="">
                                    @else
                                        <img style="height: 82px; width: 82px;" src="{{ asset('noimg.png') }}" alt="">
                                    @endif
                                    @error('bill_image') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notes(optional)</label>
                                    <input type="text" class="form-control" name="notes" value="{{ old('notes', $payments->notes) }}">
                                    @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-default mt-3">Update</button>
                        <a href="{{ route('admin.paymentview', encrypt($payments->id)) }}" class="btn btn-primary mt-3">Print</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let depositEdited = false;
    let shopPercentage = 0;

    $(document).ready(function() {
        const artistId = $('#artist-id').val() || $('#artist-select').val();
        if (artistId) fetchPaymentMethods(artistId);

        $('#artist-select').change(function() {
            const selectedArtistId = $(this).val();
            if (selectedArtistId) {
                fetchPaymentMethods(selectedArtistId);
            } else {
                $('#payment-method').html('<option value="">Select Pay Type</option>');
            }
        });

        function fetchPaymentMethods(artistId) {
            $.ajax({
                url: '{{ route("admin.getPaymentMethods") }}',
                type: 'GET',
                data: { artist_id: artistId },
                success: function(data) {
                    let options = '<option value="">Select Pay Type</option>';
                    
                    if (data.paymentMethods && Array.isArray(data.paymentMethods)) {
                        data.paymentMethods.forEach(function(method) {
                            let value = method.toLowerCase().replace(/ /g, '_');
                            let selected = '{{ $payments->payment_method }}' === value ? 'selected' : '';
                            options += `<option value="${value}" ${selected}>${method}</option>`;
                        });
                    }

                    $('#payment-method').html(options);

                    // Store shop percentage from API
                    shopPercentage = parseFloat(data.shop_percentage) || 0;
                    updatePercentages(parseFloat($('#deposit_total').val()) || 0);
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        function updatePercentages(val) {
            const artistPercentage = 100 - shopPercentage;
            const shopAmount = (val * shopPercentage / 100).toFixed(2);
            const artistAmount = (val * artistPercentage / 100).toFixed(2);
            
            $('#shop_percentage').val(shopAmount);
            $('#artist_percentage').val(artistAmount);
        }

        function validateAmounts() {
            const price = parseFloat($('#price').val()) || 0;
            const total = parseFloat($('#deposit_total').val()) || 0;

            $('#total-error').toggleClass('d-none', total <= price);

            if (total > price) $('#deposit_total').val(price);
        }

        $('#deposit_total').on('input', function () {
            depositEdited = true;
            const total = parseFloat($(this).val()) || 0;
            updatePercentages(total);
            validateAmounts();
        });

        $('#price').on('input', function () {
            validateAmounts();
        });

        // Initialize percentages
        const initialTotal = parseFloat($('#deposit_total').val()) || 0;
        updatePercentages(initialTsotal);
    });
</script>
@endsection