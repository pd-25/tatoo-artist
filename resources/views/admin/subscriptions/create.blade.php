@extends('admin.layout.main')

@section('title', env('APP_NAME').' | Create Subscription')

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
                        <label for="subscription_plan">Subscription Plan</label>
                        <select id="subscription_plan" name="subscription_plan" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Starter Plan - $50" @selected($subscriptionPlan == 'Starter Plan - $50')>Starter Plan - $50</option>
                            <option value="Professional Plan - $100" @selected($subscriptionPlan == 'Professional Plan - $100')>Professional Plan - $100</option>
                            <option value="Elite Plan - $300" @selected($subscriptionPlan == 'Elite Plan - $300')>Elite Plan - $300</option>
                        </select>
                        
                    </div>

                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Renew">Renew</option>
                            <option value="Cancel">Cancel</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="payment_option">Payment Option</label>
                        <select id="payment_option" name="payment_option" class="form-control" required>
                            <option value="">Select Payment Option</option>
                            <option value="zell">Zelle</option>
                            <option value="ach">ACH</option>
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
                            <label for="ach_bank_name">ACH Bank Name</label>
                            <input type="text" id="ach_bank_name" name="ach_bank_name" class="form-control" placeholder="Enter Bank Name">
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_type">ACH Type</label>
                            <select id="ach_type" name="ach_type" class="form-control" >
                                <option value="">Select Status</option>
                                <option value="Checking">Checking</option>
                                <option value="Savings" >Savings</option>
                            </select>
                           
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_routing_number">ACH Routing Number</label>
                            <input type="text" id="ach_routing_number" name="ach_routing_number" class="form-control" placeholder="Enter Routing Number">
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_account_number">ACH Account Number</label>
                            <input type="number" id="ach_account_number" name="ach_account_number" class="form-control" placeholder="Enter Account Number">
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
    document.addEventListener('DOMContentLoaded', function () {
        const paymentOption = document.getElementById('payment_option');
        const zelleFields = document.getElementById('zelle_fields');
        const achFields = document.getElementById('ach_fields');

        paymentOption.addEventListener('change', function () {
            const value = paymentOption.value;

            // Show/hide fields based on selected payment option
            if (value === 'zell') {
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

@endsection
