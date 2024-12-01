@extends('admin.layout.main')
@section('title', env('APP_NAME').' | Artist-index'  )
@section('content')
    <div class="row justify-content-center">

        <div class="container my-5">
            
            <h1 class="text-center mb-4">Subscription Plans</h1>
            @if (session('error'))
    <div class="alert alert-danger  fade show" role="alert">
        {{ session('error') }}
        
    </div>
@endif
            <div class="row justify-content-center g-4">
                <!-- Starter Plan -->
                <div class="col-md-4">
                    <div class="card text-center shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title">Starter Plan</h4>
                        </div>
                        <div class="card-body">
                            <h2 class="card-price">$50</h2>
                            <p class="card-text">Perfect for individuals just starting out.</p>
                            <a href="{{ route('admin.subscriptions.create', ['plan' => 'Starter Plan - $50']) }}" class="btn btn-primary">Subscribe Now</a>
                        </div>
                    </div>
                </div>
        
                <!-- Professional Plan -->
                <div class="col-md-4">
                    <div class="card text-center shadow">
                        <div class="card-header bg-success text-white">
                            <h4 class="card-title">Professional Plan</h4>
                        </div>
                        <div class="card-body">
                            <h2 class="card-price">$100</h2>
                            <p class="card-text">Ideal for professionals looking to grow.</p>
                            <a href="{{ route('admin.subscriptions.create', ['plan' => 'Professional Plan - $100']) }}" class="btn btn-success">Subscribe Now</a>
                        </div>
                    </div>
                </div>
        
                <!-- Elite Plan -->
                <div class="col-md-4">
                    <div class="card text-center shadow">
                        <div class="card-header bg-danger text-white">
                            <h4 class="card-title">Elite Plan</h4>
                        </div>
                        <div class="card-body">
                            <h2 class="card-price">$300</h2>
                            <p class="card-text">For elite users who want the best features.</p>
                            <a href="{{ route('admin.subscriptions.create', ['plan' => 'Elite Plan - $300']) }}" class="btn btn-danger">Subscribe Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    
@endsection