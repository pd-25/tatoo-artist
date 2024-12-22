@extends('admin.layout.main')

@section('title', env('APP_NAME').' | My Subscription')

@section('content')
    <div class="container my-5">
       
        
        <div class="card shadow-lg">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Subscription Details</h4>
                <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-light btn-sm">
                    Edit
                </a>
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $subscription->user->name }}</p>
                        <p><strong>Email:</strong> {{ $subscription->user->email }}</p>
                        <p><strong>Phone:</strong> 
                            {{ preg_replace('/(\d{3})(\d{3})(\d{4})/', '($1) $2-$3', $subscription->user->phone) }}
                        </p>
                        
                        <p><strong>Joining Date:</strong> {{ $subscription->user->created_at->format('m/d/Y') }}</p>
                        <p><strong>Joining By:</strong> {{ $sales->name }}</p>
                        <p><strong>Subscription Date:</strong> {{ $subscription->subscription_date?->format('m/d/Y') ?? 'Use For Trial' }}</p>
                    </div>
                    <div class="col-md-6">
                        

                        <p><strong>Plan:</strong> {{ $subscription->subscription_plan }}</p>
                        <p><strong>Status:</strong> <span class="badge bg-{{ $subscription->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($subscription->status) }}</span></p>
                        
                        <p><strong>Payment Option:</strong> {{ $subscription->payment_option }}</p>

@if($subscription->payment_option == 'zell')
    <p><strong>Zelle Email:</strong> {{ $subscription->zell_email }}</p>
    <p><strong>Zelle Phone:</strong> {{ $subscription->zell_phone }}</p>
@elseif($subscription->payment_option == 'ach')
    <p><strong>ACH Bank Name:</strong> {{ $subscription->ach_bank_name }}</p>
    <p><strong>ACH Type:</strong> {{ $subscription->ach_type }}</p>
    <p><strong>ACH Routing Number:</strong> {{ $subscription->ach_routing_number }}</p>
    <p><strong>ACH Account Number:</strong> {{ $subscription->ach_account_number }}</p>
@endif


                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
