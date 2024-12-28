@extends('admin.layout.main')

@section('title', env('APP_NAME') . ' | Edit Subscription')

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

                    <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ $userId }}"
                        required>

                    <div class="form-group mb-3">
                        <label for="subscription_plan">Subscription Plan</label>
                        <select id="subscription_plan" name="subscription_plan" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Starter Plan - $50" @selected($subscription->subscription_plan == 'Starter Plan - $50')>Starter Plan - $50</option>
                            <option value="Professional Plan - $100"
                                @selected($subscription->subscription_plan == 'Professional Plan - $100')>Professional
                                Plan - $100</option>
                            <option value="Elite Plan - $300" @selected($subscription->subscription_plan == 'Elite Plan - $300')>Elite Plan - $300</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <div id="password-section">
                            <label for="password">Enter Password (use for sales person)</label>

                            <div class="d-flex gap-2">
                                <div class="" style="width: 90%;">
                                    <input type="password" id="password" class="form-control" placeholder="Password">
                                </div>
                                <div onclick="unlockDateField()" class="btn-primary" style="width: 10%; text-align: center; padding: 10px; border-radius: 5px; margin-left: 10px;">
                                  Unlock
                                </div>

                            </div>
                            <p id="error-message" style="color: red; display: none;">Incorrect password!</p>

                        </div>
                    </div>
                    <div id="form-container"></div>

                    <script>
                        function unlockDateField() {
                            const passwordInput = document.getElementById('password').value;
                            const correctPassword = '12345'; // Set your desired password here
                            const errorMessage = document.getElementById('error-message');
                            const formContainer = document.getElementById('form-container');

                            if (passwordInput === correctPassword) {
                                errorMessage.style.display = 'none';

                                // Add date field dynamically
                                formContainer.innerHTML = `
                    <div class="datepicker">
                        <label for="date">Select Subscription Date</label>
                        <input type="date" name="subscription_date" class="form-control" id="date" value="{{ old('subscription_date', $subscription->subscription_date) }}">
                    </div>
                `;

                                // Optionally, clear the password input and hide the password section
                                document.getElementById('password-section').style.display = 'none';
                            } else {
                                errorMessage.style.display = 'block';
                            }
                        }
                    </script>

                    <script>
                        $(function () {
                            $('#datetimepicker1').datetimepicker();
                        });

                        $('.datepicker').datetimepicker({
                            "allowInputToggle": true,
                            "showClose": true,
                            "showClear": true,
                            "showTodayButton": true,
                            "format": "DD/MM/YYYY",
                        });
                    </script>

                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Renew" @selected($subscription->status == 'Renew')>Renew</option>
                            <option value="Cancel" @selected($subscription->status == 'Cancel')>Cancel</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="payment_option">Payment Option</label>
                        <select id="payment_option" name="payment_option" class="form-control" required>
                            <option value="">Select Payment Option</option>
                            <option value="zelle" @selected($subscription->payment_option == 'zelle')>Zelle</option>
                            <option value="ach" @selected($subscription->payment_option == 'ach')>ACH</option>
                        </select>
                    </div>

                    <!-- Zelle Fields -->
                    <div id="zelle_fields" class="d-none">
                        <div class="form-group mb-3">
                            <label for="zell_email">Zelle Email</label>
                            <input type="email" id="zell_email" name="zell_email" class="form-control"
                                value="{{ old('zell_email', $subscription->zell_email) }}"
                                placeholder="Enter Zelle Email">
                        </div>

                        <div class="form-group mb-3">
                            <label for="zell_phone">Zelle Phone</label>
                            <input type="text" id="zell_phone" name="zell_phone" class="form-control"
                                value="{{ old('zell_phone', $subscription->zell_phone) }}"
                                placeholder="Enter Zelle Phone">
                        </div>
                    </div>

                    <!-- ACH Fields -->
                    <div id="ach_fields" class="d-none">
                        <div class="form-group mb-3">
                            <label for="ach_bank_name">ACH Bank Name</label>
                            <input type="text" id="ach_bank_name" name="ach_bank_name" class="form-control"
                                value="{{ old('ach_bank_name', $subscription->ach_bank_name) }}"
                                placeholder="Enter Bank Name">
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_type">ACH Type</label>
                            <select id="ach_type" name="ach_type" class="form-control">
                                <option value="">Select Status</option>
                                <option value="Checking" @selected($subscription->ach_type == 'Checking')>Checking
                                </option>
                                <option value="Savings" @selected($subscription->ach_type == 'Savings')>Savings</option>

                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_routing_number">ACH Routing Number</label>
                            <input type="number" id="ach_routing_number" name="ach_routing_number" class="form-control"
                                value="{{ old('ach_routing_number', $subscription->ach_routing_number) }}"
                                placeholder="Enter Routing Number" maxlength="9"
                                oninput="validateLengthRouting(this)"
                                
                                >
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_account_number">ACH Account Number</label>
                            <input type="number" id="ach_account_number" name="ach_account_number" class="form-control"
                                value="{{ old('ach_account_number', $subscription->ach_account_number) }}"
                                placeholder="Enter Account Number" minlength="8" maxlength="18" oninput="validateLengthforacount(this)">
                        </div>
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
    // Dynamically show/hide payment fields
    document.addEventListener('DOMContentLoaded', function () {
        const paymentOption = document.getElementById('payment_option');
        const zelleFields = document.getElementById('zelle_fields');
        const achFields = document.getElementById('ach_fields');

        paymentOption.addEventListener('change', function () {
            const value = paymentOption.value;

            // Show/hide fields based on selected payment option
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
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        // Select the input by class or ID
        const phoneInput = document.querySelector('#zell_phone');

        if (phoneInput) {
            phoneInput.addEventListener('input', function () {
                formatPhone(this);
            });
        }
    });

    function formatPhone(input) {
        // Remove all non-digit characters
        let value = input.value.replace(/\D/g, "");

        // Limit the input to 10 digits
        value = value.substring(0, 10);

        // Format the value as (999) 999-9999
        if (value.length > 6) {
            value = `(${value.substring(0, 3)}) ${value.substring(3, 6)}-${value.substring(6)}`;
        } else if (value.length > 3) {
            value = `(${value.substring(0, 3)}) ${value.substring(3)}`;
        } else if (value.length > 0) {
            value = `(${value}`;
        }

        // Update the input value
        input.value = value;
    }
</script>

<script>
    function validateLengthforacount(input) {
        const value = input.value;
        if (value.length < 8 || value.length > 18) {
            input.setCustomValidity("Account number must be between 8 and 18 digits.");
        } else {
            input.setCustomValidity("");
        }
    }
    function validateLengthRouting(input) {
    const value = input.value;
    if (value.length !== 9) {
        input.setCustomValidity("Routing number must be exactly 9 digits.");
    } else {
        input.setCustomValidity(""); // Clears any previous error message
    }

    }
</script>
@endsection