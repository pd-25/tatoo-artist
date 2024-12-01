@extends('admin.layout.main')

@section('title', env('APP_NAME').' | Edit Subscription')

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
                    
                    <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ $userId }}" required>

                    <div class="form-group mb-3">
                        <label for="subscription_plan">Subscription Plan</label>
                        <select id="subscription_plan" name="subscription_plan" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Starter Plan - $50" @selected($subscription->subscription_plan == 'Starter Plan - $50')>Starter Plan - $50</option>
                            <option value="Professional Plan - $100" @selected($subscription->subscription_plan == 'Professional Plan - $100')>Professional Plan - $100</option>
                            <option value="Elite Plan - $300" @selected($subscription->subscription_plan == 'Elite Plan - $300')>Elite Plan - $300</option>
                        </select>
                    </div>

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
                            <option value="zell" @selected($subscription->payment_option == 'zell')>Zelle</option>
                            <option value="ach" @selected($subscription->payment_option == 'ach')>ACH</option>
                        </select>
                    </div>

                    <!-- Zelle Fields -->
                    <div id="zelle_fields" class="d-none">
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
                    <div id="ach_fields" class="d-none">
                        <div class="form-group mb-3">
                            <label for="ach_bank_name">ACH Bank Name</label>
                            <input type="text" id="ach_bank_name" name="ach_bank_name" class="form-control" value="{{ old('ach_bank_name', $subscription->ach_bank_name) }}" placeholder="Enter Bank Name">
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_type">ACH Type</label>
                            <input type="text" id="ach_type" name="ach_type" class="form-control" value="{{ old('ach_type', $subscription->ach_type) }}" placeholder="Enter Account Type">
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_routing_number">ACH Routing Number</label>
                            <input type="text" id="ach_routing_number" name="ach_routing_number" class="form-control" value="{{ old('ach_routing_number', $subscription->ach_routing_number) }}" placeholder="Enter Routing Number">
                        </div>

                        <div class="form-group mb-3">
                            <label for="ach_account_number">ACH Account Number</label>
                            <input type="text" id="ach_account_number" name="ach_account_number" class="form-control" value="{{ old('ach_account_number', $subscription->ach_account_number) }}" placeholder="Enter Account Number">
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
</script>
@endsection
