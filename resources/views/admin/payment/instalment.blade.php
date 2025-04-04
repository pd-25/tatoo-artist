@extends('admin.layout.main')
@section('title', 'Installment View')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-title">
                
                @if (session('message'))
                <div class="alert alert-info">{{ session('message') }}</div>

                @endif
            </div>

            <div class="card-body">
                <h5 class="mb-3">Customer Name : {{ $payment->customers_name }}</h5>

                {{-- Summary Info --}}
                <div class="row">
                    <div class="col-md-6">
                        <label>Total Price</label>
                        <input type="number" class="form-control" value="{{ $payment->price }}" readonly>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Total Deposit</label>
                        <input type="number" class="form-control" value="{{ $payment->deposit_total }}" name="deposit_total" readonly>
                    </div>
                   
                    <div class="col-md-6 mt-2">
                        <label>Fees</label>
                        <input type="number" class="form-control" value="{{ $payment->fees }}" readonly>
                    </div>
                    
                    <div class="col-md-6 mt-2">
                        <label>Shop Percentage (3%)</label>
                        <input type="number" class="form-control" value="{{ $payment->shop_percentage }}" readonly>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Artist Percentage (2%)</label>
                        <input type="number" class="form-control" value="{{ $payment->artist_percentage }}" readonly>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Total Due</label>
                        <input type="number" class="form-control" value="{{ $payment->total_due }}" readonly>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Design</label>
                        <input type="text" class="form-control" value="{{ $payment->design }}" readonly>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Placement</label>
                        <input type="text" class="form-control" value="{{ $placement->title ?? 'N/A' }}" readonly>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Add New Installment --}}
                @if($payment->deposit_total < $payment->price)
                    <h5>Add New Installment</h5>
                    <form action="{{ route('admin.addInstallment') }}" method="POST" id="installment-form">
                        @csrf
                        <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                        <input type="hidden" id="current-deposit" value="{{ $payment->deposit_total }}">
                        <input type="hidden" id="total-price" value="{{ $payment->price }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Amount</label>
                                <input type="number" name="amount" id="installment-amount" step="0.01" class="form-control" required>
                                <small id="amount-error" class="text-danger d-none">Amount exceeds total price.</small>
                            </div>
                            <div class="col-md-4">
                                <label>Method</label>
                                <select  name="method" id="payment-method" class="form-control" required>
                                    <option value="">Select Payment Method</option>
                                </select>
                                @error('payment_method') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4" style="margin-top: 29px;">
                                <button type="submit" class="btn btn-primary w-100" id="submit-installment">Add Installment</button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info mt-3">
                        All payments completed. No more installments can be added.
                    </div>
                @endif

                {{-- Installment Log --}}
                <hr class="my-4">
                <h5>Installment History</h5>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $logs = json_decode($payment->deposit_log, true); @endphp
                        @if ($logs && count($logs) > 0)
                            @foreach ($logs as $index => $log)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($log['date'])->format('d M Y, h:i A') }}</td>
                                    <td>{{ $log['amount'] }}</td>
                                    <td>{{ $log['method'] }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">No installments yet.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <a href="{{ route('admin.deposit-slips') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

{{-- JS to Validate Installment Amount --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const amountInput = document.getElementById('installment-amount');
        const currentDeposit = parseFloat(document.getElementById('current-deposit')?.value || 0);
        const totalPrice = parseFloat(document.getElementById('total-price')?.value || 0);
        const errorText = document.getElementById('amount-error');
        const submitBtn = document.getElementById('submit-installment');

        if (amountInput) {
            amountInput.addEventListener('input', function () {
                const newAmount = parseFloat(this.value || 0);
                if ((currentDeposit + newAmount) > totalPrice) {
                    errorText.classList.remove('d-none');
                    submitBtn.disabled = true;
                } else {
                    errorText.classList.add('d-none');
                    submitBtn.disabled = false;
                }
            });
        }

        var artistId = {{ $payment->artist_id ?? 'null' }};
        if (artistId) {
            fetchPaymentMethods(artistId);
        }

        $('#artist-select').change(function() {
            var selectedArtistId = $(this).val();
            if (selectedArtistId) {
                fetchPaymentMethods(selectedArtistId);
            } else {
                $('#payment-method').html('<option value="">Select Payment Method</option>');
            }
        });

        function fetchPaymentMethods(artistId) {
            $.ajax({
                url: '{{ route("admin.getPaymentMethods") }}',
                type: 'GET',
                data: { artist_id: artistId },
                success: function(data) {
                    let options = '<option value="">Select Payment Method</option>';
                    data.forEach(function(method) {
                        let value = method.toLowerCase().replace(/ /g, '_');
                        options += `<option value="${value}">${method}</option>`;
                    });
                    $('#payment-method').html(options);
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }
    });
</script>
@endsection
