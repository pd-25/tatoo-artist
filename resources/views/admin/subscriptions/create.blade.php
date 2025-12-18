@extends('admin.layout.main')

@section('title', env('APP_NAME').' | Create Subscription')
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
@section('content')
<div class="row justify-content-center">

    <div class="col-lg-11">
        <div class="card">
            <div class="card-title text-center">
                <h4>Create Subscription</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('subscriptions.store') }}" method="POST">
                    @csrf

                    <input type="hidden" id="user_id" name="user_id" class="form-control" placeholder="Enter User ID" value="{{ $userId}}" required>


                    <div class="form-group mb-3">
                        <label for="subscription_plan">Subscription Plan<span class="text-danger">*</span></label>
                        <select id="subscription_plan" name="subscription_plan" class="form-control" required>
                            <option value="">Select Status</option>
                            @foreach ($plans as $index => $plan)
                            <div class="border p-3 mb-3">
                                <option value="{{ $plan['price'] }}|{{ $plan['name'] }}" @selected((string) $subscriptionPlan==(string) $plan['price'])>
                                    {{ $plan['name'] }} - {{ $plan['price'] }}
                                </option>



                                <!-- <input type="text" name="plans[{{ $index }}][name]" value="{{ $plan['name'] }}" placeholder="Plan Name" class="form-control mb-2"> -->
                                <!-- <input type="number" name="plans[{{ $index }}][price]" value="{{ $plan['price'] }}" placeholder="Price" class="form-control"> -->
                            </div>
                            @endforeach
                            <!-- <option value="50" @selected($subscriptionPlan=='Starter Plan - $50' )>Starter Plan - $50</option>
                            <option value="100" @selected($subscriptionPlan=='Professional Plan - $100' )>Professional Plan - $100</option>
                            <option value="300" @selected($subscriptionPlan=='Elite Plan - $300' )>Elite Plan - $300</option> -->
                        </select>

                    </div>
                    <div class="form-group mb-3">
                        <div id="password-section">
                            <label for="password">Enter Password (use for sales person)<span class="text-danger">*</span></label>

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
        <input type="text" name="subscription_date" class="form-control" id="date" placeholder="mm-dd-yyyy">
    </div>
`;

                                // Add event listeners after inserting the input
                                const dateInput = document.getElementById('date');

                                dateInput.addEventListener('focus', function() {
                                    this.type = 'date';
                                });

                                dateInput.addEventListener('blur', function() {
                                    if (this.value) {
                                        const date = new Date(this.value);
                                        const mm = String(date.getMonth() + 1).padStart(2, '0');
                                        const dd = String(date.getDate()).padStart(2, '0');
                                        const yyyy = date.getFullYear();
                                        this.type = 'text';
                                        this.value = `${mm}-${dd}-${yyyy}`;
                                    } else {
                                        this.type = 'text';
                                    }
                                });

                                // Optionally, clear the password input and hide the password section
                                document.getElementById('password-section').style.display = 'none';
                            } else {
                                errorMessage.style.display = 'block';
                            }
                        }
                    </script>

                    <script>
                        $(function() {
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
                        <label for="status">Status<span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Renew">Renew</option>
                            <option value="Cancel">Cancel</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="full_name">Full Name<span class="text-danger">*</span></label>
                        <input type="text" id="full_name" name="full_name" class="form-control" value="{{auth()->guard('artists')->user()->name}}" placeholder="Enter Full Name">
                    </div>

                    <div class="form-group mb-3">
                        <label for="acc_hold_type">Account Holder Type<span class="text-danger">*</span></label>
                        <select name="acc_hold_type" id="acc_hold_type" class="form-control">
                            <option value="Personal" selected>Personal</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>

                    <div class="form-group mb-3" style="display: none;">
                        <label for="payment_option">Payment Option</label>
                        <select id="payment_option" name="payment_option" class="form-control" required>
                            <option value="">Select Payment Option</option>
                            <option value="zelle">Zelle</option>
                            <option value="ach" selected>ACH</option>
                        </select>
                    </div>

                    <!-- Zelle Fields -->
                    <div id="zelle_fields" class="d-none">
                        <div class="form-group mb-3">
                            <label for="zell_email">Zelle Email</label>
                            <input type="email" id="zell_email" name="zell_email" class="form-control" placeholder="Enter Zelle Email">
                        </div>

                        <div class="form-group mb-3">
                            <label for="zell_phone">Zelle Phone</label>
                            <input type="text" id="zell_phone" name="zell_phone" class="form-control" placeholder="Enter Zelle Phone">
                        </div>
                    </div>

                    <!-- ACH Fields -->
                    <div id="ach_fields" class="d-none">
                        <div class="form-group mb-3">
                            <label for="ach_bank_name">ACH Bank Name<span class="text-danger">*</span></label>
                            <input type="text" id="ach_bank_name" name="ach_bank_name" class="form-control" placeholder="Enter Bank Name">
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_type">ACH Type<span class="text-danger">*</span></label>
                            <select id="ach_type" name="ach_type" class="form-control">
                                <option value="">Select Status</option>
                                <option value="Checking">Checking</option>
                                <option value="Savings">Savings</option>
                            </select>

                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_routing_number">ACH Routing Number<span class="text-danger">*</span></label>
                            <input type="number" id="ach_routing_number" name="ach_routing_number" class="form-control" placeholder="Enter Routing Number" maxlength="9" oninput="validateLengthRouting(this)">
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_account_number">ACH Account Number<span class="text-danger">*</span></label>
                            <input type="number" id="ach_account_number" name="ach_account_number" class="form-control" placeholder="Enter Account Number" minlength="8" maxlength="18" oninput="validateLengthforacount(this)">
                        </div>

                        <div class="form-group mb-3">
                            <label for="ref_info">Reference Information<span class="text-danger">*</span></label>
                            <input type="text" id="ref_info" name="ref_info" class="form-control" value="TattooMe Subscription" placeholder="Enter Reference Information" readonly>
                        </div>
                    </div>

                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary">Create Subscription</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    // Dynamically show/hide payment fields
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
    document.addEventListener('DOMContentLoaded', () => {
        // Select the input by class or ID
        const phoneInput = document.querySelector('#zell_phone');

        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
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