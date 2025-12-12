@extends('admin.layout.main')
@section('title', 'Subscription Report')
@section('content')

<div class="container my-5">
    <h1 class="text-center mb-4">Subscription Report</h1>

    @php
    $total = $subscriptions->sum('subscription_plan');
    $renewCount = $subscriptions->where('status', 'Renew')->count();
    @endphp

    <!-- Summary Cards -->
    <div class="row mb-4 text-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-1">Total Subscription Amount</h5>
                    <h3 class="text-success">${{ number_format($total, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-1">Renew Count</h5>
                    <h3 class="text-primary">{{ $renewCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-2">
                <input type="text" name="plan_name" value="{{ request('plan_name') }}" class="form-control" placeholder="Plan Name">
            </div>

            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <!-- <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option> -->
                    <option value="renew" {{ request('status') == 'renew' ? 'selected' : '' }}>Renew</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>

            <!-- <div class="col-md-2">
                <select name="payment_option" class="form-control">
                    <option value="">All Payment Options</option>
                    <option value="Zelle" {{ request('payment_option') == 'Zelle' ? 'selected' : '' }}>Zelle</option>
                    <option value="ACH" {{ request('payment_option') == 'ACH' ? 'selected' : '' }}>ACH</option>
                </select>
            </div> -->

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('subscriptions.export.tier1', request()->all()) }}" class="btn btn-success w-100">Export Tier 1</a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('subscriptions.export.tier2', request()->all()) }}" class="btn btn-warning w-100">Export Tier 2</a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('subscriptions.export.tier3', request()->all()) }}" class="btn btn-danger w-100">Export Tier 3</a>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>#</th>
                    <th>Artist Name</th>
                    <th>Artist Email</th>
                    <th>Getting Plan</th>
                    <th>Updated Plan</th>
                    <!-- <th>Zelle Email</th> -->
                    <!-- <th>Zelle Phone</th> -->
                    <th>ACH Bank</th>
                    <th>ACH Account</th>
                    <th>ACH Routing</th>
                    <th>Status</th>
                    <!-- <th>Payment Option</th> -->
                </tr>
            </thead>

            <tbody>
                @forelse($subscriptions as $sub)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sub->user->name ?? 'N/A' }}</td>
                    <td>{{ $sub->user->email ?? 'N/A' }}</td>
                    <td class="text-danger">${{ $sub->subscription_plan }}</td>
                    <!-- Updated Plan -->
                    @php
                    $planName = 'No Plan';
                    $planPrice = '0';

                    // Read JSON data only once per loop
                    $path = storage_path('app/subscriptionplans.json');
                    $plans = json_decode(file_get_contents($path), true);

                    if ($sub->subscription_id) {
                    $matchedPlan = collect($plans)->firstWhere('id', (string)$sub->subscription_id);

                    if ($matchedPlan) {
                    $planName = $matchedPlan['name'];
                    $planPrice = $matchedPlan['price'];
                    }
                    }
                    @endphp
                    <td class="text-success" style="font-weight: bold;">${{ $planPrice }}</td>
                    <!-- <td>{{ $sub->zell_email ?? '-' }}</td> -->
                    <!-- <td>{{ $sub->zell_phone ?? '-' }}</td> -->
                    <td>{{ $sub->ach_bank_name ?? '-' }}</td>
                    <td>{{ $sub->ach_account_number ?? '-' }}</td>
                    <td>{{ $sub->ach_routing_number ?? '-' }}</td>
                    <td>{{ ucfirst($sub->status) }}</td>
                    <!-- <td>{{ $sub->payment_option }}</td> -->
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center text-muted">No records found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection