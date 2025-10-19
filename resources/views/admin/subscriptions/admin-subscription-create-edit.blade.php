@extends('admin.layout.main')

@section('title', env('APP_NAME').' | Create Subscription')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-11">
        <div class="card">
            <form action="{{ isset($plan) ? route('adminsubscriptions.update', $plan['id']) : route('adminsubscriptions.store') }}" method="POST">
                @csrf
                @if(isset($plan)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label">Plan Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $plan['name'] ?? old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" value="{{ $plan['price'] ?? old('price') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $plan['description'] ?? old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">{{ isset($plan) ? 'Update Plan' : 'Create Plan' }}</button>
                <a href="{{ route('adminsubscriptions.index') }}" class="btn btn-secondary">Cancel</a>
            </form>

        </div>
    </div>
</div>
@endsection