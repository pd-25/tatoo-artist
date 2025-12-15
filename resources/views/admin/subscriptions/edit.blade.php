@extends('admin.layout.main')

@section('title', env('APP_NAME') . ' | Edit Subscription')

<head>

    <style>
        /* Chrome, Edge, Safari */
        #ach_routing_number::-webkit-inner-spin-button,
        #ach_routing_number::-webkit-outer-spin-button {
            -webkit-appearance: none !important;
            margin: 0;
        }

        /* Firefox */
        #ach_routing_number {
            -moz-appearance: textfield !important;
        }
    </style>

    <!-- Add flatpickr CSS in your <head> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Add flatpickr JS before closing </body> -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card">
            <div class="card-title text-center">
                <h4>Edit Subscription</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('subscriptions.update', $subscription->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Hidden user_id -->
                    <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ $userId }}" required>

                    <!-- Subscription Plan -->
                    <div class="form-group mb-3">
                        <label for="subscription_plan">Subscription Plan</label>
                        <select id="subscription_plan" name="subscription_plan" class="form-control" required>
                            <option value="">Select Status</option>
                            @foreach ($plans as $plan)
                            <option
                                value="{{ $plan['price'] }}|{{ $plan['name'] }}|{{ $plan['id'] }}"
                                @selected($subscription->subscription_plan == $plan['price'])>
                                {{ $plan['name'] }} - ${{ $plan['price'] }}
                            </option>
                            @endforeach
                        </select>

                        <!-- <select id="subscription_plan" name="subscription_plan" class="form-control" required>
                            <option value="">Select Status</option>
                            @foreach ($plans as $plan)
                            <option value="{{ $plan['price'] }}|{{ $plan['name'] }}" @selected($subscription->subscription_plan == $plan['price'])>
                                {{ $plan['name'] }} - ${{ $plan['price'] }}
                            </option>
                            @endforeach
                       </select> -->
                    </div>

                    <!-- Password Unlock for Subscription Date -->
                    <div class="form-group mb-3">
                        <div id="password-section">
                            <label for="password">Enter Password (use for sales person)</label>
                            <div class="d-flex gap-2">
                                <div style="width: 90%;">
                                    <input type="password" id="password" class="form-control" placeholder="Password">
                                </div>
                                <div onclick="unlockDateField()" class="btn-primary" style="width: 10%; text-align: center; padding: 10px; border-radius: 5px; margin-left: 10px;">
                                    Unlock
                                </div>
                            </div>
                            <p id="error-message" style="color: red; display: none;">Incorrect password!</p>
                        </div>
                    </div>

                    <!-- Subscription Date Field -->
                    <div id="form-container">
                        <!-- Hidden field for subscription_date so it's always sent -->
                        <input type="hidden" name="subscription_date" value="{{ old('subscription_date', $subscription->subscription_date) }}" id="subscription_date_hidden">
                    </div>

                    <script>
                        function unlockDateField() {
                            const passwordInput = document.getElementById('password').value;
                            const correctPassword = '12345';
                            const errorMessage = document.getElementById('error-message');
                            const formContainer = document.getElementById('form-container');

                            if (passwordInput === correctPassword) {
                                errorMessage.style.display = 'none';

                                const existingDate = "{{ old('subscription_date', $subscription->subscription_date ? \Carbon\Carbon::parse($subscription->subscription_date)->format('m-d-Y') : '') }}";

                                formContainer.innerHTML = `
            <div class="datepicker">
                <label for="date">Select Subscription Date</label>
                <input type="text" name="subscription_date" class="form-control" id="date" placeholder="mm-dd-yyyy" value="${existingDate}">
            </div>
        `;

                                document.getElementById('password-section').style.display = 'none';

                                // Initialize flatpickr
                                flatpickr("#date", {
                                    dateFormat: "m-d-Y",
                                    allowInput: false
                                });

                            } else {
                                errorMessage.style.display = 'block';
                            }
                        }
                    </script>

                    <!-- Status -->
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Renew" @selected($subscription->status == 'Renew')>Renew</option>
                            <option value="Cancel" @selected($subscription->status == 'Cancel')>Cancel</option>
                        </select>
                    </div>

                    <!--  -->

                    <div class="form-group mb-3">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" value="{{auth()->guard('artists')->user()->name}}" placeholder="Enter Full Name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="acc_hold_type">Account Holder Type</label>
                        <select name="acc_hold_type" id="acc_hold_type" class="form-control">
                            <option value="Personal" @selected($subscription->acc_hold_type == 'Personal')>Personal</option>
                            <option value="Business" @selected($subscription->acc_hold_type == 'Business')>Business</option>
                        </select>
                    </div>


                    <!-- Payment Option -->
                    <div class="form-group mb-3" style="display: none;">
                        <label for="payment_option">Payment Option</label>
                        <input type="text" id="payment_option" name="payment_option" class="form-control" value="ach" style="text-transform: uppercase;">
                    </div>

                    <!-- Zelle Fields -->
                    <div id="zelle_fields" class="{{ $subscription->payment_option == 'zelle' ? '' : 'd-none' }}">
                        <div class="form-group mb-3">
                            <label for="zell_email">Zelle Email</label>
                            <input type="email" id="zell_email" name="zell_email" class="form-control" value="{{ old('zell_email', $subscription->zell_email) }}" placeholder="Enter Zelle Email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="zell_phone">Zelle Phone</label>
                            <input type="text" id="zell_phone" name="zell_phone" class="form-control" value="{{ old('zell_phone', $subscription->zell_phone) }}" placeholder="Enter Zelle Phone">
                        </div>
                    </div>

                    <!-- ACH Fields -->
                    <div id="ach_fields" class="{{ $subscription->payment_option == 'ach' ? '' : 'd-none' }}">
                        <div class="form-group mb-3">
                            <label for="ach_bank_name">ACH Bank Name</label>
                            <input type="text" id="ach_bank_name" name="ach_bank_name" class="form-control" value="{{ old('ach_bank_name', $subscription->ach_bank_name) }}" placeholder="Enter Bank Name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="ach_type">ACH Type</label>
                            <select id="ach_type" name="ach_type" class="form-control">
                                <option value="">Select Status</option>
                                <option value="Checking" @selected($subscription->ach_type == 'Checking')>Checking</option>
                                <option value="Savings" @selected($subscription->ach_type == 'Savings')>Savings</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ach_routing_number">ACH Routing Number</label>
                            <input type="number" id="ach_routing_number" name="ach_routing_number" class="form-control" value="{{ old('ach_routing_number', $subscription->ach_routing_number) }}" placeholder="Enter Routing Number" maxlength="9" oninput="validateLengthRouting(this)">
                        </div>
                        <div class="form-group mb-3">
                            <label for="ach_account_number">ACH Account Number</label>
                            <input type="number" id="ach_account_number" name="ach_account_number" class="form-control" value="{{ old('ach_account_number', $subscription->ach_account_number) }}" placeholder="Enter Account Number" minlength="8" maxlength="18" oninput="validateLengthforacount(this)">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="ref_info">Reference Information</label>
                        <input type="text" id="ref_info" name="ref_info" class="form-control" value="TattooMe Subscription" placeholder="Enter Reference Information" readonly>
                    </div>

                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary">Update Subscription</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentOption = document.getElementById('payment_option');
        const zelleFields = document.getElementById('zelle_fields');
        const achFields = document.getElementById('ach_fields');

        function togglePaymentFields() {
            const value = paymentOption.value;
            if (value === 'zelle') {
                zelleFields.classList.remove('d-none');
                achFields.classList.add('d-none');
            } else if (value === 'ach') {
                achFields.classList.remove('d-none');
                zelleFields.classList.add('d-none');
            } else {
                zelleFields.classList.add('d-none');
                achFields.classList.add('d-none');
            }
        }

        paymentOption.addEventListener('change', togglePaymentFields);
        togglePaymentFields(); // Initialize on load
    });

    // Zelle Phone formatting
    document.addEventListener('DOMContentLoaded', () => {
        const phoneInput = document.querySelector('#zell_phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, "").substring(0, 10);
                if (value.length > 6) value = `(${value.substring(0,3)}) ${value.substring(3,6)}-${value.substring(6)}`;
                else if (value.length > 3) value = `(${value.substring(0,3)}) ${value.substring(3)}`;
                else if (value.length > 0) value = `(${value}`;
                this.value = value;
            });
        }
    });

    function validateLengthforacount(input) {
        const value = input.value;
        if (value.length < 8 || value.length > 18) input.setCustomValidity("Account number must be between 8 and 18 digits.");
        else input.setCustomValidity("");
    }

    function validateLengthRouting(input) {
        const value = input.value;
        if (value.length !== 9) input.setCustomValidity("Routing number must be exactly 9 digits.");
        else input.setCustomValidity("");
    }
</script>

<script>
    function validateLengthRouting(input) {
        // Remove non-numeric characters
        input.value = input.value.replace(/[^0-9]/g, '');

        // Limit to 9 digits
        if (input.value.length > 9) {
            input.value = input.value.slice(0, 9);
        }
    }
</script>
@endsection