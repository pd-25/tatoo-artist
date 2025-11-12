@extends('admin.layout.main')
@section('title', 'Subscription Plans')
@section('content')
<div class="container my-5">

    <h1 class="text-center mb-4">Subscription Plans</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

     @if (Auth::guard('admins')->check())
    <div class="mb-3 text-end">
        <a href="{{ route('adminsubscriptions.create') }}" class="btn btn-primary">Add New Plan</a>
        <a href="{{ route('admin.subscriptions.report') }}" class="btn btn-success">Get Report</a>
    </div>
    @endif

    <div class="row justify-content-center g-4">
        @php $colors = ['primary', 'success', 'danger']; @endphp

        @foreach ($plans as $subscription)
        @php $color = $colors[$loop->index % count($colors)]; @endphp
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-header bg-{{ $color }} text-white">
                    <h4 class="card-title">{{ $subscription['name'] }}</h4>
                </div>
                <div class="card-body">
                    <h2 class="card-price">${{ $subscription['price'] }}</h2>
                    <p class="card-text">{{ $subscription['description'] }}</p>

                    @if (Auth::guard('admins')->check())
                    <a href="{{ route('adminsubscriptions.edit', $subscription['id']) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('adminsubscriptions.destroy', $subscription['id']) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                    @else
                    <a href="{{ route('admin.subscriptions.create', ['plan' => $subscription['price']]) }}" class="btn btn-{{ $color }}">Subscribe Now</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection